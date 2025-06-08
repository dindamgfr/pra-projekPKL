<?php
include "../koneksi.php";
include "session.php";

$id = $_GET['id'] ?? 0;

// Cek apakah kategori ada
$query = mysqli_query($koneksi, "SELECT * FROM kategori WHERE kategori_id = '$id'");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    echo "<script>alert('Kategori tidak ditemukan'); window.location.href='kategori.php';</script>";
    exit;
}

// Hapus data
$hapus = mysqli_query($koneksi, "DELETE FROM kategori WHERE kategori_id = '$id'");

if ($hapus) {
    echo "<script>alert('Kategori berhasil dihapus'); window.location.href='kategori.php';</script>";
} else {
    echo "<script>alert('Gagal menghapus kategori'); window.location.href='kategori.php';</script>";
}
?>
