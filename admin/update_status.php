<?php
include "../koneksi.php";

if (!isset($_GET['id'])) {
    die("ID pesanan tidak ditemukan");
}

$pemesanan_id = intval($_GET['id']);

// Ambil data pesanan dulu
$query = mysqli_query($koneksi, "SELECT status FROM pemesanan WHERE pemesanan_id = $pemesanan_id");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    die("Pesanan tidak ditemukan");
}

$status_sekarang = $data['status'];

// Tentukan status baru berdasarkan tombol yang diklik
if (isset($_POST['kemas']) && $status_sekarang == 'pending') {
    $status_baru = 'processing';
} elseif (isset($_POST['kirim']) && $status_sekarang == 'processing') {
    $status_baru = 'shipped';
} elseif (isset($_POST['selesai']) && $status_sekarang == 'shipped') {
    $status_baru = 'completed';
} else {
    die("Aksi tidak valid atau status tidak sesuai");
}

// Update status di database
$update = mysqli_query($koneksi, "UPDATE pemesanan SET status = '$status_baru' WHERE pemesanan_id = $pemesanan_id");

if ($update) {
    // Redirect kembali ke halaman detail pesanan agar terlihat status terbaru
    header("Location: detail_pemesanan.php?id=$pemesanan_id&update=success");
} else {
    echo "Gagal update status: " . mysqli_error($koneksi);
}
?>
