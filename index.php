<?php
  include 'koneksi.php'
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<html lang="en">
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
            <tr>
              <th scope="row">
                  PI KANG SUANG
              </th>

              <td class="text-center">
                Salep
              </td>

              <td class="text-center">
                30000
              </td>
                
              <td class="text-center">
                100
              </td>

              <td class="text-center">
                300000
              </td>
              
              <td class="text-center">
                100%
              </td>
                
              <td class="text-center">
                100%
              </td>
              <td class="text-center">
                A
              </td>
            </tr>

            <tr>
              <th colspan="4" class="text-center">Total</th>
              <td class="text-center">300000</td>
              <td class="text-center">100%</td>
              <td class="text-center">100%</td>
              <td class="text-center">  </td>
            </tr>
        </tbody>
        </table>
        <!-- AKHIR TABLE PARETO -->

        <!-- TABLE PARETO 2 -->
        <table class="table table-hover mt-5 table-dark">
            <thead class="table-dark">
            <tr>
            <th scope="col">Kelompok</th>
            <th scope="col">Item %</th>
            <th scope="col">Presentase</th>
            </tr>
        </thead>
        <tbody class="table-group-divider">
            <tr>
            <th scope="row">
                A
            </th>

            <td>
            </td>

            <td>
            </td>

            <td>
            </td>

            <td>
            </td>
            
            <td>
            </td>

            </tr>
        </tbody>
        </table>
        <!-- AKHIR TABLE PARETO 2-->
    </div>
<!-- Bootsrap CDN -->
 <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js" integrity="sha384-7qAoOXltbVP82dhxHAUje59V5r2YsVfBafyUDxEdApLPmcdhBPg1DKg1ERo0BZlK" crossorigin="anonymous"></script>
</body>
</html>