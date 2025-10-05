<?php
include 'koneksi.php';

if (isset($_POST['aksi'])) {
  $kode = $_POST['inputKodeObat'];
  $nama = $_POST['inputNamaObat'];
  $sediaan = $_POST['inputSediaan'];
  $harga = $_POST['inputHarga'];

  if ($_POST['aksi'] == "add") {
    $query = "INSERT INTO obat (kode_obat, nama_obat, sediaan, harga) VALUES ('$kode', '$nama', '$sediaan', '$harga')";
  } elseif ($_POST['aksi'] == "edit") {
    $query = "UPDATE obat SET nama_obat='$nama', sediaan='$sediaan', harga='$harga' WHERE kode_obat='$kode'";
  }

  $sql = mysqli_query($koneksi, $query);
  if ($sql) {
    header("Location: tabel-obat.php");
    exit;
  } else {
    echo "Gagal eksekusi query: <br>$query";
  }
}

if (isset($_GET['hapus'])) {
  $kode = $_GET['hapus'];
  $query = "DELETE FROM obat WHERE kode_obat = '$kode'";
  $sql = mysqli_query($koneksi, $query);
  if ($sql) {
    header("Location: tabel-obat.php");
    exit;
  } else {
    echo "Gagal menghapus data: <br>$query";
  }
}
?>