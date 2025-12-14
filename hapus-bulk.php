<?php
include 'koneksi.php';

if (!empty($_POST['selected'])) {
    foreach ($_POST['selected'] as $id) {

        // Ambil data file
        $q = mysqli_query($koneksi, "SELECT path FROM arsip_laporan WHERE id='$id'");
        $data = mysqli_fetch_assoc($q);

        // Hapus file fisik
        if (file_exists($data['path'])) {
            unlink($data['path']);
        }

        // Hapus dari database
        mysqli_query($koneksi, "DELETE FROM arsip_laporan WHERE id='$id'");
    }
}

header("Location: arsip-laporan.php");
exit;
?>