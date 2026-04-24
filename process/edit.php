<?php
require '../config/koneksi.php';
if (isset($_POST['update'])) {
    $id = $_POST['id']; $nama = $_POST['nama_barang']; $stok = $_POST['stok']; $harga = $_POST['harga'];
    mysqli_query($conn, "UPDATE barang SET nama_barang='$nama', stok='$stok', harga='$harga' WHERE id=$id");
    header("Location: ../index.php");
}
?>