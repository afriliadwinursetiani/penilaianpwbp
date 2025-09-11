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


$tabel = $_GET['tabel'];   # nama tabel (barang, pembeli, penjualan)
$kolom = $_GET['kolom'];   # nama kolom primary key
$id    = $_GET['id'];      # id yang mau dihapus

$query = "DELETE FROM $tabel WHERE $kolom = $id";
mysqli_query($koneksi, $query);

# redirect ke halaman sesuai tabel
if ($tabel == "barang") {
    header("Location: ../barang/barang.php");
} elseif ($tabel == "pembeli") {
    header("Location: pembeli.php");
} else {
    header("Location: ../penjualan/penjualan.php");
}
?>