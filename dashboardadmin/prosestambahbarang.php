<?php
include "../koneksi/koneksi.php";

$nama  = $_POST['nama_barang'];
$harga = $_POST['harga'];
$stok  = $_POST['stok'];

# query insert
$query = "INSERT INTO barang (nama_barang,harga,stok) VALUES ('$nama','$harga','$stok')";
mysqli_query($koneksi, $query);

header("Location: barang.php");
?>
