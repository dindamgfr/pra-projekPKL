<?php
include "../koneksi.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tambah Produk</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Inter', sans-serif;
    }
    html, body {
      height: auto;
      min-height: 100vh;
      margin: 0;
      padding: 0;
    }
    body {
      display: flex;
      background-color: #f5f6fa;
      padding: 10px;
    }
    .sidebar {
      width: 250px;
      background: linear-gradient(145deg, #d0d9ff, #e2ccff);
      color: #333;
      padding: 30px 20px;
      margin: 20px 0 0 20px;
      border-radius: 16px;
      box-shadow: 4px 4px 12px rgba(0, 0, 0, 0.1);
      height: 130vh;
      top: 0;
      left: 0;
    } 
    .sidebar .menu-title {
      font-size: 13px;
      font-weight: 600;
      color: #6c63ff;
      margin: 20px 0 10px 5px;
    }
    .sidebar .nav-link {
      padding: 12px 14px;
      margin-bottom: 10px;
      border-radius: 12px;
      background-color: #fff;
      color: #6c63ff;
      text-decoration: none;
      font-weight: 500;
      display: flex;
      align-items: center;
      gap: 12px;
      transition: all 0.3s ease;
      border: 1px solid #e0e0e0;
    }
    .sidebar .nav-link:hover {
      background-color: #e9e5ff;
      color: #5b50d3;
    }
    .dropdown-toggle {
      cursor: pointer;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .submenu {
      margin-left: 30px;
      margin-top: 10px;
    }
    .submenu a {
      font-size: 14px;
      display: block;
      margin: 6px 0;
      text-decoration: none;
      color: #6c63ff;
    }
    .submenu a:hover {
      text-decoration: underline;
    }
    .hidden {
      display: none;
    }
  </style>
</head>
<body>
  <div class="sidebar">
    
    <a href="index.php" class="nav-link"><i class="bi bi-grid"></i> Dashboard</a>

    <div class="menu-title">Data Master</div>
    <a href="dataproduk.php" class="nav-link"><i class="bi bi-box"></i> Produk</a>

    <a href="kategori.php" class="nav-link"><i class="bi bi-tags"></i> Kategori </a>

    <!-- <div class="nav-link dropdown-toggle" onclick="toggleDropdown()">
      <div><i class="bi bi-tags"></i> Kategori</div>
    </div> -->
    <!-- <div id="submenu" class="submenu hidden">
      <a href="list.php" class="nav-link">List</a>
      <a href="makeup.php" class="nav-link">Makeup</a>
      <a href="skincare.php" class="nav-link">Skincare</a>

    </div> -->

    <div class="menu-title">Kelola Pesanan</div>
    
    <a href="pesanan_masuk.php" class="nav-link"><i class="bi bi-inbox"></i> Pesanan Masuk</a>
    <a href="pesanan_dikemas.php" class="nav-link"><i class="bi bi-box-seam"></i> Di Kemas</a>
    <a href="dikirim.php" class="nav-link"><i class="bi bi-truck"></i> Pesanan Di Kirim</a>
    <a href="selesai.php" class="nav-link"><i class="bi bi-check-circle"></i> Pesanan Selesai</a>
    <a href="logout.php" class="nav-link"><i class="bi bi-check-circle"></i> Logo</a>
  </div>

  <script>
    function toggleDropdown() {
      const submenu = document.getElementById('submenu');
      submenu.classList.toggle('hidden');
    }
  </script>
</body>
</html> 