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


$tabel = $_GET['tabel'];
$kolom = $_GET['kolom'];
$id    = $_GET['id'];

$query = "DELETE FROM $tabel WHERE $kolom = $id";
mysqli_query($koneksi, $query);

if ($tabel == "barang") {
    header("Location: ../barang/barang.php");
} elseif ($tabel == "pembeli") {
    header("Location: ../pembeli/pembeli.php");
} else {
    header("Location: penjualan.php");
}
?>
