<?php
    include 'koneksi.php';

    if (isset($_POST['aksi'])) {
                  if ($_POST['aksi'] == "add") {
                    $inputKodeObat = $_POST['inputKodeObat'];
                    $inputNamaObat = $_POST['inputNamaObat'];
                    $inputSediaan = $_POST['inputSediaan'];
                    $inputHarga = $_POST['inputHarga'];

                    $query = "INSERT INTO obat VALUES('$inputKodeObat', '$inputNamaObat', '$inputSediaan', '$inputHarga')";
                    $sql = mysqli_query($koneksi, $query);

                    if ($sql) {
                      header("location: tabel-obat.php");
                      // echo "<h2 class='text-light'>Tambah Data</h2> <a href='tabel-obat.php'>[Home]</a>"; 
                    } else {
                      echo $query;
                    }

                  }elseif ($_POST['aksi'] == "edit") {
                    $inputKodeObat = $_POST['inputKodeObat'];
                    $inputNamaObat = $_POST['inputNamaObat'];
                    $inputSediaan = $_POST['inputSediaan'];
                    $inputHarga = $_POST['inputHarga'];

                    $query = "UPDATE obat SET kode_obat='$inputKodeObat', nama_obat='$inputNamaObat', sediaan='$inputSediaan', harga='$inputHarga' WHERE kode_obat='$inputKodeObat';";
                    $sql = mysqli_query($koneksi, $query);

                    if ($sql) {
                      header("location: tabel-obat.php");
                    } else {
                      echo $query;
                    }

                  }
              }

              if (isset($_GET['hapus'])) {
                $kodeObat = $_GET['hapus'];
                $query = "DELETE FROM obat WHERE kode_obat = '$kodeObat'";
                $sql = mysqli_query($koneksi, $query);
                
                if ($sql) {
                  header("location: tabel-obat.php");
                } else {
                  echo $query;
                }
                
              }
?>