<?php
include "../koneksi/koneksi.php";

session_start();
if (!isset($_SESSION['username']) || !isset($_SESSION['role'])) {
    header("Location: ../login/login.php");
    exit();
}
$role = $_SESSION['role'];

// kalau bukan admin/owner/suplier → tendang
if (!in_array($role, ['admin','owner','suplier'])) {
    header("Location: ../login/login.php");
    exit();
}


$id = $_GET['id'];
$result = mysqli_query($koneksi, "SELECT * FROM barang WHERE id_barang=$id");
$data   = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Barang</title>
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

        /* Form */
        label {
            font-weight: 500;
            margin-top: 5px;
        }

        input {
            border-radius: 5px !important;
        }

        /* Tombol ungu */
        .btn-ungu {
            background-color: #6f42c1;
            color: #fff;
            border-radius: 5px;
        }
        .btn-ungu:hover {
            background-color: #59359c;
            color: #fff;
        }

        /* Tombol kembali */
        .btn-secondary {
            border-radius: 5px;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-dark">
  <div class="container">
    <a class="navbar-brand fw-bold text-white" href="../barang/barang.php">Afrilia</a>
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
    <h3>Edit Barang</h3>
    <form method="post" action="proseseditbarang.php">
        <input type="hidden" name="id_barang" value="<?= $data['id_barang']; ?>">
        <label for="nama_barang">Nama Barang :</label>
        <input type="text" name="nama_barang" value="<?= $data['nama_barang']; ?>" class="form-control mb-2" required>
        <label for="harga">Harga :</label>
        <input type="number" name="harga" value="<?= $data['harga']; ?>" class="form-control mb-2" required>
        <label for="stok">Stok :</label>
        <input type="number" name="stok" value="<?= $data['stok']; ?>" class="form-control mb-2" required>
        <button type="submit" class="btn btn-ungu">Update</button>
        <a href="barang.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>
</body>
</html>
