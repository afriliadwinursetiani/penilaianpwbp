<?php 
include "../koneksi/koneksi.php"; 
session_start();

if (!isset($_SESSION['username']) || !isset($_SESSION['role'])) {
    header("Location: ../login/login.php");
    exit();
}

$role = $_SESSION['role'];

// kalau bukan admin/owner/suplier/kasir → tendang
if (!in_array($role, ['kasir'])) {
    header("Location: ../login/login.php");
    exit();
}

// kalau ada pesan error dari prosestambahpenjualan.php
$pesan_error = isset($_GET['error']) ? $_GET['error'] : "";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Tambah Penjualan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        .navbar { background-color: #f81c78; }
        h3 { color: #e83e8c; font-weight: bold; }
        label { font-weight: 500; margin-top: 5px; }
        input, select { border-radius: 5px !important; }
        .btn-pink { background-color: #f81c78; color: #fff; border-radius: 5px; }
        .btn-pink:hover { background-color: #d21565; color: #fff; }
    </style>
</head>
<body>
<nav class="navbar navbar-dark">
  <div class="container">
       <a class="navbar-brand fw-bold text-white" href="#">Afrilia</a>
    <div>
      <a class="nav-link d-inline text-white" href="barang.php">📦 Barang</a>
      <a class="nav-link d-inline text-white" href="pembeli.php">👤 Pembeli</a>
      <a class="nav-link d-inline text-white" href="penjualan.php">💰 Penjualan</a>
               <a class="nav-link d-inline text-white" href="dashboard.php">📊 Dashboard</a>
       <a class="nav-link d-inline text-white" href="../logout/logout.php"> 🚪 logout</a>
  </div>
    </div>
  </div>
</nav>

<div class="container mt-4">
    <h3>Tambah Penjualan</h3>

    <?php if (!empty($pesan_error)): ?>
        <div class="alert alert-danger"><?= $pesan_error; ?></div>
    <?php endif; ?>

    <form method="post" action="prosestambahpenjualan.php">
        <label>Pembeli</label>
        <select name="id_pembeli" class="form-control mb-2" required>
            <?php
            $pembeli = mysqli_query($koneksi, "SELECT * FROM pembeli");
            while ($p = mysqli_fetch_assoc($pembeli)) {
                echo "<option value='".$p['id_pembeli']."'>".$p['nama']."</option>";
            }
            ?>
        </select>

        <label>Barang</label>
        <select name="id_barang" class="form-control mb-2" required>
            <?php
            $barang = mysqli_query($koneksi, "SELECT * FROM barang");
            while ($b = mysqli_fetch_assoc($barang)) {
                echo "<option value='".$b['id_barang']."'>".$b['nama_barang']." (Rp".$b['harga'].") - Stok: ".$b['stok']."</option>";
            }
            ?>
        </select>

        <label for="jumlah">Jumlah Beli</label>
        <input type="number" name="jumlah" placeholder="Jumlah Beli" class="form-control mb-2" required>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="penjualan.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>
</body>
</html>
