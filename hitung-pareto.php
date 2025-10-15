<?php
include 'koneksi.php';

$no = 0;
$cari = isset($_GET['cari']) ? $_GET['cari'] : '';
$kategori = isset($_GET['kategori']) ? $_GET['kategori'] : '';

// Query dasar
$select_obat = "SELECT * FROM obat WHERE 1";
if (!empty($cari)) {
  $select_obat .= " AND nama_obat LIKE '%$cari%'";
}
if (!empty($kategori)) {
  $select_obat .= " AND sediaan = '$kategori'";
}
$sql_obat = mysqli_query($koneksi, $select_obat);
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
      <ul class="nav nav-pills ms-auto">
        <li class="nav-item"><a class="nav-link" href="index.php">Laporan Pareto</a></li>
        <li class="nav-item"><a class="nav-link active" href="#">Hitung Pareto</a></li>
        <li class="nav-item"><a class="nav-link" href="tabel-obat.php">Data Obat</a></li>
      </ul>
    </div>
  </nav>

  <!-- CONTENT -->
  <div class="container pt-5 mt-5">
    <figure class="text-dark">
      <blockquote class="blockquote">
        <h1 class="h3">Hitung Pareto</h1>
      </blockquote>
    </figure>

    <div class="row g-3 mb-4">
      <!-- FILTER KATEGORI -->
      <div class="col-md-6">
        <form method="GET" action="">
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
      <div class="col-md-6">
        <form method="GET" action="">
          <div class="input-group">
            <input type="text" class="form-control" name="cari" placeholder="Cari nama obat..." value="<?= htmlspecialchars($cari) ?>">
            <button class="btn btn-outline-light" type="submit">Cari</button>
          </div>
        </form>
      </div>
    </div>

    <!-- FEEDBACK PILIHAN -->
    <?php if (!empty($kategori) || !empty($cari)): ?>
    <div class="text-dark mb-3">
      <?php if (!empty($kategori)): ?>
        <p>Kategori dipilih: <strong><?= htmlspecialchars($kategori) ?></strong></p>
      <?php endif; ?>
      <?php if (!empty($cari)): ?>
        <p>Hasil pencarian: <strong><?= htmlspecialchars($cari) ?></strong></p>
      <?php endif; ?>
    </div>
    <?php endif; ?>

    <!-- TABLE OBAT + INPUT QTY -->
    <form method="POST" action="proses-pareto.php">
      <div class="table-responsive">
        <table class="table table-hover table-light">
          <thead>
            <tr>
              <th>No</th>
              <th>Kode Obat</th>
              <th>Nama Obat</th>
              <th>Sediaan</th>
              <th>Harga</th>
              <th>Qty Terjual</th>
            </tr>
          </thead>
          <tbody>
            <?php if (mysqli_num_rows($sql_obat) > 0): ?>
              <?php while ($result = mysqli_fetch_assoc($sql_obat)): ?>
              <tr>
                <td><?= ++$no ?></td>
                <td><?= htmlspecialchars($result['kode_obat']) ?></td>
                <td><?= htmlspecialchars($result['nama_obat']) ?></td>
                <td><?= htmlspecialchars($result['sediaan']) ?></td>
                <td>Rp <?= number_format($result['harga'], 0, ',', '.') ?></td>
                <td>
                  <input type="number" name="qty[<?= $result['kode_obat'] ?>]" class="form-control form-control-sm w-100" min="0">
                </td>
              </tr>
              <?php endwhile; ?>
            <?php else: ?>
              <tr>
                <td colspan="6" class="text-center text-dark">Data tidak ditemukan</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>

      <div class="text-end mt-4">
        <button type="submit" class="btn btn-success">
          <i class="bi bi-clipboard-data"></i> Hitung Pareto
        </button>
      </div>
    </form>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>