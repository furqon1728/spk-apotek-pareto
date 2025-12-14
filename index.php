<?php
include 'koneksi.php';
session_start();
if (!isset($_SESSION['login'])) {
  header("Location: login.php");
  exit;
}

$dataPareto = $_SESSION['pareto'] ?? [];
$totalSemua = array_sum(array_column($dataPareto, 'total'));
$adaData = $totalSemua > 0;
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
          <li class="nav-item fw-bold"><a class="nav-link active" href="index.php">Laporan Pareto</a></li>
          <li class="nav-item"><a class="nav-link" href="hitung-pareto.php">Hitung Pareto</a></li>
          <li class="nav-item"><a class="nav-link" href="tabel-obat.php">Data Obat</a></li>
          <li class="nav-item"><a class="nav-link" href="arsip-laporan.php">Arsip Laporan</a></li>
          <li class="nav-item"><a class="nav-link text-danger" href="logout.php">Logout</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- CONTENT -->
  <div class="container pt-5 mt-5">
    <figure class="text-dark">
      <blockquote class="blockquote">
        <h1 class="h3">Laporan Pareto</h1>
        <p>Berisi Data Obat berdasarkan kelas prioritas</p>
      </blockquote>
    </figure>

    <?php if ($adaData): ?>
    <div class="table-responsive">
      <table class="table table-hover table-light mt-4">
        <thead>
          <tr class="text-center">
            <th>Nama Produk</th>
            <th>Sediaan</th>
            <th>Harga</th>
            <th>Qty Penjualan</th>
            <th>Total Penjualan</th>
            <th>Presentase</th>
            <th>Akumulasi</th>
            <th>Kelompok</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $totalPersen = 0;
          $totalAkumulasi = 0;
          foreach ($dataPareto as $i => $row):
            $totalPersen += $row['persen'];
            if ($i === array_key_last($dataPareto)) {
              $sisa = round(100 - $row['akumulasi'], 2);
              $row['akumulasi'] += $sisa;
              $totalPersen += $sisa;
            }
            $totalAkumulasi = $row['akumulasi'];
          ?>
          <tr>
            <td><?= $row['nama'] ?></td>
            <td class="text-center"><?= $row['sediaan'] ?></td>
            <td class="text-center">Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>
            <td class="text-center"><?= $row['qty'] ?></td>
            <td class="text-center">Rp <?= number_format($row['total'], 0, ',', '.') ?></td>
            <td class="text-center"><?= $row['persen'] ?>%</td>
            <td class="text-center"><?= round($row['akumulasi'], 2) ?>%</td>
            <td class="text-center"><?= $row['kelompok'] ?></td>
          </tr>
          <?php endforeach; ?>
          <tr>
            <th colspan="4" class="text-center">Total</th>
            <td class="text-center">Rp <?= number_format($totalSemua, 0, ',', '.') ?></td>
            <td class="text-center"><strong><?= round($totalPersen, 2) ?>%</strong></td>
            <td class="text-center"><strong><?= round($totalAkumulasi, 2) ?>%</strong></td>
            <td></td>
          </tr>
        </tbody>
      </table>
    </div>

    <?php
    $grupStats = ['A' => ['item' => 0, 'persen' => 0], 'B' => ['item' => 0, 'persen' => 0], 'C' => ['item' => 0, 'persen' => 0]];
    foreach ($dataPareto as $row) {
      $grupStats[$row['kelompok']]['item']++;
      $grupStats[$row['kelompok']]['persen'] += $row['persen'];
    }
    $totalItem = count($dataPareto);
    ?>

    <div class="alert alert-secondary mt-4">
      <strong>Penjelasan Kategori Pareto:</strong><br>
      <ul>
        <li><strong>Kategori A</strong>: Obat yang menyumbang ±80% penjualan, walau jumlahnya sedikit.</li>
        <li><strong>Kategori B</strong>: Obat yang menyumbang ±15% penjualan.</li>
        <li><strong>Kategori C</strong>: Obat yang menyumbang sisanya ±5%, jumlahnya bisa banyak tapi nilai kecil.</li>
      </ul>
    </div>

    <div class="table-responsive">
      <table class="table table-hover table-light mt-4">
        <thead>
          <tr>
            <th>Kategori Prioritas</th>
            <th>Persentase Jumlah Obat</th>
            <th>Kontribusi Terhadap Penjualan</th>
            <th>Penjelasan</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($grupStats as $kelompok => $stat):
            $itemPersen = round(($stat['item'] / $totalItem) * 100, 2);
            $persenNilai = round($stat['persen'], 2);
          ?>
          <tr>
            <td>
              <?php
              if ($kelompok == 'A') echo 'A (Sangat Penting)';
              elseif ($kelompok == 'B') echo 'B (Sedang)';
              else echo 'C (Rendah)';
              ?>
            </td>
            <td class="text-center"><?= $itemPersen ?>%</td>
            <td class="text-center"><?= $persenNilai ?>%</td>
            <td>
              <?php
              if ($kelompok == 'A') echo 'Obat paling laris, nilai penjualan tinggi';
              elseif ($kelompok == 'B') echo 'Obat sedang laris, nilai penjualan menengah';
              else echo 'Obat kurang laris, kontribusi kecil';
              ?>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <a href="export-excel.php" class="btn btn-warning mt-3 mb-3">
      <i class="bi bi-file-earmark-excel"></i> Simpan Laporan
    </a>

    <?php else: ?>
    <div class="alert alert-warning mt-4">
      <strong>Data Belum Tersedia</strong><br>
      Silakan lakukan perhitungan pareto terlebih dahulu di halaman
      <a href="hitung-pareto.php" class="alert-link">Hitung Pareto</a>
    </div>
    <?php endif; ?>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>