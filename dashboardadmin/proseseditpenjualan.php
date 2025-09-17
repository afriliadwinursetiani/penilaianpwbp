<?php
include "../koneksi/koneksi.php";

$id_penjualan = $_POST['id_penjualan'];
$id_pembeli   = $_POST['id_pembeli'];
$id_barang    = $_POST['id_barang'];
$jumlah       = $_POST['jumlah'];

# ambil harga barang
$result = mysqli_query($koneksi, "SELECT harga FROM barang WHERE id_barang=$id_barang");
$data   = mysqli_fetch_assoc($result);
$harga  = $data['harga'];

$total = $harga * $jumlah;

# update data penjualan
$query = "UPDATE penjualan 
          SET id_pembeli='$id_pembeli', id_barang='$id_barang', jumlah='$jumlah', total_harga='$total'
          WHERE id_penjualan=$id_penjualan";
mysqli_query($koneksi, $query);

header("Location: penjualan.php");
?>
