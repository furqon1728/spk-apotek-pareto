<?php
include 'koneksi.php';

// Ambil nilai GET
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Pilihan jumlah item per halaman
$limitOptions = [10, 25, 50, 100];
$limit = isset($_GET['limit']) && in_array((int)$_GET['limit'], $limitOptions)
    ? (int)$_GET['limit']
    : 25;

$offset = ($page - 1) * $limit;

// Ambil filter GET
$bulan  = isset($_GET['bulan'])  ? $_GET['bulan']  : '';
$tahun  = isset($_GET['tahun'])  ? $_GET['tahun']  : '';
$dari   = isset($_GET['dari'])   ? $_GET['dari']   : '';
$sampai = isset($_GET['sampai']) ? $_GET['sampai'] : '';

// Base query
$where = "WHERE 1";

// Filter rentang tanggal
if (!empty($dari) && !empty($sampai)) {
    $where .= " AND DATE(tanggal) BETWEEN '$dari' AND '$sampai'";
} elseif (!empty($dari)) {
    $where .= " AND DATE(tanggal) >= '$dari'";
} elseif (!empty($sampai)) {
    $where .= " AND DATE(tanggal) <= '$sampai'";
}

// Filter bulan
if (!empty($bulan)) {
    $where .= " AND MONTH(tanggal) = '$bulan'";
}

// Filter tahun
if (!empty($tahun)) {
    $where .= " AND YEAR(tanggal) = '$tahun'";
}

// Query data arsip
$query = "SELECT * FROM arsip_laporan $where ORDER BY tanggal DESC LIMIT $limit OFFSET $offset";
$sql = mysqli_query($koneksi, $query);

// Hitung total data untuk pagination
$count_query = "SELECT COUNT(*) AS total FROM arsip_laporan $where";
$count_result = mysqli_fetch_assoc(mysqli_query($koneksi, $count_query));
$totalData = $count_result['total'];
$totalPages = ceil($totalData / $limit);
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Arsip Laporan Pareto</title>

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
        <li class="nav-item"><a class="nav-link" href="tabel-obat.php">Data Obat</a></li>
        <li class="nav-item fw-bold"><a class="nav-link active" href="arsip-laporan.php">Arsip Laporan</a></li>
        <li class="nav-item"><a class="nav-link text-danger" href="logout.php">Logout</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- CONTENT -->
