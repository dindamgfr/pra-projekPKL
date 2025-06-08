<?php
include "../koneksi.php";
include "sidebar.php"; // Include sidebar untuk menu navigasi

// Ambil data pesanan dengan status 'processing' (sedang dikemas)
$query = mysqli_query($koneksi, "
    SELECT 
        p.pemesanan_id, 
        p.nama_penerima, 
        p.no_hp, 
        p.alamat, 
        p.tanggal_pemesanan, 
        p.status, 
        p.harga_total,
        pb.metode_pembayaran
    FROM pemesanan p
    LEFT JOIN pembayaran pb ON p.pembayaran_id = pb.pembayaran_id
    WHERE p.status = 'processing'
    ORDER BY p.tanggal_pemesanan DESC
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Pesanan Dikemas</title>
    <link 
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" 
      rel="stylesheet" 
    />
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Inter', sans-serif;
        }
        .main-content {
            margin-left: 290px; /* Sesuaikan dengan lebar sidebar */
            padding: 30px;
            min-height: 100vh;
        }
        .table th {
            background-color: #dbeafe;
            color: #1e3a8a;
        }
        .badge-status {
            padding: 4px 12px;
            border-radius: 8px;
            background-color: #2563eb;
            color: white;
            text-transform: capitalize;
        }
    </style>
</head>
<body>

<div class="main-content">
    <h3 class="mb-4">Daftar Pesanan Dikemas</h3>

    <table class="table table-bordered table-striped align-middle">
        <thead>
            <tr>
                <th>ID Pesanan</th>
                <th>Nama Penerima</th>
                <th>No. HP</th>
                <th>Alamat</th>
                <th>Tanggal Pesanan</th>
                <th>Metode Pembayaran</th>
                <th>Total Harga</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if(mysqli_num_rows($query) > 0): ?>
                <?php while($row = mysqli_fetch_assoc($query)): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['pemesanan_id']) ?></td>
                        <td><?= htmlspecialchars($row['nama_penerima']) ?></td>
                        <td><?= htmlspecialchars($row['no_hp']) ?></td>
                        <td><?= htmlspecialchars($row['alamat']) ?></td>
                        <td><?= date('d M Y', strtotime($row['tanggal_pemesanan'])) ?></td>
                        <td><?= htmlspecialchars($row['metode_pembayaran']) ?></td>
                        <td>Rp <?= number_format($row['harga_total'], 0, ',', '.') ?></td>
                        <td><span class="badge-status"><?= htmlspecialchars($row['status']) ?></span></td>
                        <td>
                            <a href="detail_pemesanan.php?id=<?= urlencode($row['pemesanan_id']) ?>" 
                               class="btn btn-primary btn-sm">
                                Kirim Pesanan
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="9" class="text-center">Tidak ada pesanan dalam tahap dikemas.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>
