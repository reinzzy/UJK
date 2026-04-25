<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require '../config/koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM barang WHERE id = '$id'";

    if (mysqli_query($conn, $sql)) {
        header("Location: ../index.php?pesan=hapus_sukses");
        exit;
    } else {
        die("Gagal Hapus: " . mysqli_error($conn));
    }
} else {
    die("Akses Ditolak: ID tidak ditemukan di URL.");
}