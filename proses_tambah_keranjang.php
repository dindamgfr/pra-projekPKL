<?php
session_start();
include "koneksi.php";

if (isset($_POST['add_to_bag'])) {
    if (!isset($_SESSION['users_id'])) {
        die("Silakan login terlebih dahulu.");
    }

    $produk_id = intval($_POST['produk_id']);
    $jumlah_produk = intval($_POST['jumlah_produk']);
    $users_id = intval($_SESSION['users_id']);

    // Ambil harga dari database
    $query = mysqli_query($koneksi, "SELECT price_awal, discount_price FROM produk WHERE produk_id = $produk_id");
    $data = mysqli_fetch_assoc($query);

    if (!$data) {
        die("Produk tidak ditemukan.");
    }

    $harga = (!empty($data['discount_price']) && $data['discount_price'] < $data['price_awal']) ? $data['discount_price'] : $data['price_awal'];
    $subtotal = $harga * $jumlah_produk;

    $insert = mysqli_query($koneksi, "INSERT INTO keranjang (users_id, produk_id, jumlah_produk, subtotal) 
              VALUES ($users_id, $produk_id, $jumlah_produk, $subtotal)");

    if ($insert) {
        header("Location: shopping_bag.php");
    } else {
        echo "Gagal menambahkan ke keranjang: " . mysqli_error($koneksi);
    }
}
?>  