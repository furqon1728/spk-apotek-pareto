<?php
include 'koneksi.php';

$kode_obat = '';
$nama_obat = '';
$sediaan = '';
$harga = '';

if (isset($_GET['ubah'])) {
  $kode_obat = $_GET['ubah'];
  $query = "SELECT * FROM obat WHERE kode_obat = '$kode_obat'";
  $sql = mysqli_query($koneksi, $query);
  $result = mysqli_fetch_assoc($sql);

  $nama_obat = $result['nama_obat'];
  $sediaan = $result['sediaan'];
  $harga = $result['harga'];
}
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
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
  <nav class="navbar navbar-expand-lg bg-body-tertiary shadow fixed-top">
    <div class="container">
      <a class="navbar-brand fw-bold" href="#">SPK Apotek</a>
    </div>
  </nav>

  <!-- CONTENT -->
  <div class="container pt-5 mt-5">
    <figure class="text-light">
      <blockquote class="blockquote">
        <h1 class="h3">Data Obat</h1>
      </blockquote>
    </figure>

    <!-- FORM -->
    <div class="text-light mt-4">
      <form method="POST" action="proses-obat.php">
        <div class="mb-3">
          <label for="inputKodeObat" class="form-label">Kode Obat</label>
          <input required type="text" class="form-control" id="inputKodeObat" name="inputKodeObat" placeholder="Masukkan Kode Obat" value="<?= htmlspecialchars($kode_obat) ?>">
        </div>

        <div class="mb-3">
          <label for="inputNamaObat" class="form-label">Nama Obat</label>
          <input required type="text" class="form-control" id="inputNamaObat" name="inputNamaObat" placeholder="Masukkan Nama Obat" value="<?= htmlspecialchars($nama_obat) ?>">
        </div>

        <div class="mb-3">
          <label for="inputSediaan" class="form-label">Sediaan</label>
          <select required class="form-select" id="inputSediaan" name="inputSediaan">
            <option value="">Pilih Sediaan</option>
            <?php
            $kategoriList = ['Tablet','Kapsul','Pil','Serbuk','Salep','Krim','Gel','Sirup','Suspensi','Injeksi','Infus','Tetes','Inhalasi','Aerosol'];
            foreach ($kategoriList as $item) {
              $selected = ($sediaan == $item) ? 'selected' : '';
              echo "<option value=\"$item\" $selected>$item</option>";
            }
            ?>
          </select>
        </div>

        <div class="mb-3">
          <label for="inputHarga" class="form-label">Harga</label>
          <input required type="number" class="form-control" id="inputHarga" name="inputHarga" placeholder="Masukkan Harga" value="<?= htmlspecialchars($harga) ?>">
        </div>

        <div class="d-flex gap-2 mt-4">
          <?php if (isset($_GET['ubah'])): ?>
            <button type="submit" name="aksi" value="edit" class="btn btn-success">
              <i class="bi bi-save2"></i> Simpan Perubahan
            </button>
          <?php else: ?>
            <button type="submit" name="aksi" value="add" class="btn btn-primary">
              <i class="bi bi-plus-square"></i> Tambah Data
            </button>
          <?php endif; ?>
          <a href="tabel-obat.php" class="btn btn-danger">
            <i class="bi bi-backspace"></i> Batal
          </a>
        </div>
      </form>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>