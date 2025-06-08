<?php
include "../koneksi.php";

if (isset($_GET['id'])) {
    $produk_id = $_GET['id'];

    $sql = "DELETE FROM produk WHERE produk_id='$produk_id'";
    $query = mysqli_query($koneksi, $sql);

    if ($query) {
        header("Location: dataproduk.php?hapus=sukses");
        exit;
    } else {
        header("Location: dataproduk.php?hapus=gagal");
        exit;
    }
} else {
    header("Location: dataproduk.php?hapus=notfound");
    exit;
}
