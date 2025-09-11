<?php
include "../koneksi/koneksi.php"; 
# sambungkan ke database
include "../koneksi/koneksi.php"; 
session_start();
if (!isset($_SESSION['username']) || !isset($_SESSION['role'])) {
    header("Location: ../login/login.php");
    exit();
}
$role = $_SESSION['role'];

// kalau bukan admin/owner/suplier → tendang
if (!in_array($role, ['admin','owner','suplier','kasir'])) {
    header("Location: ../login/login.php");
    exit();
}

# jika tombol cari ditekan
$keyword = "";
if (isset($_GET['cari'])) {
    $keyword = $_GET['cari'];
    $result = mysqli_query($koneksi, "SELECT * FROM barang WHERE nama_barang LIKE '%$keyword%'");
} else {
    $result = mysqli_query($koneksi, "SELECT * FROM barang");
}

$no = 1; // nomor urut  
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Barang</title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- Custom CSS sederhana -->
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
    <a class="navbar-brand fw-bold text-white" href="../barang/barang.php">Afrilia</a>
    <div>
         <a class="nav-link d-inline text-white" href="../barang/barang.php">📦 Barang</a>
      <a class="nav-link d-inline text-white" href="../pembeli/pembeli.php">👤 Pembeli</a>
      <a class="nav-link d-inline text-white" href="../penjualan/penjualan.php">💰 Penjualan</a>
        <a class="nav-link d-inline text-white" href="../dashboard/dashboard.php">📊 Dashboard</a>
         <a class="nav-link d-inline text-white" href="../logout/logout.php"> 🚪 logout</a>
    </div>
  </div>
</nav>


<div class="container mt-4">
    <h3 class="mb-3">Daftar Barang</h3>

    <!-- tombol tambah barang -->
    <a href="tambahbarang.php" class="btn btn-pink mb-3">+ Tambah Barang</a>

    <!-- form pencarian -->
    <form method="get" class="row g-2 mb-3">
        <div class="col-md-9">
            <input type="text" name="cari" class="form-control" placeholder="🔍 Cari Nama Barang..." value="<?= $keyword; ?>">
        </div>
        <div class="col-md-3">
            <button type="submit" class="btn btn-primary w-100">Cari</button>
        </div>
    </form>

    <!-- tabel barang -->
    <table class="table table-bordered table-hover text-center align-middle">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php if(mysqli_num_rows($result) > 0) { ?>
            <?php while($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= $row['nama_barang']; ?></td>
                <td>Rp <?= number_format($row['harga'],0,',','.'); ?></td>
                <td>
                    <!-- tombol + dan - -->
                    <a href="updatestok.php?id=<?= $row['id_barang']; ?>&aksi=kurang" class="btn btn-danger btn-sm">-</a>
                    <span class="mx-2"><?= $row['stok']; ?></span>
                    <a href="updatestok.php?id=<?= $row['id_barang']; ?>&aksi=tambah" class="btn btn-success btn-sm">+</a>
                </td>
                <td>
                    <a href="detailbarang.php?id=<?= $row['id_barang']; ?>" class="btn btn-info btn-sm">Detail</a>
                    <a href="hapus.php?tabel=barang&id=<?= $row['id_barang']; ?>&kolom=id_barang" 
                       class="btn btn-danger btn-sm" 
                       onclick="return confirm('Yakin hapus barang ini?')">Hapus</a>
                </td>
            </tr>
            <?php } ?>
        <?php } else { ?>
            <tr>
                <td colspan="5" class="text-center">⚠️ Data tidak ditemukan</td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
</body>
</html>
