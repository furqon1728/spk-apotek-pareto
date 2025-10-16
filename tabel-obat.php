<?php
include 'koneksi.php';

// Ambil nilai GET
$cari = isset($_GET['cari']) ? $_GET['cari'] : '';
$kategori = isset($_GET['kategori']) ? $_GET['kategori'] : '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Pilihan jumlah item per halaman
$limitOptions = [10, 25, 50, 100];
$limit = isset($_GET['limit']) && in_array((int)$_GET['limit'], $limitOptions) ? (int)$_GET['limit'] : 50;
$offset = ($page - 1) * $limit;

// Query dasar
$select_obat = "SELECT * FROM obat WHERE 1";

// Filter pencarian
if (!empty($cari)) {
  $select_obat .= " AND nama_obat LIKE '%$cari%'";
}

// Filter kategori
if (!empty($kategori)) {
  $select_obat .= " AND sediaan = '$kategori'";
}

// Urutkan dan batasi data
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
$totalData = $count_result['total'];
$totalPages = ceil($totalData / $limit);

?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SPK Apotek</title>
  <!-- Bootstrap CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>
<body>
  <!-- NAVBAR -->
  <nav class="navbar navbar-expand-lg bg-light shadow fixed-top">
    <div class="container">
      <a class="navbar-brand fw-bold" href="#">SPK Apotek</a>

      <!-- Tombol Burger -->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Menu yang akan collapse -->
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="index.php">Laporan Pareto</a></li>
          <li class="nav-item"><a class="nav-link" href="hitung-pareto.php">Hitung Pareto</a></li>
          <li class="nav-item fw-bold"><a class="nav-link active" href="tabel-obat.php">Data Obat</a></li>
          <li class="nav-item"><a class="nav-link text-danger" href="logout.php">Logout</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- CONTENT -->
  <div class="container pt-5 mt-5">
    <figure class="text-dark">
      <blockquote class="blockquote">
        <h1 class="h3">Tabel Data Obat</h1>
      </blockquote>
    </figure>

    <div class="row g-3 mb-4">
      <!-- BUTTON TAMBAH DATA -->
      <div class="col-md-4">
        <a href="kelola-obat.php" class="btn btn-primary w-100">
          <i class="bi bi-plus-square"></i> Tambah Data
        </a>
      </div>

      <!-- FILTER KATEGORI -->
      <div class="col-md-4">
        <form method="GET" action="">
          <input type="hidden" name="limit" value="<?= $limit ?>">
          <input type="hidden" name="cari" value="<?= htmlspecialchars($cari) ?>">
          <select class="form-select" name="kategori" onchange="this.form.submit()">
            <option value="">Pilih Kategori</option>
            <?php
            $kategoriList = ['Tablet','Kapsul','Pil','Serbuk','Salep','Krim','Gel','Sirup','Suspensi','Injeksi','Infus','Tetes','Inhalasi','Aerosol'];
            foreach ($kategoriList as $item) {
              $selected = ($kategori == $item) ? 'selected' : '';
              echo "<option value=\"$item\" $selected>$item</option>";
            }
            ?>
          </select>
        </form>
      </div>

      <!-- FORM SEARCH -->
      <div class="col-md-4">
        <form method="GET" action="">
          <input type="hidden" name="limit" value="<?= $limit ?>">
          <input type="hidden" name="kategori" value="<?= htmlspecialchars($kategori) ?>">
          <div class="input-group">
            <input type="text" class="form-control" name="cari" placeholder="Cari nama obat..." value="<?= htmlspecialchars($cari) ?>">
            <button class="btn btn-outline-light" type="submit">Cari</button>
          </div>
        </form>
      </div>
    </div>

    <!-- PILIHAN JUMLAH ITEM -->
    <form method="GET" action="" class="mb-3">
      <input type="hidden" name="kategori" value="<?= htmlspecialchars($kategori) ?>">
      <input type="hidden" name="cari" value="<?= htmlspecialchars($cari) ?>">
      <label class="text-dark me-2">Tampilkan:</label>
      <select name="limit" onchange="this.form.submit()" class="form-select d-inline-block w-auto">
        <?php foreach ($limitOptions as $opt): ?>
          <option value="<?= $opt ?>" <?= ($limit == $opt) ? 'selected' : '' ?>><?= $opt ?> item</option>
        <?php endforeach; ?>
      </select>
    </form>

    <!-- FEEDBACK PILIHAN -->
    <?php if (!empty($kategori) || !empty($cari)): ?>
    <div class="text-dark mb-3">
      <?php if (!empty($kategori)): ?>
        <p>Kategori dipilih: <strong><?= htmlspecialchars($kategori) ?></strong></p>
        <a href="tabel-obat.php" class="btn btn-secondary btn-sm">Reset Filter</a>
      <?php endif; ?>
      <?php if (!empty($cari)): ?>
        <p>Hasil pencarian: <strong><?= htmlspecialchars($cari) ?></strong></p>
      <?php endif; ?>
    </div>
    <?php endif; ?>

    <!-- TABLE OBAT -->
    <div class="table-responsive">
      <table class="table table-hover table-white">
        <thead>
          <tr>
            <th>Kode Obat</th>
            <th>Nama Obat</th>
            <th>Sediaan</th>
            <th>Harga</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php if (mysqli_num_rows($sql_obat) > 0): ?>
            <?php while ($result = mysqli_fetch_assoc($sql_obat)): ?>
            <tr>
              <td><?= htmlspecialchars($result['kode_obat']) ?></td>
              <td><?= htmlspecialchars($result['nama_obat']) ?></td>
              <td><?= htmlspecialchars($result['sediaan']) ?></td>
              <td>Rp <?= number_format($result['harga'], 0, ',', '.') ?></td>
              <td>
                <a class="btn btn-success btn-sm" href="kelola-obat.php?ubah=<?= $result['kode_obat'] ?>"><i class="bi bi-pencil"></i></a>
                <a class="btn btn-danger btn-sm" href="proses-obat.php?hapus=<?= $result['kode_obat'] ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')"><i class="bi bi-trash"></i></a>
              </td>
            </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr>
              <td colspan="5" class="text-center text-dark">Data tidak ditemukan</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <!-- PAGINATION -->
    <?php if ($totalPages > 1): ?>
    <nav aria-label="Page navigation">
      <ul class="pagination justify-content-center">
        <?php if ($page > 1): ?>
          <li class="page-item">
            <a class="page-link" href="?page=<?= $page - 1 ?>&limit=<?= $limit ?>&kategori=<?= urlencode($kategori) ?>&cari=<?= urlencode($cari) ?>">Previous</a>
          </li>
        <?php endif; ?>
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
          <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
            <a class="page-link" href="?page=<?= $i ?>&limit=<?= $limit ?>&kategori=<?= urlencode($kategori) ?>&cari=<?= urlencode($cari) ?>"><?= $i ?></a>
          </li>
        <?php endfor; ?>
        <?php if ($page < $totalPages): ?>
          <li class="page-item">
            <a class="page-link" href="?page=<?= $page + 1 ?>&limit=<?= $limit ?>&kategori=<?= urlencode($kategori) ?>&cari=<?= urlencode($cari) ?>">Next</a>
          </li>
        <?php endif; ?>
      </ul>
    </nav>
    <?php endif; ?>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>