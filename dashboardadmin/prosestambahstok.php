<?php
session_start();
include "../koneksi/koneksi.php";
if (!isset($_SESSION['username']) || !isset($_SESSION['role'])) {
    header("Location: ../login/login.php");
    exit();
}
if (!in_array($role, ['admin','suplier','kasir'])) {
    header("Location: ../login/login.php");
    exit();
}
if ($_POST) {
  $id = $_POST['idproduk'];
  $jml = $_POST['jumlah'];
  mysqli_query($koneksi,"UPDATE produk SET stokproduk=stokproduk+$jml WHERE idproduk='$id'");
}
header("Location: tambahstok.php");
