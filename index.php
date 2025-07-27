<?php
  include 'koneksi.php'
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPK Apotek</title>
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    
</head>
<body>
    <!-- NAVBAR -->
  <nav class="navbar bg-body-tertiary mb-5 shadow fixed-top">
    <div class="container">
      <a class="navbar-brand" href="#" style="font-size : 1.1em;">
        <strong>SPK Apotek</strong>
      </a>

      <!-- TAB PILIHAN -->
      <ul class="nav nav-pills">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Laporan Pareto</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="hitung-pareto.php">Hitung Pareto</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="tabel-obat.php">Data Obat</a>
        </li>
        </ul>
        <!-- AKHIR TAB PILIHAN -->
      </div>
    </nav>
    <!-- AKHIR NAVBAR -->

    <div class="container mt-5 pt-4">
        <!-- Figure JUDUL TABEL -->
        <figure class="text-light">
        <blockquote class="blockquote">
            <h1>Laporan Pareto</h1>
            <p>Berisi Data Obat berdasarkan kelas prioritas</p>
        </blockquote>
        </figure>
        <!-- AKHIR FIGURE JUDUL TABEL -->
        <?php
        session_start();
        $dataPareto = $_SESSION['pareto'] ?? [];
        $totalSemua = array_sum(array_column($dataPareto, 'total'));
        ?>
        <!-- TABLE PARETO -->
        <table class="table table-hover mt-5 table-dark">
            <thead class="table-dark">
            <tr class="text-center">
            <th scope="col">Nama Produk</th>
            <th scope="col">Sediaan</th>
            <th scope="col">Harga</th>
            <th scope="col">Qty Penjualan</th>
            <th scope="col">Total Penjualan</th>
            <th scope="col">Presentase</th>
            <th scope="col">Akumulasi</th>
            <th scope="col">Kelompok</th>
            </tr>
        </thead>
        <tbody class="table-group-divider">
          <?php
          $totalPersen = 0;
          $totalAkumulasi = 0;

          foreach ($dataPareto as $i => $row): 
            $totalPersen += $row['persen'];

            if ($i === array_key_last($dataPareto)) {
              $sisa = round(100 - $row['akumulasi'], 2);
              $row['akumulasi'] += $sisa;
              $totalPersen += $sisa; // Koreksi juga total persen
            }

            $totalAkumulasi = $row['akumulasi'];
          ?>
          <tr>
            <td><?= $row['nama'] ?></td>
            <td class="text-center"><?= $row['sediaan'] ?></td>
            <td class="text-center">Rp<?= number_format($row['harga'], 0, ',', '.') ?></td>
            <td class="text-center"><?= $row['qty'] ?></td>
            <td class="text-center">Rp<?= number_format($row['total'], 0, ',', '.') ?></td>
            <td class="text-center"><?= $row['persen'] ?>%</td>
            <td class="text-center"><?= round($row['akumulasi'], 2) ?>%</td>
            <td class="text-center"><?= $row['kelompok'] ?></td>
          </tr>
          <?php
          endforeach;
          ?>

            <tr>
              <th colspan="4" class="text-center">Total</th>
              <td class="text-center">Rp<?= number_format($totalSemua, 0, ',', '.') ?></td>
              <td class="text-center"><strong><?= round($totalPersen, 2) ?>%</strong></td>
              <td class="text-center"><strong><?= round($totalAkumulasi, 2) ?>%</strong></td>
              <td class="text-center"></td>
            </tr>
        </tbody>
        </table>
        <!-- AKHIR TABLE PARETO -->

        <?php
        $grupStats = [
          'A' => ['item' => 0, 'persen' => 0],
          'B' => ['item' => 0, 'persen' => 0],
          'C' => ['item' => 0, 'persen' => 0]
        ];

        foreach ($dataPareto as $row) {
          $grupStats[$row['kelompok']]['item']++;
          $grupStats[$row['kelompok']]['persen'] += $row['persen'];
        }
        $totalItem = count($dataPareto);
        ?>

        <div class="alert alert-info mt-4">
          <strong>Penjelasan Kategori Pareto:</strong><br>
          • <strong>Kategori A</strong>: Obat yang menyumbang ±80% penjualan, walau jumlahnya sedikit.<br>
          • <strong>Kategori B</strong>: Obat yang menyumbang ±15% penjualan.<br>
          • <strong>Kategori C</strong>: Obat yang menyumbang sisanya ±5%, jumlahnya bisa banyak tapi nilai kecil.
        </div>

        <!-- TABLE PARETO 2 -->
        <table class="table table-hover mt-5 table-dark">
            <thead class="table-dark">
            <tr>
              <th scope="col">Kategori Prioritas</th>
              <th scope="col">Persentase Jumlah Obat</th>
              <th scope="col">Kontribusi Terhadap Penjualan</th>
              <th scope="col">Penjelasan</th>
            </tr>
        </thead>
        <tbody class="table-group-divider">
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
        <!-- AKHIR TABLE PARETO 2-->
         
        <a href="export-excel.php" class="btn btn-warning mt-3 mb-3">
          <i class="bi bi-file-earmark-excel"></i> Unduh xls
        </a>

    </div>
<!-- Bootsrap CDN -->
 <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js" integrity="sha384-7qAoOXltbVP82dhxHAUje59V5r2YsVfBafyUDxEdApLPmcdhBPg1DKg1ERo0BZlK" crossorigin="anonymous"></script>
</body>
</html>