<?php
include "../koneksi/koneksi.php";

$nama   = $_POST['nama'];
$alamat  = $_POST['alamat'];
$telp = $_POST['telp'];

$query = "INSERT INTO pembeli (nama,alamat,telp) VALUES ('$nama','$alamat','$telp')";
mysqli_query($koneksi, $query);

header("Location: pembeli.php");
?>
