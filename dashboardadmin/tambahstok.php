<?php
include "../koneksi/koneksi.php";
session_start();
if (!isset($_SESSION['username']) || !isset($_SESSION['role'])) {
    header("Location: ../login/login.php");
    exit();
}
$role = $_SESSION['role'];

// kalau bukan admin/owner/suplier → tendang
if (!in_array($role, ['admin'])) {
    header("Location: ../login/login.php");
    exit();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_barang = $_POST['id_barang'];
    $jumlah = $_POST['jumlah'];

    if ($jumlah > 0) {
        // Update stok
        $query = "UPDATE barang SET stok = stok + $jumlah WHERE id_barang = $id_barang";
        if (mysqli_query($koneksi, $query)) {
            echo "<script>alert('Stok berhasil ditambahkan!'); window.location.href='barang.php';</script>";
        } else {
            echo "<script>alert('Gagal menambah stok!'); window.location.href='barang.php';</script>";
        }
    } else {
        echo "<script>alert('Jumlah harus lebih dari 0!'); window.location.href='barang.php';</script>";
    }
} else {
    header("Location: barang.php");
    exit();
}
?>
