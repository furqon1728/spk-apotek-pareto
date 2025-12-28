<?php
include 'koneksi.php';

// Ambil semua data obat sekali saja
$sql_obat = mysqli_query($koneksi, "SELECT * FROM obat");
$allObat = [];
while ($row = mysqli_fetch_assoc($sql_obat)) {
  $allObat[] = $row;
}
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SPK Apotek</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>
<body>
  <!-- NAVBAR -->
  <nav class="navbar navbar-expand-lg bg-light shadow fixed-top">
    <div class="container">
      <a class="navbar-brand fw-bold" href="#">SPK Apotek</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="index.php">Laporan Pareto</a></li>
          <li class="nav-item fw-bold"><a class="nav-link active" href="hitung-pareto.php">Hitung Pareto</a></li>
          <li class="nav-item"><a class="nav-link" href="tabel-obat.php">Data Obat</a></li>
          <li class="nav-item"><a class="nav-link" href="arsip-laporan.php">Arsip Laporan</a></li>
          <li class="nav-item"><a class="nav-link text-danger" href="logout.php">Logout</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- CONTENT -->
  <div class="container pt-5 mt-5">
    <h1 class="h3 text-dark mb-4">Hitung Pareto</h1>

    <div class="row g-3 mb-4">
      <!-- FILTER KATEGORI -->
      <div class="col-md-6">
        <select class="form-select" id="kategoriSelect" onchange="setKategori(this.value)">
          <option value="">Pilih Kategori</option>
          <?php
          $kategoriList = ['Aerosol','Gel','Inhalasi','Infus','Injeksi','Kapsul','Krim','Pil','Salep','Serbuk','Sirup','Suspensi','Tablet','Tetes','Tube'];
          foreach ($kategoriList as $item) {
            echo "<option value=\"$item\">$item</option>";
          }
          ?>
        </select>
      </div>

      <!-- SEARCH BAR -->
      <div class="col-md-6">
        <div class="input-group">
          <input type="text" id="searchObat" class="form-control" placeholder="Cari nama obat..." oninput="filterObat(this.value)">
        </div>
      </div>
    </div>

    <!-- TABLE OBAT -->
    <div class="table-responsive">
      <table class="table table-hover table-light">
        <thead>
          <tr>
            <th>No</th>
            <th>Kode Obat</th>
            <th>Nama Obat</th>
            <th>Sediaan</th>
            <th>Harga</th>
            <th>Qty Terjual</th>
          </tr>
        </thead>
        <tbody id="tabelObat"></tbody>
      </table>
    </div>

    <div class="text-end mt-4">
      <button type="button" class="btn btn-success" onclick="submitPareto()">
        <i class="bi bi-clipboard-data"></i> Hitung Pareto
      </button>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Data obat dari PHP
    const semuaObat = <?= json_encode($allObat) ?>;
    let qtyMap = {};
    let kategoriDipilih = '';

    function filterObat(keyword) {
      const keywordLower = keyword.toLowerCase();
      const hasil = semuaObat.filter(obat =>
        (kategoriDipilih === '' || obat.sediaan === kategoriDipilih) &&
        obat.nama_obat.toLowerCase().includes(keywordLower)
      );
      renderTabel(hasil);
    }

    function setKategori(kat) {
      kategoriDipilih = kat;
      filterObat(document.getElementById('searchObat').value);
    }

    function renderTabel(data) {
      const tbody = document.getElementById('tabelObat');
      tbody.innerHTML = '';
      data.forEach((obat, i) => {
        const kode = obat.kode_obat;
        const qty = qtyMap[kode] || '';
        const tr = document.createElement('tr');
        tr.innerHTML = `
          <td>${i+1}</td>
          <td>${kode}</td>
          <td>${obat.nama_obat}</td>
          <td>${obat.sediaan}</td>
          <td>Rp ${parseInt(obat.harga).toLocaleString()}</td>
          <td><input type="number" value="${qty}" min="0" class="form-control" oninput="qtyMap['${kode}'] = this.value"></td>
        `;
        tbody.appendChild(tr);
      });
    }

    function submitPareto() {
      const form = document.createElement('form');
      form.method = 'POST';
      form.action = 'proses-pareto.php';

      for (const kode in qtyMap) {
        if (qtyMap[kode] !== '' && parseInt(qtyMap[kode]) > 0) {
          const input = document.createElement('input');
          input.type = 'hidden';
          input.name = `qty[${kode}]`;
          input.value = qtyMap[kode];
          form.appendChild(input);
        }
      }

      document.body.appendChild(form);
      form.submit();
    }

    // Tampilkan semua obat saat awal
    renderTabel(semuaObat);

    // Enter di input Qty langsung submit
    document.addEventListener('keydown', function(event) {
      if (event.key === 'Enter') {
        if (event.target.tagName === 'INPUT' && event.target.type === 'number') {
          event.preventDefault();
          submitPareto();
        }
      }
    });
  </script>
  
</body>
</html>