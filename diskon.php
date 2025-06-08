<?php
include 'koneksi.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Diskon Products</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
  <style>
  body {
    background-color: #fff0f5;
    font-family: 'Segoe UI', sans-serif;
  }

  .container {
    max-width: 1300px;
  }

  .product-card {
    position: relative;
    border-radius: 15px;
    overflow: hidden;
    background: white;
    transition: transform 0.4s ease, box-shadow 0.4s ease;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
    margin-bottom: 30px;
    width: 100%;
    max-width: 360px;
    margin-left: auto;
    margin-right: auto;
  }

  .product-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
  }

  .product-image-container {
    background: #ffffff;
    padding: 25px;
    height: 250px;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .product-image {
    max-height: 200px;
    width: auto;
    transition: transform 0.3s ease-in-out;
  }

  .product-card:hover .product-image {
    transform: scale(1.05) rotate(1deg);
  }

  .product-info {
    background: #ffc0cb;
    padding: 20px;
    text-align: center;
    border-bottom-left-radius: 15px;
    border-bottom-right-radius: 15px;
  }

  .product-title {
    font-size: 17px;
    font-weight: bold;
    color: white;
    margin-bottom: 5px;
  }

  .price {
    color: white;
    font-size: 15px;
    font-weight: bold;
    margin-bottom: 12px;
  }

  .buy-now {
    background: white;
    color: #ff6b81;
    border: 2px solid #ff6b81;
    padding: 8px 18px;
    border-radius: 25px;
    font-size: 13px;
    font-weight: bold;
    transition: all 0.3s ease-in-out;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
  }

  .buy-now:hover {
    background: #ff6b81;
    color: white;
    transform: scale(1.05);
  }

  .discount-badge {
    position: absolute;
    top: 10px;
    left: 10px;
    background: #ff6b81;
    color: white;
    padding: 6px 14px;
    font-size: 13px;
    font-weight: bold;
    border-radius: 25px;
    box-shadow: 0 4px 10px rgba(255, 107, 129, 0.4);
    animation: pop 0.4s ease;
  }

  @keyframes pop {
    0% {
      transform: scale(0.7);
      opacity: 0;
    }
    100% {
      transform: scale(1);
      opacity: 1;
    }
  }
  </style>
</head>
<body>
  <?php include 'nav.php'; ?>
<div class="container text-center mt-5">
  <img src="gambar/cloud.png" class="img-fluid" alt="Banner">
</div>

<div class="container mt-5">
  <div class="row justify-content-center">

<?php
$query = "SELECT * FROM produk WHERE discount_price IS NOT NULL AND discount_price < price_awal";
$result = mysqli_query($koneksi, $query);

while ($row = mysqli_fetch_assoc($result)) {
    $produk_id = $row['produk_id'];
    $nama = $row['nama'];
    $image = $row['images'];
    $price_awal = $row['price_awal'];
    $discount_price = $row['discount_price'];
    $persen_diskon = round((($price_awal - $discount_price) / $price_awal) * 100);
?>

<div class="col-lg-4 col-md-6 mb-4">
  <div class="product-card">
    <div class="discount-badge"><?= $persen_diskon ?>%</div>
    <div class="product-image-container">
      <img src="gambar/<?= $image ?>" class="product-image" alt="<?= $nama ?>">
    </div>
    <div class="product-info">
      <h5 class="product-title"><?= $nama ?></h5>
      <p class="price">
        <del>IDR <?= number_format($price_awal, 0, ',', '.') ?></del><br>
        IDR <?= number_format($discount_price, 0, ',', '.') ?>
      </p>
      <a href="detail_produk.php?id=<?= $produk_id ?>" class="buy-now"><i class="bi bi-bag-fill"></i> Lihat Detail</a>
    </div>
  </div>
</div>

<?php } ?>

  </div>
</div>

<div id="footer-placeholder"></div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>