<?php include "sidebar.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Tambah Produk</title>
  <style>
    body {
    margin: 0;
    padding: 0;
    font-family: 'Inter', sans-serif;
    display: flex;
    }
    .main-content {
      flex: 1;
      padding: 40px;
      box-sizing: border-box;
    }

    h2 {
      text-align: center;
      color: #9b59b6;
      margin-bottom: 30px;
      font-size: 2.2rem;
      font-weight: bold;
    }

    .form-container {
      background: #fff;
      padding: 40px;
      border-radius: 16px;
      max-width: 850px;
      width: 100%;
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 24px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.06);
      border: 1px solid #e0dff6;
      margin: 0 auto;
    }
    select {
      width: 100%;
      padding: 12px 14px;
      border-radius: 10px;
      border: 1.5px solid #d6d8f0;
      background-color: #f4f6ff;
      font-size: 1rem;
      color: #333;
      transition: border-color 0.3s;
      outline: none;
    }

    select:focus {
      border-color: #a78bfa;
      background-color: #fff;
    }

    label {
      font-weight: 600;
      color: #5e548e;
      margin-bottom: 8px;
      display: block;
    }

    input, textarea {
      width: 100%;
      padding: 12px 14px;
      border-radius: 10px;
      border: 1.5px solid #d6d8f0;
      outline: none;
      background-color: #f4f6ff;
      font-size: 1rem;
      color: #333;
      transition: border-color 0.3s;
    }

    input:focus, textarea:focus {
      border-color: #a78bfa;
      background-color: #fff;
    }

    textarea {
      resize: vertical;
    }

    .full {
      grid-column: 1 / -1;
    }

    .btn {
      background-color: #a78bfa;
      color: #fff;
      border: none;
      padding: 14px;
      font-size: 16px;
      font-weight: 600;
      border-radius: 10px;
      cursor: pointer;
      transition: background-color 0.3s ease;
      grid-column: 1 / -1;
      margin-top: 10px;
    }

    .btn:hover {
      background-color: #8b5cf6;
    }

    @media (max-width: 768px) {
      body {
        flex-direction: column;
      }

      .main-content {
        padding: 20px;
      }

      .form-container {
        grid-template-columns: 1fr;
        padding: 30px 20px;
      }

      h2 {
        font-size: 1.6rem;
      }

      .btn {
        padding: 12px;
      }
    }
  </style>
</head>
<body>
  <div class="main-content">
    <h2>Tambah Produk</h2>
    <form action="proses_tambah.php" method="post" enctype="multipart/form-data" class="form-container">
      <div>
        <label>Nama Produk</label>
        <input type="text" name="nama" required>
      </div>
      <div>
        <label>Kategori Produk</label>
        <select name="kategori_id" required>
            <option value="">-- Pilih Kategori --</option>
            <option value="1">Skincare</option>
            <option value="2">Makeup</option>
        </select>
        </div>
      <div>
        <label>Harga Produk</label>
        <input type="number" name="price_awal" required>
      </div>
      <div>
        <label>Diskon Produk</label>
        <input type="number" name="discount_price" required>
      </div>
      <div>
        <label>Stok Produk</label>
        <input type="number" name="stok" required>
      </div>
      <div>
        <label>Foto Produk</label>
        <input type="file" name="images" accept="image/*" required>
      </div>
      <div class="full">
        <label>Deskripsi</label>
        <textarea name="description" rows="4" required></textarea>
      </div>
      <input type="hidden" name="admin_id" value="1">
      <button type="submit" name="simpan" class="btn">Tambah Produk</button>
    </form>
  </div>
</body>
</html>