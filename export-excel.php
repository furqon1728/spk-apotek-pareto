<?php
session_start();
$dataPareto = $_SESSION['pareto'] ?? [];

// Header agar browser menganggap ini file Excel
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=laporan_pareto.xls");
?>

<h3 style="margin-top:30px;">Ringkasan Kategori A/B/C</h3>
<p>Analisis berdasarkan prinsip Pareto untuk menentukan obat prioritas tertinggi.</p>

<table border="1">
  <tr>
    <th>Nama Produk</th>
    <th>Sediaan</th>
    <th>Harga</th>
    <th>Qty Penjualan</th>
    <th>Total Penjualan</th>
    <th>Presentase</th>
    <th>Akumulasi</th>
    <th>Kelompok</th>
  </tr>

  <?php foreach ($dataPareto as $row): ?>
    <tr>
      <td><?= $row['nama'] ?></td>
      <td><?= $row['sediaan'] ?></td>
      <td><?= $row['harga'] ?></td>
      <td><?= $row['qty'] ?></td>
      <td><?= $row['total'] ?></td>
      <td><?= $row['persen'] ?>%</td>
      <td><?= $row['akumulasi'] ?>%</td>
      <td><?= $row['kelompok'] ?></td>
    </tr>
  <?php endforeach; ?>
</table>

<br><br>
<b>Statistik Kelompok Pareto</b>
<table border="1">
  <tr>
    <th>Kategori Prioritas</th>
    <th>Persentase Jumlah Obat</th>
    <th>Kontribusi Terhadap Penjualan</th>
    <th>Penjelasan</th>
  </tr>

  <?php
  $grupStats = [
    'A' => ['item' => 0, 'persen' => 0],
    'B' => ['item' => 0, 'persen' => 0],
    'C' => ['item' => 0, 'persen' => 0]
  ];

  foreach ($_SESSION['pareto'] as $row) {
    $grupStats[$row['kelompok']]['item']++;
    $grupStats[$row['kelompok']]['persen'] += $row['persen'];
  }

  $totalItem = count($_SESSION['pareto']);

  foreach ($grupStats as $kelompok => $stat) {
    $itemPersen = round(($stat['item'] / $totalItem) * 100, 2);
    $persenNilai = round($stat['persen'], 2);
    
    echo "<tr>";
    echo "<td>";
    if ($kelompok == 'A') echo 'A (Sangat Penting)';
    elseif ($kelompok == 'B') echo 'B (Sedang)';
    else echo 'C (Rendah)';
    echo "</td>";
    echo "<td>{$itemPersen}%</td>";
    echo "<td>{$persenNilai}%</td>";
    echo "<td>";
    if ($kelompok == 'A') echo 'Obat paling laris, nilai penjualan tinggi';
    elseif ($kelompok == 'B') echo 'Obat sedang laris, nilai penjualan menengah';
    else echo 'Obat kurang laris, kontribusi kecil';
    echo "</td>";
    echo "</tr>";
  }
  ?>
</table>