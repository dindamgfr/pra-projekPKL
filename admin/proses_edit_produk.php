<?php
include "../koneksi.php";

// Fungsi untuk membuat nama file acak
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

// Ambil data dari form
$produk_id = $_POST['id'];
$nama = $_POST['nama'];
$kategori_id = $_POST['kategori_id'];
$price_awal = $_POST['price_awal'];
$discount_price = $_POST['discount_price'];
$stok = $_POST['stok'];
$description = $_POST['description'];

// Lokasi folder gambar
$folder = "../gambar/";
$nama_file = basename($_FILES["images"]["name"]);
$image_size = $_FILES["images"]["size"];
$imageFileType = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));
$random_name = generateRandomString(20);
$baru = $random_name . "." . $imageFileType;

if ($nama_file != '') {
    // Validasi ukuran
    if ($image_size > 1000000) {
        echo "<div class='alert alert-warning mt-3'>Foto tidak boleh lebih dari 1MB</div>";
        exit;
    }

    // Validasi ekstensi
    if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
        echo "<div class='alert alert-warning mt-3'>Foto wajib bertipe jpg, jpeg, png, atau gif</div>";
        exit;
    }

    // Pindahkan gambar dan update database termasuk gambar
    if (move_uploaded_file($_FILES["images"]["tmp_name"], $folder . $baru)) {
        $query = "UPDATE produk SET 
                    nama='$nama', 
                    kategori_id='$kategori_id', 
                    price_awal='$price_awal', 
                    discount_price='$discount_price', 
                    stok='$stok', 
                    description='$description', 
                    images='$baru' 
                  WHERE produk_id='$produk_id'";
    } else {
        echo "<div class='alert alert-danger mt-3'>Gagal mengunggah gambar</div>";
        exit;
    }
} else {
    // Update tanpa ubah gambar
    $query = "UPDATE produk SET 
                nama='$nama', 
                kategori_id='$kategori_id', 
                price_awal='$price_awal', 
                discount_price='$discount_price', 
                stok='$stok', 
                description='$description' 
              WHERE produk_id='$produk_id'";
}

$result = mysqli_query($koneksi, $query);

if ($result) {
    echo "<script>alert('Produk berhasil diedit!'); window.location.href = 'dataproduk.php';</script>";
} else {
    echo "Query Error: " . mysqli_error($koneksi);
}
?>