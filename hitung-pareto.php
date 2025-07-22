<?php
  include 'koneksi.php';

  $no = 0;

  // Ambil nilai GET jika ada
  $cari = isset($_GET['cari']) ? $_GET['cari'] : '';
  $kategori = isset($_GET['kategori']) ? $_GET['kategori'] : '';

  // Mulai query dasar
  $select_obat = "SELECT * FROM obat WHERE 1";

  // Tambahkan kondisi pencarian jika ada
  if (!empty($cari)) {
    $select_obat .= " AND nama_obat LIKE '%$cari%'";
  }

  // Tambahkan kondisi filter kategori jika ada
  if (!empty($kategori)) {
    $select_obat .= " AND sediaan = '$kategori'";
  }

  // Eksekusi query
  $sql_obat = mysqli_query($koneksi, $select_obat);
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
          <a class="nav-link" href="index.php">Laporan Pareto</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Hitung Pareto</a>
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
            <h1>Hitung Pareto</h1>
          </blockquote>
        </figure>
       <div class="row justify-content-between">
            <!-- BUTTON TAMBAH DATA OBAT -->
            <div class="col-4">
              <form method="GET" action="">
                <select class="form-select" name="kategori" onchange="this.form.submit()">
                        <option selected value="">Pilih Kategori</option>
                        <option value="Tablet" <?= ($kategori == "Tablet") ? 'selected' : '' ?>>Tablet</option>
                        <option value="Kapsul" <?= ($kategori == "Kapsul") ? 'selected' : '' ?> >Kapsul</option>
                        <option value="Pil" <?= ($kategori == "Pil") ? 'selected' : '' ?> >Pil</option>
                        <option value="Serbuk" <?= ($kategori == "Serbuk") ? 'selected' : '' ?> >Serbuk</option>
                        <option value="Salep" <?= ($kategori == "Salep") ? 'selected' : '' ?> >Salep</option>
                        <option value="Krim" <?= ($kategori == "Krim") ? 'selected' : '' ?> >Krim</option>
                        <option value="Gel" <?= ($kategori == "Gel") ? 'selected' : '' ?> >Gel</option>
                        <option value="Sirup" <?= ($kategori == "Sirup") ? 'selected' : '' ?> >Sirup</option>
                        <option value="Suspensi" <?= ($kategori == "Suspensi") ? 'selected' : '' ?> >Suspensi</option>
                        <option value="Injeksi" <?= ($kategori == "Injeksi") ? 'selected' : '' ?> >Injeksi</option>
                        <option value="Infus" <?= ($kategori == "Infus") ? 'selected' : '' ?> >Infus</option>
                        <option value="Tetes" <?= ($kategori == "Tetes") ? 'selected' : '' ?> >Tetes</option>
                        <option value="Inhalasi" <?= ($kategori == "Inhalasi") ? 'selected' : '' ?> >Inhalasi</option>
                        <option value="Aerosol" <?= ($kategori == "Aerosol") ? 'selected' : '' ?> >Aerosol</option>
                </select>
                </form>
            </div>
            <div class="col-4">
                <!-- FORM SEARCH -->
                <form method="GET" action="">
                    <div class="input-group">
                        <input type="text" class="form-control" name="cari" placeholder="Cari nama obat..." value="<?php if(isset($_GET['cari'])) echo $_GET['cari']; ?>">
                        <button class="btn btn-outline-light" type="submit">Cari</button>
                    </div>
                </form>
            </div>
       </div>
    <!-- AKHIR FIGURE JUDUL TABEL -->

    <?php if (!empty($kategori) || !empty($cari)) { ?>
      <div class="mt-3 text-light">
        <?php if (!empty($kategori)) : ?>
          <p>Kategori dipilih: <strong><?= $kategori ?></strong></p>
        <?php endif; ?>
        <?php if (!empty($cari)) : ?>
          <p>Hasil pencarian: <strong><?= $cari ?></strong></p>
        <?php endif; ?>
      </div>
    <?php } ?>

    <!-- TABLE OBAT DAN FORM INPUT QTY-->
     <form method="POST" action="proses-pareto.php">
       <table class="table table-hover mt-5 table-dark">
         <thead class="table-dark">
           <tr>
             <th scope="col">No</th>
             <th scope="col">Kode Obat</th>
             <th scope="col">Nama Obat</th>
             <th scope="col">Sediaan</th>
             <th scope="col">Harga</th>
             <th scope="col">Qty Terjual</th>
           </tr>
         </thead>
         <tbody class="table-group-divider">
            <?php
             while ($result = mysqli_fetch_assoc($sql_obat)) {
             
           ?>
           <tr>
             <td>
               <?php echo ++$no ?>
             </td>
             <td>
               <?php echo $result['kode_obat'] ?>
             </td>
             <td>
               <?php echo $result['nama_obat'] ?>
             </td>
             <td>
               <?php echo $result['sediaan'] ?>
             </td>
             <td>
               <?php echo $result['harga'] ?>
             </td>
             <td>
               <div class="col-md-5">
                   <input type="number" name="qty[<?= $result['kode_obat'] ?>]" class="form-control">
               </div>
             </td>
           </tr>
          <?php 
            }
   
             // ⬇ Tambahkan kode berikut setelah perulangan ⬇
               if (mysqli_num_rows($sql_obat) == 0) {
             ?>
               
               <tr>
                 <td colspan="6" class="text-center text-light">Data tidak ditemukan</td>
               </tr>
           <?php
             }
           ?>
         </tbody>
       </table>
       <!-- Akhir Tabel -->
       <div class="container text-center mt-4 mb-4">
           <div class="row">
               <div class="col-9"></div>
               <div class="col-3">
                   <button type="submit" class="btn btn-success">
                   <i class="bi bi-clipboard-data"></i>
                   Hitung Pareto
                   </button>
               </div>
           </div>
       </div>
     </form>



    </div>
<!-- Bootsrap CDN -->
 <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js" integrity="sha384-7qAoOXltbVP82dhxHAUje59V5r2YsVfBafyUDxEdApLPmcdhBPg1DKg1ERo0BZlK" crossorigin="anonymous"></script>
</body>
</html>