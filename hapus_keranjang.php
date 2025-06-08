<?php
session_start();
include "koneksi.php";

// Pastikan user sudah login
if (!isset($_SESSION['users_id'])) {
    header("Location: login.php");
    exit;
}

$users_id = $_SESSION['users_id'];
$keranjang_id = $_POST['keranjang_id'];  // Ambil ID keranjang yang ingin dihapus

// Hapus produk dari keranjang
mysqli_query($koneksi, "DELETE FROM keranjang WHERE keranjang_id = $keranjang_id AND users_id = $users_id");

header("Location: shopping_bag.php");
?>
