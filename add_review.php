<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Write Review | Glowgenic</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(to bottom right, #ffeef4, #fff);
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
      padding: 0;
    }

    .container-review {
      max-width: 700px;
      margin: 60px auto;
      background: rgba(255, 255, 255, 0.6);
      backdrop-filter: blur(10px);
      border-radius: 20px;
      padding: 40px 30px;
      box-shadow: 0 8px 24px rgba(255, 107, 129, 0.2);
    }

    .title {
      font-size: 24px;
      font-weight: 700;
      color: #ff6b81;
      margin-bottom: 30px;
      text-align: left;
    }

    .product-card {
      display: flex;
      align-items: center;
      background-color: white;
      border-radius: 16px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.05);
      padding: 15px 20px;
      margin-bottom: 30px;
    }

    .product-card img {
      width: 80px;
      border-radius: 10px;
      margin-right: 20px;
    }

    .stars {
      display: flex;
      justify-content: center;
      font-size: 36px;
      color: #ccc;
      margin-bottom: 30px;
      cursor: pointer;
      transition: all 0.2s;
    }

    .stars span.active {
      color: #ff6b81;
    }

    .btn-publish {
      background: #ffb6c1;
      border: none;
      padding: 12px 30px;
      border-radius: 12px;
      font-weight: bold;
      color: white;
      transition: all 0.3s;
      box-shadow: 0 4px 8px rgba(255,107,129,0.2);
    }

    .btn-publish:hover {
      background: #ff9fb3;
    }

  </style>
</head>
<body>

 <?php include 'nav.php'; ?>
<div class="container-review">
  <div class="title">✍️ Write Review</div>

  <div class="product-card">
    <img src="gambar/serum.png" alt="Emina BB Cream">
    <div>
      <h6 class="mb-0 fw-bold">Emina</h6>
      <small>Daily Matte BB Cream<br>01 Light – 16 gr</small>
    </div>
  </div>

  <form action="submit_review.php" method="POST">
    <input type="hidden" name="product_id" value="1">
    <input type="hidden" name="rating" id="rating" value="0">

    <div class="stars" id="stars">
      <span>★</span>
      <span>★</span>
      <span>★</span>
      <span>★</span>
      <span>★</span>
    </div>

    <div class="text-end">
      <button type="submit" class="btn btn-publish">Publish</button>
    </div>
  </form>
</div>

<script>
  const starElements = document.querySelectorAll('#stars span');
  const ratingInput = document.getElementById('rating');

  starElements.forEach((star, index) => {
    star.addEventListener('click', () => {
      ratingInput.value = index + 1;
      starElements.forEach((s, i) => {
        s.classList.toggle('active', i <= index);
      });
    });
  });
</script>
<div id="footer-placeholder"></div>
<script src="script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
