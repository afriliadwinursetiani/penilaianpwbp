<?php
include "../koneksi/koneksi.php";

$id_pembeli = $_POST['id_pembeli'];
$id_barang  = $_POST['id_barang'];
$jumlah     = $_POST['jumlah'];

# ambil harga barang
$result = mysqli_query($koneksi, "SELECT harga FROM barang WHERE id_barang=$id_barang");
$data   = mysqli_fetch_assoc($result);
$harga  = $data['harga'];

$total = $harga * $jumlah;

# simpan ke tabel penjualan
$query = "INSERT INTO penjualan (id_pembeli, id_barang, jumlah, total_harga) 
          VALUES ('$id_pembeli','$id_barang','$jumlah','$total')";
mysqli_query($koneksi, $query);

header("Location: penjualan.php");
?>
