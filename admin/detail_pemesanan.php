<?php
include "../koneksi.php";
$pemesanan_id = $_GET['id']; // ambil ID dari URL

$query = mysqli_query($koneksi, "SELECT 
    p.pemesanan_id,
    p.tanggal_pemesanan,
    pb.metode_pembayaran,
    pb.tanggal_pembayaran,
    pb.total AS total_pembayaran,
    p.nama_penerima,
    p.no_hp,
    p.alamat,
    p.status,
    p.harga_total
FROM pemesanan p
JOIN pembayaran pb ON p.pembayaran_id = pb.pembayaran_id
WHERE p.pemesanan_id = $pemesanan_id
");

$data = mysqli_fetch_assoc($query);


$query_produk_sql = "SELECT 
    pr.nama AS nama_produk,
    pr.images,
    dp.jumlah AS qty,
    dp.harga_satuan AS harga,
    k.nama_kategori
FROM detail_pemesanan dp
JOIN produk pr ON dp.produk_id = pr.produk_id
JOIN kategori k ON pr.kategori_id = k.kategori_id
WHERE dp.pemesanan_id = {$data['pemesanan_id']}";


$query_produk = mysqli_query($koneksi, $query_produk_sql);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Detail Pemesanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { padding: 30px; background-color: #f8f9fa; font-family: 'Inter', sans-serif; }
        .box { background: #fff; border-radius: 12px; padding: 20px; box-shadow: 0 2px 12px rgba(0,0,0,0.05); margin-bottom: 20px; }
        .section-title { font-weight: bold; font-size: 20px; margin-bottom: 10px; }
        .info-row { display: flex; justify-content: space-between; margin-bottom: 8px; }
        .info-row span:first-child { font-weight: 500; }
        .badge-status { padding: 4px 12px; border-radius: 8px; background-color: #2563eb; color: white; }
        .table th { background-color: #dbeafe; color: #1e3a8a; }
    </style>
</head>
<body>

<h3 class="mb-4">Detail Transaksi</h3>

<div class="row">
    <div class="col-md-6">
        <div class="box">
            <div class="section-title">Data Pembayaran</div>
            <div class="info-row"><span>ID Pesanan:</span><span>#<?= $data['pemesanan_id'] ?></span></div>
            <div class="info-row"><span>Nama:</span><span><?= $data['nama_penerima'] ?></span></div>
            <div class="info-row"><span>No. HP:</span><span><?= $data['no_hp'] ?></span></div>
            <div class="info-row"><span>Tanggal Pesanan:</span><span><?= date('d M Y', strtotime($data['tanggal_pemesanan'])) ?></span></div>
            <div class="info-row"><span>Metode Pembayaran:</span><span><?= $data['metode_pembayaran'] ?></span></div>
            <div class="info-row"><span>Total Belanja:</span><span>Rp. <?= number_format($data['total_pembayaran'], 0, ',', '.') ?></span></div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="box">
            <div class="section-title">Data Pengiriman</div>
            <div class="info-row"><span>Nama Penerima:</span><span><?= $data['nama_penerima'] ?></span></div>
            <div class="info-row"><span>No. HP Penerima:</span><span><?= $data['no_hp'] ?></span></div>
            <div class="info-row"><span>Alamat Penerima:</span><span><?= $data['alamat'] ?></span></div>
            <div class="info-row"><span>Status Pesanan:</span><span class="badge-status <?= $data['status'] ?>"><?= ucfirst($data['status']) ?></span></span></span></div>
           <form method="post" action="update_status.php?id=<?= $data['pemesanan_id'] ?>">
            <?php if ($data['status'] == 'pending') : ?>
                <button type="submit" name="kemas" class="btn btn-success mt-3">Kemas Pesanan</button>
            <?php elseif ($data['status'] == 'processing') : ?>
                <button type="submit" name="kirim" class="btn btn-primary mt-3">Pesanan Dikirim</button>
            <?php elseif ($data['status'] == 'shipped') : ?>
                <button type="submit" name="selesai" class="btn btn-warning mt-3">Selesaikan Pesanan</button>
            <?php endif; ?>
           </form>


        </div>
    </div>
</div>

<div class="box">
    <div class="section-title">Detail Produk</div>
    <table class="table table-bordered">
       <thead>
            <tr>
                <th>No</th>
                <th>Foto</th>
                <th>Nama Produk</th>
                <th>Total Produk</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Jumlah</th>
            </tr>
        </thead>

        <tbody>
            <?php
            $no = 1;
                while ($row = mysqli_fetch_assoc($query_produk)) {
                    $jumlah = $row['qty'] * $row['harga'];
                    echo "<tr>
                        <td>{$no}</td>
                        <td><img src='../gambar/" . htmlspecialchars($row['images']) . "' alt='' width='80'></td>
                        <td>{$row['nama_produk']}</td>
                        <td>{$row['qty']}</td>
                        <td>{$row['nama_kategori']}</td>
                        <td>Rp. " . number_format($row['harga'], 0, ',', '.') . "</td>
                        <td>Rp. " . number_format($jumlah, 0, ',', '.') . "</td>
                    </tr>";
                    $no++;
                }
            ?>

        </tbody>
    </table>
</div>

</body>
</html>
