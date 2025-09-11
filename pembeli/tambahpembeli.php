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

?>
<!DOCTYPE html>
<html>
<head>
    <title>Tambah Pembeli</title>
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

        /* Form label */
        label {
            font-weight: 500;
            margin-top: 5px;
        }

        /* Input */
        input {
            border-radius: 5px !important;
        }

        /* Tombol pink */
        .btn-pink {
            background-color: #f81c78;
            color: #fff;
            border-radius: 5px;
        }
        .btn-pink:hover {
            background-color: #d21565;
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
    <h3>Tambah Pembeli</h3>
    <form method="post" action="prosestambahpembeli.php">
      <label for="nama">Nama :</label>
        <input type="text" name="nama" placeholder="nama" class="form-control mb-2" required>
        <label for="alamat">Alamat</label>
        <input type="text" name="alamat" placeholder="alamat" class="form-control mb-2" required>
        <label for="telp">No. Telepon</label>
        <input type="number" name="telp" placeholder="telepon" class="form-control mb-2" required>
        <button type="submit" class="btn btn-pink">Simpan</button>
        <a href="pembeli.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>
</body>
</html>
