<?php
include "../koneksi.php";
include "sidebar.php";

// Query untuk mendapatkan 5 pesanan terbaru
$query_pesanan_terbaru = mysqli_query($koneksi, "
    SELECT 
        p.pemesanan_id, 
        p.tanggal_pemesanan, 
        p.status, 
        p.harga_total AS total_bayar, 
        pb.metode_pembayaran, 
        GROUP_CONCAT(pr.nama SEPARATOR ', ') AS produk
    FROM pemesanan p
    JOIN detail_pemesanan dp ON p.pemesanan_id = dp.pemesanan_id
    JOIN produk pr ON dp.produk_id = pr.produk_id
    JOIN pembayaran pb ON p.pembayaran_id = pb.pembayaran_id
    GROUP BY p.pemesanan_id
    ORDER BY p.tanggal_pemesanan DESC
    LIMIT 15
");

// Query untuk menghitung total pesanan dan total produk
$query_total_pesanan = mysqli_query($koneksi, "SELECT COUNT(*) AS total_pesanan FROM pemesanan");
$total_pesanan = mysqli_fetch_assoc($query_total_pesanan)['total_pesanan'];

$query_total_produk = mysqli_query($koneksi, "SELECT SUM(dp.jumlah) AS total_produk FROM detail_pemesanan dp");
$total_produk = mysqli_fetch_assoc($query_total_produk)['total_produk'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
body {
    margin: 0;
    padding: 0;
    font-family: 'Inter', sans-serif;
    display: flex;
}
.content {
    flex: 1;
    padding: 20px;
    box-sizing: border-box;
    text-align: left;
}
.box {
    background:; /* Warna selaras dengan sidebar */
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
}
.table th, .table td {
    text-align: center;
    vertical-align: middle;
}
.stat-box {
    text-align: center;
    padding: 20px;
    background: linear-gradient(135deg, #7a91ff, #b2aaff); /* Warna gradasi senada */
    color: white;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}
.stat-box h3 {
    margin: 0;
    font-size: 28px;
    font-weight: bold;
}
.stat-box p {
    margin: 0;
    font-size: 16px;
}
h2 {
    font-size: 32px;
    font-weight: bold;
    color: #333a66; /* Warna teks selaras */
    text-align: left; /* Pastikan teks rata kiri */
    margin-bottom: 20px; /* Tambahkan jarak di bawah */
}

.table th {
    background-color: #6c7eff; /* Warna header tabel senada */
    color: white;
}

/* Sidebar tulisan tidak memisah */
.sidebar .nav-link {
    white-space: nowrap; /* Mencegah teks terpisah */
    overflow: hidden;
    text-overflow: ellipsis; /* Jika terlalu panjang, akan terpotong dengan "..." */
}

    </style>
</head>
<body>
    <!-- Sidebar diimpor melalui include -->
    
    <!-- Konten utama -->
    <div class="content">
        <h2 class="mb-4 text-left">Admin Dashboard</h2>

        <!-- Statistik -->

        <div class="row justify-content-center gap-4">
            <div class="col-md-4 col-10">
                <div class="stat-box">
                    <h3><?= $total_pesanan ?></h3>
                    <p>Total Pemesanan</p>
                </div>
            </div>
            <div class="col-md-4 col-10">
                <div class="stat-box">
                    <h3><?= $total_produk ?></h3>
                    <p>Total Produk</p>
                </div>
            </div>
        </div>

        <!-- Tabel 5 Pesanan Terbaru -->
        <div class="box">
            <h4 class="mb-3">5 Pesanan Terbaru</h4>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Produk</th>
                        <th>ID Pesanan</th>
                        <th>Total Bayar</th>
                        <th>Metode Pembayaran</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($pesanan = mysqli_fetch_assoc($query_pesanan_terbaru)) : ?>
                        <tr>
                            <td><?= date('d M Y', strtotime($pesanan['tanggal_pemesanan'])) ?></td>
                            <td><?= $pesanan['produk'] ?></td>
                            <td>#<?= $pesanan['pemesanan_id'] ?></td>
                            <td>Rp. <?= number_format($pesanan['total_bayar'], 0, ',', '.') ?></td>
                            <td><?= $pesanan['metode_pembayaran'] ?></td>
                            <td>
                                <span class="badge bg-<?= $pesanan['status'] === 'selesai' ? 'success' : 'secondary' ?>">
                                    <?= ucfirst($pesanan['status']) ?>
                                </span>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
