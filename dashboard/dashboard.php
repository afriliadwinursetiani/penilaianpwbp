<?php
include "../koneksi/koneksi.php";

session_start();
if (!isset($_SESSION['username']) || !isset($_SESSION['role'])) {
    header("Location: ../login/login.php");
    exit();
}
$role = $_SESSION['role'];

// kalau bukan admin/owner/suplier → tendang
if (!in_array($role, ['admin','owner'])) {
    header("Location: ../login/login.php");
    exit();
}


// Ringkasan data
$total_pembeli   = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) total FROM pembeli"))['total'];
$total_barang    = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) total FROM barang"))['total'];
$total_penjualan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(total_harga) total FROM penjualan"))['total'] ?? 0;

// Query penjualan terbaru
$query_penjualan = "
  SELECT penjualan.id_penjualan, pembeli.nama AS nama_pembeli, 
         barang.nama_barang, penjualan.jumlah, 
         penjualan.total_harga, penjualan.tanggal
  FROM penjualan
  JOIN pembeli ON penjualan.id_pembeli = pembeli.id_pembeli
  JOIN barang ON penjualan.id_barang = barang.id_barang
  ORDER BY penjualan.tanggal DESC
";
$penjualan = mysqli_query($koneksi, $query_penjualan);
$no = 1;    
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background: #fdfdfd; }
    .navbar { background: linear-gradient(90deg,#f81c78,#e83e8c); }
    .card { border-radius: 15px; color: #fff; }
    .bg-pembeli { background: linear-gradient(135deg,#17a2b8,#0dcaf0); }
    .bg-barang { background: linear-gradient(135deg,#28a745,#20c997); }
    .bg-penjualan { background: linear-gradient(135deg,#dc3545,#fd7e14); }
    .card-header { background:#f8f9fa; font-weight:bold;  color:#333; }
  </style>
</head>
<body>
<!-- Navbar -->
<nav class="navbar navbar-dark">
  <div class="container">
    <a class="navbar-brand fw-bold text-white" href="#">Afrilia
    </a>
    <div>
      <a class="nav-link d-inline text-white" href="../barang/barang.php">📦 Barang</a>
      <a class="nav-link d-inline text-white" href="../pembeli/pembeli.php">👤 Pembeli</a>
      <a class="nav-link d-inline text-white" href="../penjualan/penjualan.php">💰 Penjualan</a>
                <a class="nav-link d-inline text-white" href="../dashboard/dashboard.php">📊 Dashboard</a>
       <a class="nav-link d-inline text-white" href="../logout/logout.php"> 🚪 logout</a>
    </div>
  </div>
</nav>

<div class="container my-4">
  <h3 class="mb-4 fw-bold text-secondary">Dashboard</h3>
  <div class="row g-3">
    <div class="col-md-4"><div class="card p-3 shadow-sm bg-pembeli"><h5>Total Pembeli</h5><h2><?= $total_pembeli ?></h2></div></div>
    <div class="col-md-4"><div class="card p-3 shadow-sm bg-barang"><h5>Total Barang</h5><h2><?= $total_barang ?></h2></div></div>
    <div class="col-md-4"><div class="card p-3 shadow-sm bg-penjualan"><h5>Total Penjualan</h5><h2>Rp <?= number_format($total_penjualan,0,',','.') ?></h2></div></div>
  </div>

  <div class="card mt-4 shadow-sm">
    <div class="card-header">Penjualan Terbaru</div>
    <div class="card-body">
      <table class="table table-bordered text-center">
        <thead>
          <tr>
            <th>No</th>
            <th>Pembeli</th>
            <th>Barang</th>
            <th>Jumlah</th>
            <th>Total</th>
            <th>Tanggal</th>
          </tr>
        </thead>
        <tbody>
        <?php if(mysqli_num_rows($penjualan) > 0): ?>
          <?php while($row = mysqli_fetch_assoc($penjualan)): ?>
          <tr>
            <td><?= $no++ ?></td>
            <td><?= $row['nama_pembeli'] ?></td>
            <td><?= $row['nama_barang'] ?></td>
            <td><?= $row['jumlah'] ?></td>
            <td>Rp <?= number_format($row['total_harga'],0,',','.') ?></td>
            <td><?= date("d-m-Y", strtotime($row['tanggal'])) ?></td>
          </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr><td colspan="6">Belum ada data penjualan</td></tr>
        <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
</body>
</html>
