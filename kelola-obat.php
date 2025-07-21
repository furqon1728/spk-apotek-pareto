<?php
  include 'koneksi.php';

  $kode_obat = '';
  $nama_obat = '';
  $sediaan = '';
  $harga = '';

   if (isset($_GET['ubah'])) {
    $kode_obat = $_GET['ubah'];

    $query = "SELECT * FROM obat WHERE kode_obat = '$kode_obat';";
    $sql = mysqli_query($koneksi, $query);

    $result = mysqli_fetch_assoc($sql);

    $nama_obat = $result['nama_obat'];
    $sediaan = $result['sediaan'];
    $harga = $result['harga'];

   };
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

      </div>
    </nav>
    <!-- AKHIR NAVBAR -->

    <!-- CONTAINER BODY CONTENT -->
    <div class="container mt-5 pt-4">
        <!-- Figure JUDUL TABEL -->
        <figure class="text-light">
        <blockquote class="blockquote">
            <h1>Data Obat</h1>
        </blockquote>
        </figure>
        <!-- AKHIR FIGURE JUDUL TABEL -->

        <!-- CONTAINER FORM -->
        <div class="container text-light mt-5">
            <form method="POST" action="proses-obat.php" >

            <div class="mb-3 row">
                <label for="inputKodeObat" class="col-sm-2 col-form-label">Kode Obat</label>
                <div class="col-sm-10">
                    <input required type="text" class="form-control" id="inputKodeObat" name="inputKodeObat" placeholder="Masukkan Kode Obat" value="<?php echo $kode_obat ?>">
                </div>
            </div>
        
            <div class="mb-3 row">
                <label for="inputNamaObat" class="col-sm-2 col-form-label">Nama Obat</label>
                <div class="col-sm-10">
                    <input required type="text" class="form-control" id="inputNamaObat" name="inputNamaObat" placeholder="Masukkan Nama Obat" value="<?php echo $nama_obat ?>">
                </div>
            </div>
            
            <div class="mb-3 row">
                <label for="inputSediaan" class="col-sm-2 col-form-label">Sediaan</label>
                <div class="col-sm-10">
                    <select required class="form-select" id="inputSediaan" name="inputSediaan">
                    <option>Sediaan</option>
                    <option <?php if ($sediaan == 'Tablet'){echo "selected";}?> value="Tablet">Tablet</option>
                    <option <?php if ($sediaan == 'Kapsul'){echo "selected";}?> value="Kapsul">Kapsul</option>
                    <option <?php if ($sediaan == 'Pil'){echo "selected";}?> value="Pil">Pil</option>
                    <option <?php if ($sediaan == 'Serbuk'){echo "selected";}?> value="Serbuk">Serbuk</option>
                    <option <?php if ($sediaan == 'Salep'){echo "selected";}?> value="Salep">Salep</option>
                    <option <?php if ($sediaan == 'Krim'){echo "selected";}?> value="Krim">Krim</option>
                    <option <?php if ($sediaan == 'Gel'){echo "selected";}?> value="Gel">Gel</option>
                    <option <?php if ($sediaan == 'Sirup'){echo "selected";}?> value="Sirup">Sirup</option>
                    <option <?php if ($sediaan == 'Suspensi'){echo "selected";}?> value="Suspensi">Suspensi</option>
                    <option <?php if ($sediaan == 'Injeksi'){echo "selected";}?> value="Injeksi">Injeksi</option>
                    <option <?php if ($sediaan == 'Infuus'){echo "selected";}?> value="Infus">Infus</option>
                    <option <?php if ($sediaan == 'Tetes'){echo "selected";}?> value="Tetes">Tetes</option>
                    <option <?php if ($sediaan == 'Inhalasi'){echo "selected";}?> value="Inhalasi">Inhalasi</option>
                    <option <?php if ($sediaan == 'Aerosol'){echo "selected";}?> value="Aerosol">Aerosol</option>
                    </select>
                </div>
            </div>
            
            <div class="mb-3 row">
                <label for="inputharga" class="col-sm-2 col-form-label">Harga</label>
                    <div class="col-sm-10">
                        <input required type="text" class="form-control" id="inputHarga" name="inputHarga" placeholder="Masukkan Harga" value="<?php echo $harga ?>">
                    </div>
            </div>
            
            <div class="mb-3 row mt-5">
                <!-- BUTTON TAMBAH DATA MAHASISWA -->
                <div class="col">
                <?php
                    if (isset($_GET['ubah'])) {
                ?>
                <button type="submit" name="aksi" value="edit" class="btn btn-success active">
                    <i class="bi bi-save2"></i>
                    Simpan Perubahan
                </button>
                <?php
                } else {
                    ?>
                    <button type="submit" name="aksi" value="add" class="btn btn-primary active">
                    <i class="bi bi-plus-square"></i>
                    Tambah Data
                    </button>
                <?php
                }
                ?>
                
                <a type="button" href="tabel-obat.php" class="btn btn-danger active">
                    <i class="bi bi-backspace"></i>
                    Batal
                </a>
                <!-- AKHIR BUTTON TAMBAH DATA MAHASISWA -->
                </div>

            </div>
            </form>
        

        
        </div>
        <!-- AKHIR CONTAINER FORM -->
    </div>
    <!-- AKHIR CONTAINER BODY CONTENT -->
<!-- Bootsrap CDN -->
 <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js" integrity="sha384-7qAoOXltbVP82dhxHAUje59V5r2YsVfBafyUDxEdApLPmcdhBPg1DKg1ERo0BZlK" crossorigin="anonymous"></script>
</body>
</html>