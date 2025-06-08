<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['users_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['users_id'];

// Cek apakah session checkout tersedia
if (!isset($_SESSION['checkout']) || !is_array($_SESSION['checkout'])) {
    die("Data checkout tidak ditemukan. Silakan kembali ke halaman checkout.");
}

// Ambil data dari session
$produk_terpilih     = $_SESSION['checkout']['produk'] ?? null;
$metode_pembayaran   = $_SESSION['checkout']['metode_pembayaran'] ?? null;
$alamat              = $_SESSION['checkout']['alamat'] ?? null;
$nama_penerima       = $_SESSION['checkout']['nama_penerima'] ?? null;
$no_hp               = $_SESSION['checkout']['no_hp'] ?? null;
$username            = $_SESSION['checkout']['username'] ?? null; // dari input gopay/shopeepay
$pin                 = $_SESSION['checkout']['pin'] ?? null;
$ongkir              = intval($_SESSION['checkout']['ongkir'] ?? 0);

// Validasi data wajib
if (
    empty($produk_terpilih) || 
    empty($alamat) || 
    empty($nama_penerima) || 
    empty($no_hp) || 
    empty($metode_pembayaran) || 
    empty($pin)
) {
    die("Data tidak lengkap. Silakan kembali ke halaman checkout.");
}

// Hitung total harga produk + ongkir
$total_harga = 0;
foreach ($produk_terpilih as $produk) {
    $harga = floatval($produk['harga']);
    $jumlah = intval($produk['jumlah']);
    $total_harga += $harga * $jumlah;
}
$total_harga += $ongkir;

// Langkah 1: Masukkan ke tabel `pemesanan`
$tanggal_pemesanan = date('Y-m-d H:i:s');
$status_pesanan = 'pending';

$query_pemesanan = "INSERT INTO pemesanan (users_id, tanggal_pemesanan, status, harga_total, alamat, nama_penerima, no_hp, ongkir) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $koneksi->prepare($query_pemesanan);
$stmt->bind_param("issdsssi", $user_id, $tanggal_pemesanan, $status_pesanan, $total_harga, $alamat, $nama_penerima, $no_hp, $ongkir);
$stmt->execute();
$pemesanan_id = $stmt->insert_id;
$stmt->close();

// Langkah 2: Masukkan ke tabel `pembayaran`
$tanggal_pembayaran = $tanggal_pemesanan;

$query_pembayaran = "INSERT INTO pembayaran (pemesanan_id, metode_pembayaran, tanggal_pembayaran, total, username, pin)
                     VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $koneksi->prepare($query_pembayaran);
$stmt->bind_param("issdss", $pemesanan_id, $metode_pembayaran, $tanggal_pembayaran, $total_harga, $username, $pin);
$stmt->execute();
$pembayaran_id = $stmt->insert_id;
$stmt->close();

// Langkah 3: Update pemesanan agar menyimpan id pembayaran
$update_query = "UPDATE pemesanan SET pembayaran_id = ? WHERE pemesanan_id = ?";
$stmt = $koneksi->prepare($update_query);
$stmt->bind_param("ii", $pembayaran_id, $pemesanan_id);
$stmt->execute();
$stmt->close();

// Langkah 4: Masukkan ke tabel `detail_pemesanan`
foreach ($produk_terpilih as $produk) {
    $produk_id = intval($produk['produk_id']);
    $jumlah = intval($produk['jumlah']);
    $harga_satuan = floatval($produk['harga']);

    $query_detail = "INSERT INTO detail_pemesanan (pemesanan_id, produk_id, jumlah, harga_satuan)
                     VALUES (?, ?, ?, ?)";
    $stmt = $koneksi->prepare($query_detail);
    $stmt->bind_param("iiid", $pemesanan_id, $produk_id, $jumlah, $harga_satuan);
    $stmt->execute();
    $stmt->close();
}

// Langkah 5: Hapus dari keranjang jika berasal dari keranjang
if (
    isset($_SESSION['checkout']['dari_keranjang']) &&
    $_SESSION['checkout']['dari_keranjang'] === true &&
    !empty($_SESSION['checkout']['keranjang_ids'])
) {
    $keranjang_ids = $_SESSION['checkout']['keranjang_ids'];
    $in = implode(',', array_map('intval', $keranjang_ids));
    $delete_query = "DELETE FROM keranjang WHERE keranjang_id IN ($in) AND users_id = $user_id";
    $koneksi->query($delete_query);
}

// Bersihkan session
unset($_SESSION['checkout']);
unset($_SESSION['keranjang']);

// Redirect
header("Location: my_orders.php?pemesanan=sukses");
exit();
?>
