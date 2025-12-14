<?php
include 'koneksi.php';

// Pastikan ada ID
if (!isset($_GET['id'])) {
    header("Location: arsip-laporan.php");
    exit;
}

$id = $_GET['id'];

// Ambil data arsip
$query = mysqli_query($koneksi, "SELECT * FROM arsip_laporan WHERE id = '$id'");
$data = mysqli_fetch_assoc($query);

if ($data) {
    $filePath = $data['path'];

    // Hapus file fisik jika ada
    if (file_exists($filePath)) {
        unlink($filePath);
    }

    // Hapus data dari database
    mysqli_query($koneksi, "DELETE FROM arsip_laporan WHERE id = '$id'");
}

// Kembali ke halaman arsip
header("Location: arsip-laporan.php");
exit;
?>