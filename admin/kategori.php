<?php
include "sidebar.php";
include "../koneksi.php";

// Variabel alert
$alert = "";

// Tambah kategori
if (isset($_POST['simpan_kategori'])) {
    $nama = htmlspecialchars(trim($_POST['kategori']));

    if (empty($nama)) {
        $alert = '<div class="alert alert-danger">Kategori tidak boleh kosong.</div>';
    } else {
        // Cek duplikat
        $cek = mysqli_query($koneksi, "SELECT * FROM kategori WHERE nama_kategori = '$nama'");
        if (mysqli_num_rows($cek) > 0) {
            $alert = '<div class="alert alert-warning">Kategori sudah ada.</div>';
        } else {
            $simpan = mysqli_query($koneksi, "INSERT INTO kategori (nama_kategori) VALUES ('$nama')");
            if ($simpan) {
                $alert = '<div class="alert alert-success">Kategori berhasil ditambahkan.</div>';
            } else {
                $alert = '<div class="alert alert-danger">Gagal menambahkan kategori.</div>';
            }
        }
    }
}

$queryKategori = mysqli_query($koneksi, "SELECT * FROM kategori ORDER BY kategori_id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Kategori</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
       body {
    margin: 0;
    padding: 0;
    font-family: 'Inter', sans-serif;
    display: flex;
}
        
        .main-content {
            flex: 1;
            padding: 30px 30px 30px 40px;
            background: #ffffff;
        }
        .table-container {
            background: linear-gradient(to bottom right, #e0e7ff, #c7d2fe);
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.04);
        }
        h2 {
            font-weight: bold;
            margin-bottom: 20px;
            color: #4f46e5;
        }
        .btn-primary {
            background-color: #6366f1;
            border: none;
        }
        .btn-primary:hover {
            background-color: #4f46e5;
        }
        .form-control {
            font-size: 14px;
        }
       .alert {
            margin-bottom: 20px;
            font-size: 14px; /* Tambahkan ini untuk mengecilkan ukuran teks alert */
            padding: 10px 15px;
            border-radius: 6px;
        }

        .btn-edit {
            background-color: #facc15;
            color: #000;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
        }
        .btn-delete {
            background-color: #ef4444;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
        }
        .btn-edit:hover {
            background-color: #eab308;
        }
        .btn-delete:hover {
            background-color: #dc2626;
        }
    </style>
</head>
<body>

<div class="main-content">
    <h2>List Kategori</h2>
    <div class="table-container">
        <?php if (!empty($alert)) : ?>
    <div class="alert alert-danger" style="font-size: 14px;">
        <?= strip_tags($alert) ?>
    </div>
    <?php endif; ?>

        <h4>Tambah Kategori</h4>
        <form method="post" class="mb-4">
            <label for="kategori">Kategori</label>
            <input type="text" name="kategori" id="kategori" placeholder="Input nama kategori" class="form-control">
            <button type="submit" name="simpan_kategori" class="btn btn-primary mt-2">Simpan</button>
        </form>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                while ($data = mysqli_fetch_assoc($queryKategori)) {
                    echo "<tr>
                        <td>$no</td>
                        <td>{$data['nama_kategori']}</td>
                        <td>
                            <a href='edit_kategori.php?id={$data['kategori_id']}' class='btn-edit'><i class='bi bi-pencil'></i></a>
                            <a href='hapus_kategori.php?id={$data['kategori_id']}' class='btn-delete' onclick=\"return confirm('Yakin ingin menghapus?')\"><i class='bi bi-trash'></i></a>
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
