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
$aksi = $_GET['aksi'];

// ambil stok lama
$result = mysqli_query($koneksi, "SELECT stok FROM barang WHERE id_barang=$id");
$data = mysqli_fetch_assoc($result);
$stok = $data['stok'];

// update stok sesuai aksi
if ($aksi == "tambah") {
    $stokBaru = $stok + 1;
} elseif ($aksi == "kurang" && $stok > 0) {
    $stokBaru = $stok - 1;
} else {
    $stokBaru = $stok; // stok tetap kalau kurang tapi sudah 0
}

mysqli_query($koneksi, "UPDATE barang SET stok=$stokBaru WHERE id_barang=$id");

// balik ke barang.php
header("Location: barang.php");
exit;
?>
