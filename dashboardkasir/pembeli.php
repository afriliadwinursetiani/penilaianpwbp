<?php
include "../koneksi/koneksi.php"; 
session_start();
if (!isset($_SESSION['username']) || !isset($_SESSION['role'])) {
    header("Location: ../login/login.php");
    exit();
}
$role = $_SESSION['role'];

// kalau bukan admin/owner/suplier → tendang
if (!in_array($role, ['admin','owner','kasir'])) {
    header("Location: ../login/login.php");
    exit();
}
# sambungkan ke database
# jika tombol cari ditekan
$keyword = "";
if (isset($_GET['cari'])) {
    $keyword = $_GET['cari'];
    $result = mysqli_query($koneksi, "SELECT * FROM pembeli WHERE nama LIKE '%$keyword%'");
} else {
    $result = mysqli_query($koneksi, "SELECT * FROM pembeli");
}
# ambil semua data pembeli
$no = 1;  # nomor urut
?>
<!DOCTYPE html>
<html>
<head>
    <title>Data Pembeli</title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <style>
        .navbar {
            background-color: #f81c78ff; 
        }
        .btn-pink {
            background-color: #e83e8c;
            color: white;
        }
        .btn-pink:hover {
            background-color: #d63384;
            color: white;
        }
    </style>
</head>
<body>
<!-- Navbar -->
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
</nav>

<div class="container mt-4">
    <h3>Daftar Pembeli</h3>
    <!-- tombol tambah pembeli -->
    <a href="tambahbeli.php" class="btn btn-pink mb-3">+ Tambah Pembeli</a> <form method="get" class="mb-3 d-flex">
            <input type="text" name="cari" class="form-control me-2" placeholder="🔍 Cari Nama ..." value="<?= $keyword; ?>">
            <button type="submit" class="btn btn-primary">Cari</button>
        </form>

    <!-- tabel pembeli -->
    <table class="table table-striped table-bordered">
        <tr class="table-dark">
            <th>ID</th>
            <th>Nama</th>
            <th>Alamat</th>
            <th>Nomor Hp</th>
            
            <th>Aksi</th>
    </tr>
      <?php if(mysqli_num_rows($result) > 0) { ?>
        <?php while($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?= $no++;?></td>
            <td><?= $row['nama']; ?></td>
            <td><?= $row['alamat']; ?></td>
            <td><?= $row['telp']; ?></td>
            <td>
                <!-- tombol detail -->
                <a href="detailpembeli.php?id=<?= $row['id_pembeli']; ?>" class="btn btn-info btn-sm">Detail</a>
                <!-- tombol edit -->
                <a href="editbeli.php?id=<?= $row['id_pembeli']; ?>" class="btn btn-warning btn-sm">Edit</a>
                <!-- tombol hapus -->
            </td>
        </tr>
        <?php } ?>
            <?php } ?>
    </table>
</div>
</body>
</html>
