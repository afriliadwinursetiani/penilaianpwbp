<?php
# Membuat koneksi ke database MySQL
$koneksi = mysqli_connect("localhost", "root", "", "barang");

# Cek koneksi
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
    // dead :) mumet
}
?>