<div class="container pt-5 mt-5">
  <h1 class="h3 text-dark mb-4">Arsip Laporan Pareto</h1>

  <!-- Form utama -->
  <form method="GET" class="row g-3 mb-4" id="filterForm">

    <!-- PILIH BULAN -->
    <div class="col-md-3">
      <label class="form-label text-dark">Pilih Bulan</label>
      <select name="bulan" class="form-select">
        <option value="">Semua Bulan</option>
        <?php
        for ($m = 1; $m <= 12; $m++) {
          $selected = (isset($_GET['bulan']) && $_GET['bulan'] == $m) ? 'selected' : '';
          echo "<option value='$m' $selected>" . date('F', mktime(0, 0, 0, $m, 1)) . "</option>";
        }
        ?>
      </select>
    </div>

    <!-- PILIH TAHUN -->
    <div class="col-md-3">
      <label class="form-label text-dark">Pilih Tahun</label>
      <select name="tahun" class="form-select">
        <option value="">Semua Tahun</option>
        <?php
        $tahunSekarang = date('Y');
        for ($t = $tahunSekarang; $t >= $tahunSekarang - 5; $t--) {
          $selected = (isset($_GET['tahun']) && $_GET['tahun'] == $t) ? 'selected' : '';
          echo "<option value='$t' $selected>$t</option>";
        }
        ?>
      </select>
    </div>

    <!-- DARI TANGGAL -->
    <div class="col-md-3">
      <label class="form-label text-dark">Dari Tanggal</label>
      <input type="date" name="dari" class="form-control"
            value="<?= isset($_GET['dari']) ? $_GET['dari'] : '' ?>">
    </div>

    <!-- SAMPAI TANGGAL -->
    <div class="col-md-3">
      <label class="form-label text-dark">Sampai Tanggal</label>
      <input type="date" name="sampai" class="form-control"
            value="<?= isset($_GET['sampai']) ? $_GET['sampai'] : '' ?>">
    </div>

    <!-- PILIH LIMIT -->
    <div class="col-md-3">
      <label class="form-label text-dark">Tampilkan</label>
      <select name="limit" class="form-select" onchange="submitForm()">
        <?php foreach ($limitOptions as $opt): ?>
          <option value="<?= $opt ?>" <?= ($limit == $opt) ? 'selected' : '' ?>><?= $opt ?> item</option>
        <?php endforeach; ?>
      </select>
    </div>

    <!-- TOMBOL FILTER -->
    <div class="col-md-3 d-flex align-items-end">
      <button class="btn btn-primary w-100" type="submit">Filter</button>
    </div>

  </form>

    <!-- Info filter aktif -->
     <?php if (!empty($dari) || !empty($sampai)): ?>
      <div class="alert alert-info">
        <strong>Filter aktif:</strong>
        <?= !empty($dari) ? "Dari <b>$dari</b>" : "" ?>
        <?= !empty($sampai) ? "Sampai <b>$sampai</b>" : "" ?>
      </div>
      <?php endif; ?>

    <!-- Tabel Laporan -->
    <form method="POST" action="hapus-bulk.php" id="bulkForm">

    <button type="submit" class="btn btn-danger mb-3"
            onclick="return confirm('Yakin ingin menghapus semua laporan terpilih?')">
      <i class="bi bi-trash"></i> Hapus Terpilih
    </button>

    <div class="table-responsive">
      <table class="table table-hover table-light">
        <thead>
          <tr>
            <th>
              <input type="checkbox" id="checkAll" class="form-check-input mt-0">
            </th>
            <th>No</th>
            <th>Nama File</th>
            <th>Tanggal Dibuat</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $no = $offset + 1;
          if (mysqli_num_rows($sql) > 0):
            while ($row = mysqli_fetch_assoc($sql)):
          ?>
          <tr>
            <td>
              <input type="checkbox" name="selected[]" value="<?= $row['id'] ?>" class="checkItem form-check-input mt-0">
            </td>
            <td><?= $no++ ?></td>
            <td><?= htmlspecialchars($row['nama_file']) ?></td>
            <td><?= date('d M Y - H:i:s', strtotime($row['tanggal'])) ?></td>
            <td>
              <a class="btn btn-success btn-sm" href="<?= $row['path'] ?>" download>
                <i class="bi bi-download"></i> Download
              </a>

              <a class="btn btn-danger btn-sm"
                href="hapus-arsip.php?id=<?= $row['id'] ?>"
                onclick="return confirm('Yakin ingin menghapus laporan ini?')">
                  <i class="bi bi-trash"></i> Hapus
              </a>
            </td>
          </tr>
          <?php
            endwhile;
          else:
          ?>
          <tr>
            <td colspan="5" class="text-center text-dark">Belum ada arsip laporan</td>
          </tr>
          <?php endif; ?>
        </tbody>
      </table>
      </form>

      <!-- Pagination -->
      <?php if ($totalPages > 1): ?>
        <nav aria-label="Page navigation">
          <ul class="pagination justify-content-center">

            <?php if ($page > 1): ?>
              <li class="page-item">
                <a class="page-link"
                  href="?page=<?= $page - 1 ?>&limit=<?= $limit ?>&bulan=<?= $bulan ?>&tahun=<?= $tahun ?>&dari=<?= $dari ?>&sampai=<?= $sampai ?>">
                  Previous
                </a>
              </li>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
              <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                <a class="page-link"
                  href="?page=<?= $i ?>&limit=<?= $limit ?>&bulan=<?= $bulan ?>&tahun=<?= $tahun ?>&dari=<?= $dari ?>&sampai=<?= $sampai ?>">
                  <?= $i ?>
                </a>
              </li>
            <?php endfor; ?>

            <?php if ($page < $totalPages): ?>
              <li class="page-item">
                <a class="page-link"
                  href="?page=<?= $page + 1 ?>&limit=<?= $limit ?>&bulan=<?= $bulan ?>&tahun=<?= $tahun ?>&dari=<?= $dari ?>&sampai=<?= $sampai ?>">
                  Next
                </a>
              </li>
            <?php endif; ?>

          </ul>
        </nav>
        <?php endif; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
<script>
   function submitForm() {
    document.getElementById('filterForm').submit();
  }

  document.getElementById('checkAll').addEventListener('change', function() {
    let items = document.querySelectorAll('.checkItem');
    items.forEach(i => i.checked = this.checked);
  });

</script>
</body>
</html>