<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "spk_apotek";

$koneksi = mysqli_connect($host, $user, $pass, $db);
mysqli_select_db($koneksi, $db);
// if (!$koneksi) {
//     die("Koneksi gagal: " . mysqli_connect_error());
// }
?>
