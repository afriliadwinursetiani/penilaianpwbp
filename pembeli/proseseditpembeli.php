<?php
include "../koneksi/koneksi.php";

$id     = $_POST['id_pembeli'];
$nama   = $_POST['nama'];
$alamat = $_POST['alamat'];
$telp = $_POST['telp'];

$query = "UPDATE pembeli SET nama='$nama', alamat='$alamat',telp='$telp' WHERE id_pembeli=$id";
mysqli_query($koneksi, $query);

header("Location: pembeli.php");
?>
