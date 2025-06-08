<?php
include 'koneksi.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Ambil produk dengan kategori_id = 2 (Makeup)
$query = "SELECT * FROM produk WHERE kategori_id = 2";
$result = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Makeup Products</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <style>
    .container {
      max-width: 1400px;
      width: 100%;
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
      background: white;
      padding: 20px;
      height: 240px;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .product-image {
      width: 100%;
      height: 200px;
      object-fit: contain;
      transition: transform 0.3s ease;
    }

    .product-card:hover .product-image {
      transform: scale(1.05) rotate(1deg);
    }

    .product-info {
      background: #ffb6c1;
      padding: 15px;
      border-bottom-left-radius: 12px;
      border-bottom-right-radius: 12px;
      display: flex;
      flex-direction: column;
      align-items: center;
      text-align: center;
    }

    .product-title {
      font-size: 16px;
      font-weight: bold;
      color: white;
    }

    .price {
      color: white;
      font-weight: bold;
      font-size: 14px;
      margin-bottom: 10px;
    }

    .button-container {
      display: flex;
      justify-content: center;
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

    .buy-now:active {
      transform: scale(0.95);
    }
  </style>
</head>
<body>

  <?php include 'nav.php'; ?>

  <div class="container text-center mt-5">
    <img src="gambar/cloud.png" class="img-fluid" alt="Banner">
  </div>  

  <div class="container mt-5">
    <div class="row g-3 justify-content-center">
      <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <div class="col-lg-4 col-md-6 mb-4">
          <div class="product-card">
            <div class="product-image-container">
              <img src="gambar/<?php echo $row['images']; ?>" class="product-image" alt="<?php echo htmlspecialchars($row['nama']); ?>">
            </div>
            <div class="product-info">
              <h5 class="product-title"><?php echo htmlspecialchars($row['nama']); ?></h5>
              <p class="price">IDR <?php echo number_format($row['price_awal'], 0, ',', '.'); ?></p>
              <div class="button-container">
                <a href="detail_produk.php?id=<?php echo $row['produk_id']; ?>" class="buy-now"><i class="bi bi-bag-fill"></i> Lihat Detail</a>
              </div>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  </div><br>

  <div id="footer-placeholder"></div>

  <script src="script.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>  
</body>
</html>