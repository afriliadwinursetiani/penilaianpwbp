<?php
include "../koneksi/koneksi.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_pembeli = $_POST['id_pembeli'];
    $id_barang = $_POST['id_barang'];
    $jumlah = $_POST['jumlah'];

    // ambil data barang
    $cekBarang = mysqli_query($koneksi, "SELECT stok, harga FROM barang WHERE id_barang='$id_barang'");
    $barang = mysqli_fetch_assoc($cekBarang);

    if (!$barang) {
        header("Location: tambahpenjualan.php?error=Barang tidak ditemukan!");
        exit;
    }

    $stokTersedia = $barang['stok'];
    $harga = $barang['harga'];
    $total_harga = $jumlah * $harga;

    // cek stok cukup atau tidak
    if ($jumlah > $stokTersedia) {
        header("Location: tambahpenjualan.php?error=⚠️ Stok tidak cukup! Maksimal hanya bisa membeli  $stokTersedia");
        exit;
    }

    // insert penjualan
    $query = "INSERT INTO penjualan (id_pembeli, id_barang, jumlah, total_harga, tanggal) 
              VALUES ('$id_pembeli','$id_barang','$jumlah','$total_harga',NOW())";
    mysqli_query($koneksi, $query);

    // update stok barang
    $updateStok = $stokTersedia - $jumlah;
    mysqli_query($koneksi, "UPDATE barang SET stok='$updateStok' WHERE id_barang='$id_barang'");

    header("Location: penjualan.php?success=Penjualan berhasil disimpan!");
}
?>
