<?php
include 'koneksi.php';

// Ambil nilai GET untuk pagination
$cari     = isset($_GET['cari']) ? $_GET['cari'] : '';
$kategori = isset($_GET['kategori']) ? $_GET['kategori'] : '';
$page     = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Pilihan jumlah item per halaman
$limitOptions = [10, 25, 50, 100];
$limit  = (isset($_GET['limit']) && in_array((int)$_GET['limit'], $limitOptions)) ? (int)$_GET['limit'] : 50;
$offset = ($page - 1) * $limit;

// Query dasar untuk pagination lama
$select_obat = "SELECT * FROM obat WHERE 1";
if (!empty($cari)) {
  $select_obat .= " AND nama_obat LIKE '%$cari%'";
}
if (!empty($kategori)) {
  $select_obat .= " AND sediaan = '$kategori'";
}
$select_obat .= " ORDER BY kode_obat ASC LIMIT $limit OFFSET $offset";
$sql_obat = mysqli_query($koneksi, $select_obat);

// Hitung total data untuk pagination
$count_query = "SELECT COUNT(*) AS total FROM obat WHERE 1";
if (!empty($cari)) {
  $count_query .= " AND nama_obat LIKE '%$cari%'";
}
if (!empty($kategori)) {
  $count_query .= " AND sediaan = '$kategori'";
}
$count_result = mysqli_fetch_assoc(mysqli_query($koneksi, $count_query));
$totalData  = $count_result['total'];
$totalPages = ceil($totalData / $limit);

// Ambil semua data sekali untuk dipakai di JS (live search)
$allObat = [];
$allQuery = mysqli_query($koneksi, "SELECT * FROM obat ORDER BY kode_obat ASC");
while ($row = mysqli_fetch_assoc($allQuery)) {
  $allObat[] = $row;
}
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SPK Apotek</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>
<body>
  <!-- NAVBAR -->
  <nav class="navbar navbar-expand-lg bg-light shadow fixed-top">
    <div class="container">
      <a class="navbar-brand fw-bold" href="#">SPK Apotek</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="index.php">Laporan Pareto</a></li>
          <li class="nav-item"><a class="nav-link" href="hitung-pareto.php">Hitung Pareto</a></li>
          <li class="nav-item fw-bold"><a class="nav-link active" href="tabel-obat.php">Data Obat</a></li>
          <li class="nav-item"><a class="nav-link" href="arsip-laporan.php">Arsip Laporan</a></li>
          <li class="nav-item"><a class="nav-link text-danger" href="logout.php">Logout</a></li>
        </ul>
      </div>
    </div>
  </nav>

    <!-- CONTENT -->
  <div class="container pt-5 mt-5">
    <h1 class="h3 text-dark mb-4">Tabel Data Obat</h1>

    <div class="row g-3 mb-4">
      <!-- BUTTON TAMBAH DATA -->
      <div class="col-md-4">
        <a href="kelola-obat.php" class="btn btn-primary w-100">
          <i class="bi bi-plus-square"></i> Tambah Data
        </a>
      </div>

      <!-- FILTER KATEGORI -->
      <div class="col-md-4">
        <select class="form-select" id="kategoriSelect" onchange="setKategori(this.value)">
          <option value="">Pilih Kategori</option>
          <?php
          $kategoriList = ['Aerosol','Gel','Inhalasi','Infus','Injeksi','Kapsul','Krim','Pil','Salep','Serbuk','Sirup','Suspensi','Tablet','Tetes','Tube'];
          foreach ($kategoriList as $item) {
            echo "<option value=\"$item\">$item</option>";
          }
          ?>
        </select>
      </div>

      <!-- SEARCH BAR -->
      <div class="col-md-4">
        <input type="text" id="searchObat" class="form-control" placeholder="Cari nama obat..." oninput="filterObat(this.value)">
      </div>
    </div>

    <!-- TABLE OBAT -->
    <div class="table-responsive">
      <table class="table table-hover table-light">
        <thead>
          <tr>
            <th>Kode Obat</th>
            <th>Nama Obat</th>
            <th>Sediaan</th>
            <th>Harga</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody id="tabelObat"></tbody>
      </table>
    </div>

    <!-- PAGINATION  -->
    <?php if ($totalPages > 1): ?>
    <nav aria-label="Page navigation">
      <ul class="pagination justify-content-center">
        <?php if ($page > 1): ?>
          <li class="page-item">
            <a class="page-link" href="?page=<?= $page - 1 ?>&limit=<?= $limit ?>">Previous</a>
          </li>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
          <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
            <a class="page-link" href="?page=<?= $i ?>&limit=<?= $limit ?>"><?= $i ?></a>
          </li>
        <?php endfor; ?>

        <?php if ($page < $totalPages): ?>
          <li class="page-item">
            <a class="page-link" href="?page=<?= $page + 1 ?>&limit=<?= $limit ?>">Next</a>
          </li>
        <?php endif; ?>
      </ul>
    </nav>
    <?php endif; ?>
  </div>

    <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    // Data obat dari PHP
    const semuaObat = <?= json_encode($allObat) ?>;
    let kategoriDipilih = '';
    let keywordDipilih = '';

    // Filter berdasarkan keyword + kategori
    function filterObat(keyword) {
      keywordDipilih = keyword.toLowerCase();
      const hasil = semuaObat.filter(obat =>
        (kategoriDipilih === '' || obat.sediaan === kategoriDipilih) &&
        obat.nama_obat.toLowerCase().includes(keywordDipilih)
      );
      renderTabel(hasil);
    }

    // Set kategori dari dropdown
    function setKategori(kat) {
      kategoriDipilih = kat;
      filterObat(document.getElementById('searchObat').value);
    }

    // Render tabel hasil filter
    function renderTabel(data) {
      const tbody = document.querySelector('#tabelObat');
      tbody.innerHTML = '';
      if (data.length === 0) {
        tbody.innerHTML = `<tr><td colspan="5" class="text-center text-dark">Data tidak ditemukan</td></tr>`;
        return;
      }
      data.forEach(obat => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
          <td>${obat.kode_obat}</td>
          <td>${obat.nama_obat}</td>
          <td>${obat.sediaan}</td>
          <td>Rp ${parseInt(obat.harga).toLocaleString()}</td>
          <td>
            <a class="btn btn-success btn-sm" href="kelola-obat.php?ubah=${obat.kode_obat}"><i class="bi bi-pencil"></i></a>
            <a class="btn btn-danger btn-sm" href="proses-obat.php?hapus=${obat.kode_obat}" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')"><i class="bi bi-trash"></i></a>
          </td>
        `;
        tbody.appendChild(tr);
      });
    }

    // Tampilkan semua data saat awal
    renderTabel(semuaObat);
  </script>
</body>
</html>