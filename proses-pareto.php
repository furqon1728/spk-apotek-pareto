<?php
include 'koneksi.php';
session_start();

// Ambil data Qty dari POST
$qtyData = $_POST['qty'] ?? [];

if (empty($qtyData)) {
  // Kalau tidak ada data, redirect balik
  header("Location: hitung-pareto.php");
  exit;
}

$dataPareto = [];
$grandTotal = 0;

// Step 1: Ambil data obat dari DB berdasarkan kode_obat yang dikirim
foreach ($qtyData as $kode => $qty) {
  if ($qty <= 0 || !is_numeric($qty)) continue; // Skip jika qty kosong atau tidak valid

  $query = "SELECT * FROM obat WHERE kode_obat = '$kode'";
  $sql = mysqli_query($koneksi, $query);
  $obat = mysqli_fetch_assoc($sql);

  if (!$obat) continue;

  $totalPenjualan = $obat['harga'] * $qty;

  $dataPareto[] = [
    'kode' => $kode,
    'nama' => $obat['nama_obat'],
    'sediaan' => $obat['sediaan'],
    'harga' => $obat['harga'],
    'qty' => $qty,
    'total' => $totalPenjualan,
  ];

  $grandTotal += $totalPenjualan;
}

// Step 2: Urutkan berdasarkan total penjualan DESC
usort($dataPareto, function($a, $b) {
  return $b['total'] <=> $a['total'];
});

// Step 3: Hitung presentase, akumulasi, dan kelompok
$akumulasi = 0;
foreach ($dataPareto as &$row) {
  $row['persen'] = round(($row['total'] / $grandTotal) * 100, 2);
  $akumulasi += $row['persen'];
  $row['akumulasi'] = round($akumulasi, 2);

  if ($row['akumulasi'] <= 80) {
    $row['kelompok'] = 'A';
  } elseif ($row['akumulasi'] <= 95) {
    $row['kelompok'] = 'B';
  } else {
    $row['kelompok'] = 'C';
  }
}

// Step 4: Simpan hasil ke session
$_SESSION['pareto'] = $dataPareto;

// Redirect ke halaman laporan
header("Location: index.php");
exit;
?>