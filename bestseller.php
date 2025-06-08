<?php include 'koneksi.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Beauty Tips</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
  <style>
    body {
      background-color: #fff9f9;
      font-family: 'Poppins', sans-serif;
    }

    .section-title {
      font-family: 'Playfair Display', serif;
      font-size: 2.8rem;
      font-weight: 600;
      color: #d75a8b;
      text-align: center;
      margin-bottom: 50px;
    }

    .card {
      border: none;
      border-radius: 20px;
      overflow: hidden;
      transition: all 0.3s ease-in-out;
    }

    .card:hover {
      transform: scale(1.015);
      box-shadow: 0 12px 30px rgba(215, 90, 139, 0.1);
    }

    .card-title {
      font-size: 1.25rem;
      font-weight: 600;
      color: #d75a8b;
      font-family: 'Playfair Display', serif;
    }

    .card-text {
      color: #555;
      font-size: 0.95rem;
    }

    @media (max-width: 768px) {
      .section-title {
        font-size: 2rem;
      }
    }
  </style>
</head>
<body>
  <?php include 'nav.php'; ?>

  <section class="beauty-section container py-5">
    <h2 class="section-title">Beauty Tips of the Week</h2>

    <div class="row g-4">

      <!-- Video 1 -->
      <div class="col-md-6">
        <div class="card shadow-sm">
          <div class="ratio ratio-16x9">
            <iframe src="https://www.youtube.com/embed/9joYArfZQD8" title="Tips Wajah Glowing" allowfullscreen></iframe>
          </div>
          <div class="card-body">
            <h5 class="card-title">Tips Wajah Glowing Alami</h5>
            <p class="card-text">Pelajari cara mudah mendapatkan kulit glowing secara alami tanpa harus ke klinik.</p>
          </div>
        </div>
      </div>

      <!-- Video 2 -->
      <div class="col-md-6">
        <div class="card shadow-sm">
          <div class="ratio ratio-16x9">
            <iframe src="https://www.youtube.com/embed/gD58mmpl4iU" title="Makeup Natural" allowfullscreen></iframe>
          </div>
          <div class="card-body">
            <h5 class="card-title">Makeup Natural Sehari-hari</h5>
            <p class="card-text">Tutorial makeup natural untuk remaja dan pemula agar tampil fresh setiap hari.</p>
          </div>
        </div>
      </div>

      <!-- Video 3 -->
      <div class="col-md-6">
        <div class="card shadow-sm">
          <div class="ratio ratio-16x9">
            <iframe src="https://www.youtube.com/embed/R8kAyTsXg3w" title="Perawatan Kulit Remaja" allowfullscreen></iframe>
          </div>
          <div class="card-body">
            <h5 class="card-title">Skincare untuk Remaja</h5>
            <p class="card-text">Rangkaian perawatan wajah khusus remaja yang mudah diikuti dan ramah di kantong.</p>
          </div>
        </div>
      </div>

      <!-- Video 4 -->
      <div class="col-md-6">
        <div class="card shadow-sm">
          <div class="ratio ratio-16x9">
            <iframe src="https://www.youtube.com/embed/2DNx-sOncyU" title="Cleansing Routine" allowfullscreen></iframe>
          </div>
          <div class="card-body">
            <h5 class="card-title">Rutinitas Cleansing yang Benar</h5>
            <p class="card-text">Langkah-langkah membersihkan wajah secara maksimal untuk hasil yang lebih bersih dan sehat.</p>
          </div>
        </div>
      </div>

    </div>
  </section>

  <?php include 'footer.html'; ?>
</body>
</html>