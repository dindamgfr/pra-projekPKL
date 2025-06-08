<?php
session_start();
include 'koneksi.php';

// Pastikan user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$produk_id = $_GET['id'];
$jumlah = 1;

// Cek apakah produk sudah ada di keranjang
$cek = mysqli_query($koneksi, "SELECT * FROM keranjang WHERE users_id='$user_id' AND produk_id='$produk_id'");
if (mysqli_num_rows($cek) > 0) {
    // Jika sudah ada, tambah jumlah_produk
    mysqli_query($koneksi, "UPDATE keranjang SET jumlah_produk = jumlah_produk + 1 WHERE users_id='$user_id' AND produk_id='$produk_id'");
} else {
    // Jika belum ada, tambahkan ke keranjang
    mysqli_query($koneksi, "INSERT INTO keranjang (users_id, produk_id, jumlah_produk, subtotal) 
                            VALUES ('$user_id', '$produk_id', '$jumlah', 0)");
}

// Redirect
$_SESSION['notif'] = "Produk berhasil ditambahkan ke keranjang!";
header("Location: shopping_bag.php");
exit;
?>
