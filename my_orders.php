<?php
session_start();
include 'koneksi.php';

// Cek jika user belum login
if (!isset($_SESSION['users_id'])) {
    echo "<script>alert('Silakan login terlebih dahulu'); window.location.href = 'login.php';</script>";
    exit;
}

$user_id = intval($_SESSION['users_id']);
$status_filter = isset($_GET['status']) ? $_GET['status'] : 'all';

// Query pesanan berdasarkan user dan status
$where_clause = "WHERE p.users_id = $user_id";
if ($status_filter !== 'all') {
    $status_safe = mysqli_real_escape_string($koneksi, $status_filter);
    $where_clause .= " AND p.status = '$status_safe'";
}

$pemesanan_query = mysqli_query($koneksi, "
    SELECT 
        p.pemesanan_id, 
        p.status, 
        p.tanggal_pemesanan, 
        p.harga_total, 
        p.alamat,
        p.no_hp,
        p.nama_penerima,
        bayar.metode_pembayaran 
    FROM pemesanan p
    LEFT JOIN pembayaran bayar ON p.pembayaran_id = bayar.pembayaran_id
    $where_clause
    ORDER BY p.tanggal_pemesanan DESC
");


if (isset($_SESSION['pemesanan_sudah_dibuat'])) {
    $pemesanan_id = $_SESSION['pemesanan_sudah_dibuat'];

    // Tampilkan pesan sukses atau detail pesanan terakhir
    echo "Pesanan berhasil dibuat dengan ID: " . $pemesanan_id;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Orders | Glowgenic</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #fff9fc;
      font-family: 'Segoe UI', sans-serif;
    }
    .header-title {
      font-family: 'Playfair Display', serif;
      font-weight: 600;
      text-align: center;
      font-size: 38px;
      color: #6b4c57;
      margin: 50px 0 30px;
    }
    .order-card {
      background: linear-gradient(to bottom right, #ffffff, #ffe6f0);
      border-radius: 24px;
      box-shadow: 0 10px 30px rgba(255, 182, 193, 0.3);
      padding: 30px;
      margin-bottom: 60px;
    }
    .order-header {
      border-bottom: 2px dashed #ffc9dc;
      padding-bottom: 18px;
      margin-bottom: 25px;
    }
    .label {
      font-size: 13px;
      color: #a58691;
    }
    .sub-total {
      font-size: 22px;
      font-weight: bold;
      color: #4d2c34;
    }
    .status-badge {
      background-color: #ffe0f0;
      color: #cc4f87;
      padding: 6px 14px;
      border-radius: 30px;
      font-size: 13px;
      font-weight: 500;
    }
    .item-row {
      display: flex;
      justify-content: space-between;
      gap: 30px;
      flex-wrap: wrap;
      margin-top: 30px;
    }
    .left-column {
      display: flex;
      gap: 25px;
      align-items: flex-start;
      flex: 1;
      min-width: 250px;
    }
    .item-img img {
      width: 250px;
      height: auto;
    }
    .samping-gambar {
      margin-top: 30px;
      font-family: 'Playfair Display', serif;
    }
    .product-name {
      font-weight: 700;
      color: #4a2c34;
      font-size: 20px;
    }
    .product-desc {
      font-size: 16px;
      color: #776066;
    }
    .product-jumlah_produk {
      color: #6e4c54;
      font-weight: 600;
      margin-top: 90px;
    }
    .right-column {
      flex: 1;
      min-width: 250px;
    }
    .section-title {
      font-weight: 600;
      color: #6b4c57;
      margin-bottom: 6px;
    }
    .info-box p {
      margin: 0;
      font-size: 18px;
      color: #5f4950;
    }
    .info-box {
      margin-bottom: 20px;
    }
    .status-nav a {
      margin-right: 15px;
      color: #6b4c57;
      font-weight: 500;
      text-decoration: none;
    }
    .status-nav a.active {
      text-decoration: underline;
    }
  </style>
</head>
<body>

<?php include 'nav.php'; ?>

<div class="container">
  <h1 class="header-title">My Orders</h1>

  <div class="text-center status-nav mb-4">
    <a href="?status=all" class="<?= $status_filter === 'all' ? 'active' : '' ?>">Semua</a>
    <a href="?status=pending" class="<?= $status_filter === 'pending' ? 'active' : '' ?>">Pending</a>
    <a href="?status=processing" class="<?= $status_filter === 'processing' ? 'active' : '' ?>">Diproses</a>
    <a href="?status=shipped" class="<?= $status_filter === 'shipped' ? 'active' : '' ?>">Dikirim</a>
    <a href="?status=completed" class="<?= $status_filter === 'completed' ? 'active' : '' ?>">Selesai</a>
    <a href="?status=cancelled" class="<?= $status_filter === 'cancelled' ? 'active' : '' ?>">Dibatalkan</a>
  </div>

  <?php if (mysqli_num_rows($pemesanan_query) === 0): ?>
    <p class="text-center">Belum ada pesanan pada kategori ini.</p>
  <?php else: ?>
    <?php
     while ($pesanan = mysqli_fetch_assoc($pemesanan_query)): 
      $pemesanan_id = $pesanan['pemesanan_id'];
      $produk_query = mysqli_query($koneksi, "SELECT dp.jumlah, pr.nama, pr.description, pr.images, pr.discount_price 
        FROM detail_pemesanan dp 
        JOIN produk pr ON dp.produk_id = pr.produk_id 
        WHERE dp.pemesanan_id = $pemesanan_id ");

      $produk_data = [];
      while ($produk = mysqli_fetch_assoc($produk_query)) {
          $produk_data[] = [
              'nama' => $produk['nama'],
              'desc' => $produk['description'],
              'gambar' => $produk['images'],
              'qty' => $produk['jumlah'],
          ];
      }
    ?>
    <div class="order-card">
      <div class="order-header d-flex justify-content-between flex-wrap">
        <div class="fw-bold" style="color: #a85e74;">Order at GLOWGENIC</div>
        <div class="d-flex align-items-center gap-4 flex-wrap">
          <div style="color: #7f6470;"><?= count($produk_data) ?> item purchased</div>
          <div class="d-flex align-items-center gap-2">
            <span class="label">Order Status</span>
            <span class="status-badge">● <?= ucfirst($pesanan['status']) ?></span>
          </div>
          <div class="text-end">
            <span class="label">Total Price</span><br>
            <span class="sub-total">Rp<?= number_format($pesanan['harga_total'], 0, ',', '.') ?></span>
          </div>
        </div>
      </div>

      <?php foreach ($produk_data as $p): ?>
        <div class="item-row">
          <div class="left-column">
            <div class="item-img">
              <img src="gambar/<?= htmlspecialchars($p['gambar']) ?>" alt="product-img">
            </div>
            <div class="samping-gambar">
              <div class="product-name"><?= htmlspecialchars($p['nama']) ?></div>
              <div class="product-desc"><?= htmlspecialchars($p['desc']) ?></div>
              <div class="product-jumlah_produk"><?= $p['qty'] ?> pcs</div>
            </div>
          </div>


          <div class="right-column">
            <div class="section-title">Subtotal</div>
            <div class="info-box">
              <p>Rp <?= number_format($pesanan['harga_total'], 0, ',', '.') ?></p>
            </div>
            <div class="section-title">Data Pesanan</div>
            <div class="info-box">
              <p>Nama : <?= htmlspecialchars($pesanan['nama_penerima']) ?></p>
              <p>Nomor HP : <?= htmlspecialchars($pesanan['no_hp']) ?></p>
              <p>Alamat : <?= htmlspecialchars($pesanan['alamat']) ?></p>
              <p>Tanggal Pemesanan : <?= date('Y-m-d', strtotime($pesanan['tanggal_pemesanan'])) ?></p>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
    <?php endwhile; ?>
  <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
