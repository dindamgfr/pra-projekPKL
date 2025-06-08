<?php include "sidebar.php"; ?>
<?php include "../koneksi.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Data Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #ffffff;
            margin: 0;
            display: flex;
        }
        .main-content {
            flex: 1;
            padding: 30px;
            background: #ffffff;
        }
        .table-container {
            background: linear-gradient(to bottom right, #e0f2fe, #bae6fd);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.05);
        }
        h2 {
            font-weight: bold;
            margin-bottom: 20px;
            color: #0369a1;
        }
        .btn-tambah {
            background-color: #0ea5e9;
            color: white;
            font-weight: 500;
            border-radius: 8px;
        }
        .btn-tambah:hover {
            background-color: #0369a1;
        }
        .badge-merah {
            background-color: #f87171;
            color: white;
            font-size: 0.85rem;
            padding: 4px 10px;
            border-radius: 8px;
        }
        .badge-biru {
            background-color: #38bdf8;
            color: white;
            font-size: 0.85rem;
            padding: 4px 10px;
            border-radius: 8px;
        }
        .icon-button {
            border: none;
            background-color: #e2e8f0;
            padding: 6px 10px;
            border-radius: 6px;
            margin: 0 3px;
        }
        .icon-button:hover {
            background-color: #cbd5e1;
        }
        .table th, .table td {
            vertical-align: middle;
            text-align: center;
        }
        .table thead th {
            background-color: #0ea5e9;
            color: white;
            font-weight: 600;
        }
        input[type="text"] {
            border: 1px solid #999;
            border-radius: 4px;
            padding: 5px 10px;
        }
        .search-bar {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="main-content">
        <h2>Data Produk</h2>

        <div class="table-container">
            <div class="search-bar d-flex justify-content-between align-items-center mb-3">
                <div>
                    <label for="search">Search :</label>
                    <input type="text" id="search" placeholder="Cari produk...">
                </div>
                <a href="tambah_produk.php" class="btn btn-tambah"><i class="bi bi-plus-circle"></i> Tambah</a>
            </div>

            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Foto</th>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Diskon</th>
                        <th>Stok</th>
                        <th>Status</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $no = 1;
                $query = mysqli_query($koneksi, "SELECT produk.*, kategori.nama_kategori FROM produk JOIN kategori ON produk.kategori_id = kategori.kategori_id");
                while($data = mysqli_fetch_array($query)) {
                    $status = ($data['stok'] > 0) ? '<span class=\'badge-biru\'>Aktif</span>' : '<span class=\'badge-merah\'>Non Aktif</span>';
                    $diskon = ($data['discount_price'] > 0) ? '<span class=\'badge-merah\'>'.$data['discount_price'].'%</span>' : '<span class=\'badge-merah\'>Tidak ada</span>';
                ?>
                    <tr>
                        <td><?= $no++ ?>.</td>
                        <td><img src="../gambar/<?= $data['images'] ?>" width="60" class="img-thumbnail"></td>
                        <td><?= $data['nama'] ?></td>
                        <td><?= $data['nama_kategori'] ?></td>
                        <td>Rp. <?= number_format($data['price_awal'], 0, ',', '.') ?></td>
                        <td><?= $diskon ?></td>
                        <td><?= $data['stok'] ?></td>
                        <td><?= $status ?></td>
                        <td>
                            <a href="edit_produk.php?id=<?= $data['produk_id'] ?>" class="icon-button"><i class="bi bi-pencil-square"></i></a>
                            <a href="hapus_produk.php?id=<?= $data['produk_id'] ?>" class="icon-button"><i class="bi bi-trash"></i></a>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
