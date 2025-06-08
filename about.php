<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>About Us - Glowgenic</title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=Roboto&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <style>
    body {
      font-family: 'Roboto', sans-serif;
      background-color: #ffffff;
      color: #333;
    }

    .banner {
      width: 100%;
      height: 500px;
      overflow: hidden;
      margin-top: 50px;
    }

    .banner img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .about-section {
      padding: 80px 20px;
      text-align: center;
    }

    .about-section h1 {
      font-family: 'Playfair Display', serif;
      font-size: 42px;
      color: #d45c96;
      margin-bottom: 20px;
    }

    .about-section p {
      max-width: 800px;
      margin: 0 auto;
      font-size: 18px;
      line-height: 1.8;
      color: #555;
    }

    .info-box {
      background-color: #ffe9f1;
      border-radius: 16px;
      padding: 30px;
      box-shadow: 0 8px 16px rgba(212, 92, 150, 0.1);
      transition: transform 0.3s ease;
      height: 100%;
    }

    .info-box:hover {
      transform: translateY(-5px);
    }

    .info-box h3 {
      font-family: 'Playfair Display', serif;
      color: #d45c96;
      font-size: 22px;
      margin-bottom: 15px;
    }

    .info-box p {
      font-size: 16px;
      color: #444;
    }

    .section-title {
      font-family: 'Playfair Display', serif;
      color: #d45c96;
      font-size: 36px;
      margin-bottom: 30px;
    }

    .certification-logos img {
      height: 50px;
      margin: 0 15px;
      transition: 0.3s;
    }

    .contact-section {
      background-color: #ffffff;
      padding: 80px 20px;
    }

    .contact-title {
      font-family: 'Playfair Display', serif;
      font-size: 32px;
      color: #d45c96;
      text-align: center;
      margin-bottom: 40px;
    }

    .contact-item {
      background-color: #fafafa;
      border: 1px solid #eee;
      border-radius: 12px;
      padding: 30px;
      height: 100%;
      box-shadow: 0 4px 8px rgba(0,0,0,0.04);
      transition: 0.3s ease;
    }

    .contact-item:hover {
      transform: translateY(-5px);
    }

    .contact-item h4 {
      font-size: 20px;
      color: #d45c96;
      font-family: 'Playfair Display', serif;
      margin-bottom: 10px;
    }

    .contact-item p {
      margin: 0;
      font-size: 16px;
      color: #555;
    }
  </style>
</head>
<body>
  <?php include 'nav.php'; ?>

  <!-- Banner -->
  <div class="banner">
    <img src="gambar/About Us (2).png" alt="About Us Banner">
  </div>

  <!-- Our Story -->
  <section class="about-section">
    <h1>Our Story</h1>
    <p>
      Glowgenic hadir sebagai bentuk kepedulian terhadap kulit sehat dan kecantikan alami perempuan Indonesia.
      Berawal dari komunitas kecil pecinta skincare, kini Glowgenic telah berkembang menjadi brand pilihan para beauty enthusiast.
    </p>
    <br>
    <p>
      Kami percaya bahwa kecantikan adalah hak semua orang. Oleh karena itu, kami menghadirkan produk yang aman, ramah kulit, dan tentunya terjangkau.
    </p>
  </section>

  <!-- Info Boxes -->
  <div class="container pb-5">
    <div class="row g-4 justify-content-center">
      <div class="col-md-4">
        <div class="info-box">
          <h3>Our Mission</h3>
          <p>Memberikan produk kecantikan berkualitas tinggi dengan harga terjangkau untuk setiap individu yang ingin tampil percaya diri dan sehat.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="info-box">
          <h3>Our Vision</h3>
          <p>Menjadi merek kecantikan terpercaya yang menginspirasi dan memberdayakan generasi masa kini untuk mencintai diri sendiri.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="info-box">
          <h3>Our Values</h3>
          <p>Kualitas, kepercayaan, keberagaman, dan keberlanjutan adalah nilai yang kami pegang dalam setiap produk yang kami hadirkan.</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Trust Statement -->
  <div class="container py-5">
    <h2 class="text-center section-title">Trusted by Hundreds</h2>
    <p class="text-center" style="max-width:700px;margin:0 auto;color:#555;">
      Dengan lebih dari <strong>500+ pelanggan puas</strong> di seluruh Indonesia, Glowgenic terus menjaga kualitas produk dan kepuasan pelanggan.
    </p>
  </div>

  <!-- Certifications -->
  <div class="text-center my-5">
    <p style="color:#555;">Produk kami telah terdaftar dan bersertifikat:</p>
    <div class="certification-logos">
      <img src="gambar/halal.png" alt="Halal">
      <img src="gambar/bpom.png" alt="BPOM">
      <img src="gambar/cruelty.png" alt="Cruelty-Free">
    </div>
  </div>

  <!-- Contact Info -->
  <section class="contact-section">
    <div class="container">
      <h2 class="contact-title">Contact & Information</h2>
      <div class="row g-4">
        <div class="col-md-4">
          <div class="contact-item">
            <h4>Jam Operasional</h4>
            <p>Senin - Jumat: 09.00 - 17.00 WIB</p>
            <p>Sabtu: 10.00 - 15.00 WIB</p>
            <p>Minggu & Hari Libur: Tutup</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="contact-item">
            <h4>Alamat Kami</h4>
            <p>Jln Selabaya, Kalimanah, Purbalingga</p>
          
            <p>Jawa Tengah, Indonesia</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="contact-item">
            <h4>Hubungi Kami</h4>
            <p>Email: glowgenic@gmail.com</p>
            <p>WhatsApp: +62 895-0601-9709</p>
            <p>Instagram: <a href="https://instagram.com/glowgenic" target="_blank">@glowgenic.official</a></p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <?php include 'footer.html'; ?>
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>