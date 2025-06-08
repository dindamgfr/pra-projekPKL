<?php
include 'koneksi.php';

if (isset($_POST['keranjang_id']) && isset($_POST['action'])) {
    $keranjang_id = $_POST['keranjang_id'];
    $action = $_POST['action'];

    // Ambil jumlah saat ini
    $query = mysqli_query($koneksi, "SELECT jumlah_produk FROM keranjang WHERE keranjang_id = $keranjang_id");
    $data = mysqli_fetch_assoc($query);
    $current_qty = $data['jumlah_produk'];

    if ($action == 'increase') {
        $new_qty = $current_qty + 1;
    } elseif ($action == 'decrease' && $current_qty > 1) {
        $new_qty = $current_qty - 1;
    } else {
        $new_qty = $current_qty;
    }

    // Update database
    mysqli_query($koneksi, "UPDATE keranjang SET jumlah_produk = $new_qty WHERE keranjang_id = $keranjang_id");

    echo json_encode(['success' => true, 'new_qty' => $new_qty]);
}
?>
