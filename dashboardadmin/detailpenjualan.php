<?php
include "../koneksi/koneksi.php";

session_start();
if (!isset($_SESSION['username']) || !isset($_SESSION['role'])) {
    header("Location: ../login/login.php");
    exit();
}
$role = $_SESSION['role'];

// kalau bukan admin/owner/suplier → tendang
if (!in_array($role, ['admin'])) {
    header("Location: ../login/login.php");
    exit();
}


$id = $_GET['id'];
$query = "
SELECT penjualan.*, pembeli.nama AS nama_pembeli, barang.nama_barang, barang.harga 
FROM penjualan
JOIN pembeli ON penjualan.id_pembeli = pembeli.id_pembeli
JOIN barang ON penjualan.id_barang = barang.id_barang
WHERE penjualan.id_penjualan=$id
";
$result = mysqli_query($koneksi, $query);
$data   = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Detail Penjualan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        /* Navbar */
        .navbar {
            background-color: #f81c78; /* pink */
        }

        /* Judul */
        h3 {
            color: #e83e8c;
            font-weight: bold;
        }

        /* Tabel */
        .table th {
            width: 200px;
            background-color: #f8f9fa;
        }
        .table td {
            background-color: #fff;
        }

        /* Tombol kembali */
        .btn-secondary {
            border-radius: 5px;
            font-weight: bold;
        }
        .btn-secondary:hover {
            background-color: #6c757d;
            color: #fff;
        }
    </style>
</head>
<body>
<!-- Navbar -->
<nav class="navbar navbar-dark">
  <div class="container">
    <a class="navbar-brand fw-bold text-white" href="penjualan.php">Afrilia</a>
    <div>
         <a class="nav-link d-inline text-white" href="barang.php">📦 Barang</a>
      <a class="nav-link d-inline text-white" href="pembeli.php">👤 Pembeli</a>
      <a class="nav-link d-inline text-white" href="penjualan.php">💰 Penjualan</a>
                <a class="nav-link d-inline text-white" href="dashboard.php">📊 Dashboard</a>
       <a class="nav-link d-inline text-white" href="../logout/logout.php"> 🚪 logout</a>
    </div>
  </div>
</nav>
<div class="container mt-4">
    <h3>Detail Penjualan</h3>
    <table class="table table-bordered">
        <tr><th>ID</th><td><?= $data['id_penjualan']; ?></td></tr>
        <tr><th>Pembeli</th><td><?= $data['nama_pembeli']; ?></td></tr>
        <tr><th>Barang</th><td><?= $data['nama_barang']; ?></td></tr>
        <tr><th>Harga Barang</th><td>Rp <?= number_format($data['harga'],0,',','.'); ?></td></tr>
        <tr><th>Jumlah</th><td><?= $data['jumlah']; ?></td></tr>
        <tr><th>Total Harga</th><td>Rp <?= number_format($data['total_harga'],0,',','.'); ?></td></tr>
        <tr><th>Tanggal</th><td><?= date('d-m-Y', strtotime($data['tanggal'])); ?></td></tr>
    </table>
    <a href="penjualan.php" class="btn btn-secondary">Kembali</a>
</div>
</body>
</html>
