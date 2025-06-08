<?php
include "../koneksi.php";

$query = mysqli_query($koneksi, "SELECT 
    p.pemesanan_id,
    p.tanggal_pemesanan,
    dp.produk_id,
    pb.metode_pembayaran,
    pb.tanggal_pembayaran,
    pb.total AS total_pembayaran
FROM pemesanan p
JOIN detail_pemesanan dp ON p.pemesanan_id = dp.pemesanan_id
JOIN pembayaran pb ON p.pembayaran_id = pb.pembayaran_id
ORDER BY p.pemesanan_id DESC
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Masuk | Glowgenic </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter' , sans-serif; 
        }
        body{
            display: flex;
            height: 100vh;
            background-color: #f8f9fa;
            padding-top: 20px;
            padding-bottom: 20px;
            padding-left: 20px;
        }
        .main{
            flex-grow: 1;
            padding: 30px;
            overflow-y: auto;
            padding-top: 50px;
        }
        .header{
            font-size: 26px;
            font-weight: bold;
            margin-bottom: 30px;
        }
        .cards{
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
        }
        .card{
            background: linear-gradient(to bottom right, #f0f4ff, #e0e7ff);
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.05);
            flex: 1;
        }
        .card h4{
            font-size: 14px;
            color: #6b7280;
        }
        .card p{
            font-size: 18px;
            font-weight: bold;
            color: #111827;
        }
        .table-section{
            background: linear-gradient(to bottom right, #f0f4ff, #e0e7ff);
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.05);
            padding: 20px;
        }
        .table{
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            
        }
        th, td{
            text-align: left;
            padding: 12px 10px;
            border-bottom: 1px solid #e5e7eb;
        }
        th{
            background-color: #dbeafe;
            color: #1e3a8a;
        }
        td{
            color: #1f2937;
        }
    </style>
</head>
<body>
    <?php include "sidebar.php";?>

<div class="main">
    <div class="header">Daftar Pesanan</div>
    <div class="table-section">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Produk</th>
                    <th>Foto Produk</th>
                    <th>Tanggal Pemesanan</th>
                    <!-- <th>Jumlah</th> -->
                    <!-- <th>Harga Satuan</th> -->
                    <th>Metode Pembayaran</th>
                    <!-- <th>Total Pembayaran</th> -->
                    <th>Opsi</th>
                
                </tr>
            </thead>
            <tbody>
                
                <?php
                $query = "SELECT 
                    p.pemesanan_id,
                    p.tanggal_pemesanan,
                    pr.nama AS nama_produk,
                    pr.images,
                    pb.metode_pembayaran,
                    pb.tanggal_pembayaran,
                    pb.total AS total_pembayaran
                FROM pemesanan p
                JOIN detail_pemesanan dp ON p.pemesanan_id = dp.pemesanan_id
                JOIN produk pr ON dp.produk_id = pr.produk_id
                JOIN pembayaran pb ON p.pembayaran_id = pb.pembayaran_id
                ORDER BY p.pemesanan_id DESC";

                $result = mysqli_query($koneksi, $query);

                // Tambahkan variabel counter
                $no = 1;

                while($row = mysqli_fetch_assoc($result)) {
                    $tanggal_pemesanan = date('Y-m-d', strtotime($row['tanggal_pemesanan']));
                    $tanggal_pembayaran = $row['tanggal_pembayaran'] ? date('Y-m-d', strtotime($row['tanggal_pembayaran'])) : '-';

                    echo "<tr>
                        <td>{$no}</td> 
                        <td>{$row['nama_produk']}</td>
                        <td><img src='../gambar/" . htmlspecialchars($row['images']) . "' alt='' width='80'></td>
                        <td>{$tanggal_pemesanan}</td>
                        <td>{$row['metode_pembayaran']}</td>
                        <td>
                            <a href='detail_pemesanan.php?id={$row['pemesanan_id']}' class='btn btn-sm btn-primary'>
                            Detail Transaksi
                            </a>
                        </td>
                    </tr>";
                    $no++;
                }
                ?>
            </tbody>
        </table>
    </div>
</div>


</body>
</html>