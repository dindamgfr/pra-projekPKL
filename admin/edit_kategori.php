<?php
include "sidebar.php";
include "../koneksi.php";
include "session.php";

$id = $_GET['id'] ?? 0;

// Ambil data kategori berdasarkan ID
$query = mysqli_query($koneksi, "SELECT * FROM kategori WHERE kategori_id = '$id'");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    echo "<script>alert('Data tidak ditemukan'); window.location.href='kategori.php';</script>";
    exit;
}

// Proses update
if (isset($_POST['update'])) {
    $namaBaru = htmlspecialchars(trim($_POST['kategori']));

    if ($namaBaru != '') {
        $cek = mysqli_query($koneksi, "SELECT * FROM kategori WHERE nama_kategori = '$namaBaru' AND kategori_id != '$id'");
        if (mysqli_num_rows($cek) == 0) {
            $update = mysqli_query($koneksi, "UPDATE kategori SET nama_kategori = '$namaBaru' WHERE kategori_id = '$id'");
            if ($update) {
                echo "<script>alert('Data berhasil diupdate'); window.location.href='kategori.php';</script>";
            } else {
                echo "<div class='alert alert-danger'>Gagal mengupdate data.</div>";
            }
        } else {
            echo "<div class='alert alert-warning'>Kategori sudah ada.</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Nama kategori tidak boleh kosong.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Kategori</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="main-content p-5">
    <h2>Edit Kategori</h2>
    <form action="" method="post" class="mt-3 col-md-6">
        <div class="mb-3">
            <label for="kategori" class="form-label">Nama Kategori</label>
            <input type="text" name="kategori" id="kategori" value="<?= $data['nama_kategori'] ?>" class="form-control">
        </div>
        <button type="submit" name="update" class="btn btn-primary">Update</button>
        <a href="kategori.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>
</body>
</html>
