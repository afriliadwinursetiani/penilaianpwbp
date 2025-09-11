<?php
include "../koneksi/koneksi.php";
session_start();
if (!isset($_SESSION['username']) || !isset($_SESSION['role'])) {
    header("Location: ../login.php");
    exit();
}
$role = $_SESSION['role'];

// kalau bukan admin/owner/suplier → tendang
if (!in_array($role, ['admin','owner','suplier'])) {
    header("Location: ../login.php");
    exit();
}
$id = $_GET['id'];
$result = mysqli_query($koneksi, "SELECT * FROM pembeli WHERE id_pembeli=$id");
$data   = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Detail Pembeli</title>
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
<nav class="navbar navbar-dark">
  <div class="container">
    <a class="navbar-brand fw-bold text-white" href="../pembeli/pembeli.php">Afrilia</a>
 <div>
         <a class="nav-link d-inline text-white" href="../pembeli/pembeli.php">📦 Barang</a>
      <a class="nav-link d-inline text-white" href="../pembeli/pembeli.php">👤 Pembeli</a>
      <a class="nav-link d-inline text-white" href="../penjualan/penjualan.php">💰 Penjualan</a>
          <a class="nav-link d-inline text-white" href="../dashboard/dashboard.php">📊 Dashboard</a>
       <a class="nav-link d-inline text-white" href="../logout/logout.php"> 🚪 logout</a>
    </div>
  </div>
</nav>
<div class="container mt-4">
    <h3>Detail Pembeli</h3>
    <table class="table table-bordered">
        <tr><th>ID</th><td><?= $data['id_pembeli']; ?></td></tr>
        <tr><th>Nama</th><td><?= $data['nama']; ?></td></tr>
        <tr><th>Email</th><td><?= $data['alamat']; ?></td></tr>
        <tr><th>Alamat</th><td><?= $data['telp']; ?></td></tr>
    </table>
    <a href="pembeli.php" class="btn btn-secondary">Kembali</a>
</div>
</body>
</html>
