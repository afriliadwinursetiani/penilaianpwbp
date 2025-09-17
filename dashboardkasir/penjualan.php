<?php
include "../koneksi/koneksi.php";

session_start();
if (!isset($_SESSION['username']) || !isset($_SESSION['role'])) {
    header("Location: ../login/login.php");
    exit();
}
$role = $_SESSION['role'];

// kalau bukan admin/owner/suplier → tendang
if (!in_array($role, ['kasir'])) {
    header("Location: ../login/login.php");
    exit();
}



# default query
$query = "
SELECT penjualan.id_penjualan, pembeli.nama AS nama_pembeli, 
       barang.nama_barang, penjualan.jumlah, 
       penjualan.total_harga, penjualan.tanggal
FROM penjualan
JOIN pembeli ON penjualan.id_pembeli = pembeli.id_pembeli
JOIN barang ON penjualan.id_barang = barang.id_barang
";

# cek apakah ada pencarian
$keyword = "";
if (isset($_GET['cari']) && $_GET['cari'] != "") {
    $keyword = $_GET['cari'];
    $query .= " WHERE pembeli.nama LIKE '%$keyword%' 
                OR barang.nama_barang LIKE '%$keyword%'";
}

$result = mysqli_query($koneksi, $query);
$no=1;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Penjualan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        .navbar {
            background-color: #f81c78; /* pink tua */
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
  </div>
</nav>

<div class="container mt-4">
    <h3 class="mb-3">Daftar Penjualan</h3>

    <!-- tombol tambah -->
    <a href="tambahpenjualan.php" class="btn btn-pink mb-3">+ Tambah Penjualan</a>

    <!-- form pencarian -->
    <form method="get" class="row g-2 mb-3">
        <div class="col-md-9">
            <input type="text" name="cari" class="form-control" placeholder="🔍 Cari pembeli / barang..." value="<?= $keyword; ?>">
        </div>
        <div class="col-md-3">
            <button type="submit" class="btn btn-primary w-100">Cari</button>
        </div>
    </form>

    <!-- tabel penjualan -->
    <table class="table table-bordered table-hover text-center align-middle">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Pembeli</th>
                <th>Barang</th>
                <th>Jumlah</th>
                <th>Total Harga</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php if(mysqli_num_rows($result) > 0) { ?>
            <?php while($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?= $no++;?></td>
                <td><?= $row['nama_pembeli']; ?></td>
                <td><?= $row['nama_barang']; ?></td>
                <td><?= $row['jumlah']; ?></td>
                <td>Rp <?= number_format($row['total_harga'],0,',','.'); ?></td>
                <td><?= date('d-m-Y', strtotime($row['tanggal'])); ?></td>
                <td>
                    <a href="detailpenjualan.php?id=<?= $row['id_penjualan']; ?>" class="btn btn-info btn-sm">Detail</a>
                    <a href="editpenjualan.php?id=<?= $row['id_penjualan']; ?>" class="btn btn-warning btn-sm">Edit</a>
    
                </td>
            </tr>
            <?php } ?>
        <?php } else { ?>
            <tr>
                <td colspan="7" class="text-center">⚠️ Data tidak ditemukan</td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
</body>
</html>
