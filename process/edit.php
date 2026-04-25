<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require '../config/koneksi.php';

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama_barang'];
    $stok = $_POST['stok'];
    $harga = $_POST['harga'];
    $id_kategori = $_POST['id_kategori'];

    $kat_value = !empty($id_kategori) ? "'$id_kategori'" : "NULL";

    $query = "UPDATE barang SET 
              nama_barang = '$nama', 
              stok = '$stok', 
              harga = '$harga', 
              id_kategori = $kat_value 
              WHERE id = '$id'";

    if (mysqli_query($conn, $query)) {
        header("Location: ../index.php?status=sukses");
        exit;
    } else {
        die("Gagal update data: " . mysqli_error($conn));
    }
} else {
    header("Location: ../index.php");
    exit;
}
?>