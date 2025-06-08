<?php
session_start();
include "koneksi.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $queryProduk = mysqli_query($koneksi, "SELECT * FROM produk WHERE produk_id = $id");
    $produk = mysqli_fetch_array($queryProduk);
} else {
    echo "<script>alert('Produk tidak ditemukan'); window.location.href='index.php';</script>";
    exit;
}

    //penjumlahan dan pengurangan
    $angka = isset($_POST['angka']) ? (int)$_POST['angka'] : 1;
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['tambah'])) {
            $angka += 1;
        } elseif (isset($_POST['kurang'])) {
            $angka -= 1;
        }
    }

$harga_awal = $produk['price_awal'];
$diskon_persen = $produk['discount_price']; // ini dalam persen, misalnya 20 berarti 20%
$harga_setelah_diskon = $harga_awal - ($diskon_persen / 100 * $harga_awal);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Detail Produk | Glowgenic</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Open+Sans&display=swap" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to bottom, #fff0f5, #fdfdfd);
            font-family: 'Open Sans', sans-serif;
            color: #333;
        }
        .product-container {
            max-width: 1200px;
            margin: 60px auto;
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        .product-image {
            max-width: 90%;
            height: auto;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }
        .price {
            font-size: 28px;
            color: #ff6b81;
            font-weight: bold;
        }
        .btn-add, .btn-buy {
            padding: 10px 20px;
            border: none;
            border-radius: 50px;
            font-weight: bold;
        }
        .btn-add {
            background: #fff;
            color: #ff6b81;
            border: 2px solid #ff6b81;
            text-decoration: none;
        }
        .btn-buy {
            background: #ff6b81;
            color: white;
            margin-left: 10px;
            text-decoration: none;
        }
        .btn-add:hover, .btn-buy:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>
<?php include 'nav.php'; ?>
<div class="container product-container">
    <div class="row align-items-center">
        <div class="col-md-5 text-center">
            <img src="gambar/<?= htmlspecialchars($produk['images']); ?>" alt="<?= htmlspecialchars($produk['nama']); ?>" class="product-image">
        </div>

        
        <div class="col-md-7">
            <h3 class="mb-2"><?= htmlspecialchars($produk['nama']); ?></h3>
            <p class="text-muted">Glowgenic</p>
            <?php if (!empty($produk['discount_price']) && $produk['discount_price'] > 0): ?>
                <p class="price">
                    <del style="color:gray; font-size:18px;">IDR <?= number_format($produk['price_awal'], 0, ',', '.'); ?></del><br>
                    IDR <?= number_format($harga_setelah_diskon, 0, ',', '.'); ?>
                    <span style="display:block; color:gray; font-size:16px;">Diskon: <?= number_format($produk['discount_price'], 0, ',', '.'); ?>%</span>
                </p>
            <?php else: ?>
                <p class="price">IDR <?= number_format($produk['price_awal'], 0, ',', '.'); ?></p>
            <?php endif; ?>

            <div class="my-3 d-flex align-items-center">
                <label class="me-3">Quantity:</label>
                <form method="post" class="d-flex align-items-center">
                    <button type="submit" name="kurang" class="btn btn-outline-secondary">-</button>
                    <input type="text" name="angka_display" class="form-control text-center mx-2" value="<?= $angka ?>" readonly style="width:60px;">
                    <button type="submit" name="tambah" class="btn btn-outline-secondary">+</button>
                    <input type="hidden" name="angka" value="<?= $angka ?>">
                </form>
            </div>
                        
            <!-- Container untuk dua tombol -->
            <div class="d-flex gap-2 mt-3">

                <!-- Form Masukkan Keranjang -->
                <form action="shopping_bag.php" method="post" id="formKeranjang">
                    <input type="hidden" name="produk_id" value="<?= $produk['produk_id'] ?>">
                    <input type="hidden" name="jumlah" value="<?= $angka ?>">
                    <input type="hidden" name="nama_produk" value="<?php echo $produk['nama']; ?>">
                    <button type="submit" class="btn btn-add">Masukkan Keranjang</button>
                </form>

                <!-- Form Beli Sekarang -->
                <form action="checkout.php?langsung=1" method="post" id="formBeli">
                    <input type="hidden" name="produk_id" value="<?= $produk['produk_id'] ?>">
                    <input type="hidden" name="jumlah" value="<?= $angka ?>">
                    <button type="submit" name="buy_now" class="btn btn-buy">Buy Now</button>
                </form>

            </div>

            <hr>
            <p><strong>Description:</strong> <?= htmlspecialchars($produk['description']); ?></p>

        </div>
    </div>
            </div>
<?php include 'footer.html'; ?>

<script>

// Form Keranjang
document.getElementById("formKeranjang").addEventListener("submit", function(e) {
    this.querySelector("input[name='jumlah']").value = document.querySelector("input[name='angka']").value;
});

// Form Beli Sekarang
document.getElementById("formBeli").addEventListener("submit", function(e) {
    this.querySelector("input[name='jumlah']").value = document.querySelector("input[name='angka']").value;
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>  
</body>
</html>