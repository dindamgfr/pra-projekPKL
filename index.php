<!DOCTYPE html>
<html lang="en">
<head>
  <style>
    .nav-icons a:focus,
    .nav-icons a:active,
    .nav-icons a:hover {
        outline: none !important;
        box-shadow: none !important;
        background-color: transparent !important;
    }

    .nav-icons .icon:focus-visible {
        outline: none !important;
    }

    .ungu {
        background-color: #f3e8ff;
        padding-left: 40px;
        padding-bottom: 30px;
        max-width: 800px;
        margin: 40px auto;
        border-radius: 20px;
        text-align: center;
    }

    .ungu h1 {
        font-size: 2.5rem;
        font-family: 'Playfair Display', serif;
        margin-bottom: 10px;
    }

    .ungu h5 {
        font-size: 1.5rem;
        font-weight: 500;
        color: #7a2b9d;
        margin-bottom: 10px;
    }

    .ungu p {
        font-size: 1rem;
        max-width: 600px;
        margin: 0 auto 30px;
        color: #333;
    }

    .ungu .btn {
        background-color: #f8bbd0;
        color: white;
        padding: 10px 25px;
        border: none;
        border-radius: 25px;
        font-weight: 500;
        font-family: 'Raleway', sans-serif;
        transition: 0.3s ease;
        text-decoration: none;
    }

    .ungu .btn:hover {
        background-color: #e0b3ff ;
        color: #fff;
    }
  </style>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GLOWGENIC</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;700&family=Raleway:wght@300;400;500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <?php include 'nav.php'; ?>

  <div class="container">
    <div class="ungu">
      <h1>Cosmetic that</h1>
      <h5>Everyone loves!</h5>
      <p>Where beauty meets quality. We offer a curated selection of
        Skincare, Make Up, and beauty products to help you look and 
        feel your best.</p><br>
      <a href="#glow-section" class="btn">Explore Product</a>
    </div>

    <div class="images">
      <!-- <img src="gambar/tube.png" alt="Product" class="product-img"> -->
      <img src="gambar/model.png" alt="Model" class="model-img">  
    </div>
  </div>

  <div id="glow-section" class="glow-section">
    <h2>Ingin mempunyai kulit sehat dan glowing ?</h2>
    <div class="content-box">
      <div class="gambar-kiri">
        <img src="gambar/pink-box1.png" alt="Produk 1">
        <img src="gambar/pink-box2.png" alt="Produk 2">
      </div>
      <div class="teks-kanan">
        <p>
          Temukan rangkaian skincare dan makeup terbaik kami, dari cleanser hingga serum,  
          serta foundation, eyeshadow dan lipstik yang ramah dikulit.  
          Setiap produk dirancang untuk hasil maksimal, memberikan kulit cerah, bercahaya  
          dan siap tampil maksimal setiap hari.
        </p>
      </div>
    </div>
  </div>

  <section class="layanan">
    <div class="layanan-header">
      <span class="layanan-badge">Layanan Kami</span>
      <p>Menyediakan produk Skincare dan Makeup yang berkualitas</p>
    </div>
    <div class="layanan-container">
      <div>
        <img src="gambar/layanan1.png" alt="Produk Skincare 1" />
      </div>
      <div>
        <img src="gambar/layanan2.png" alt="Produk Skincare 2" />
      </div>
      <div>
        <img src="gambar/layanan3.png" alt="Produk Skincare 3" />
      </div>
    </div>
  </section>

  <div id="footer-placeholder"></div>

  <script src="script.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
<script>
  function myFunction() {
    document.getElementById("myDropdown").classList.toggle("show");
  }

  window.onclick = function(event) {
    if (!event.target.matches('.dropbtn')) {
      var dropdowns = document.getElementsByClassName("dropdown-content");
      for (var i = 0; i < dropdowns.length; i++) {
        var openDropdown = dropdowns[i];
        if (openDropdown.classList.contains('show')) {
          openDropdown.classList.remove('show');
        }
      }
    }
  }
</script>
</html>