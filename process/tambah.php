<?php
require '../config/koneksi.php';

if (isset($_POST['submit'])) {
    $nama  = mysqli_real_escape_string($conn, $_POST['nama_barang']);
    $stok  = $_POST['stok'];
    $harga = $_POST['harga'];

    $query = "INSERT INTO barang (nama_barang, stok, harga) VALUES ('$nama', '$stok', '$harga')";
    
    if (mysqli_query($conn, $query)) {
        header("Location: ../index.php");
        exit;
    } else {
        echo "Gagal: " . mysqli_error($conn);
    }
}
?>