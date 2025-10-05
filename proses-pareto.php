<?php
include 'koneksi.php';
session_start();

$qtyData = $_POST['qty'] ?? [];
if (empty($qtyData)) {
  header("Location: hitung-pareto.php");
  exit;
}

$dataPareto = [];
$grandTotal = 0;

// Step 1: Ambil data obat dan hitung total penjualan
foreach ($qtyData as $kode => $qty) {
  if ($qty <= 0 || !is_numeric($qty)) continue;

  $query = "SELECT * FROM obat WHERE kode_obat = '$kode'";
  $sql = mysqli_query($koneksi, $query);
  $obat = mysqli_fetch_assoc($sql);
  if (!$obat) continue;

  $total = $obat['harga'] * $qty;
  $dataPareto[] = [
    'kode' => $kode,
    'nama' => $obat['nama_obat'],
    'sediaan' => $obat['sediaan'],
    'harga' => $obat['harga'],
    'qty' => $qty,
    'total' => $total
  ];
  $grandTotal += $total;
}

// Step 2: Urutkan berdasarkan total penjualan DESC
usort($dataPareto, function($a, $b) {
  return $b['total'] <=> $a['total'];
});

// Step 3: Hitung persen, akumulasi, dan kelompok
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

// Step 4: Simpan ke session dan redirect
$_SESSION['pareto'] = $dataPareto;
header("Location: index.php");
exit;
?>