<?php
include "../koneksi/koneksi.php";

$id    = $_POST['id_barang'];
$nama  = $_POST['nama_barang'];
$harga = $_POST['harga'];
$stok  = $_POST['stok'];

$query = "UPDATE barang SET nama_barang='$nama', harga='$harga', stok='$stok' WHERE id_barang=$id";
mysqli_query($koneksi, $query);

header("Location: barang.php");
?>
