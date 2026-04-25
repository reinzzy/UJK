<?php
require '../config/koneksi.php';

if (isset($_POST['submit'])) {
    $nama_barang = $_POST['nama_barang'];
    $stok = $_POST['stok'];
    $harga = $_POST['harga'];
    $id_kategori = $_POST['id_kategori'];

    $query = "INSERT INTO barang (nama_barang, stok, harga, id_kategori) 
              VALUES ('$nama_barang', '$stok', '$harga', '$id_kategori')";
    
    if (mysqli_query($conn, $query)) {
        header("Location: ../index.php?status=success");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}