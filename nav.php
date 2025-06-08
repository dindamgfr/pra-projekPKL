<?php
include 'koneksi.php';
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Navbar</title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;700&family=Raleway:wght@300;400;500;700&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css"/>
<style>
  nav {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 60px;
    background-color: #f9f0ff;
    border-bottom-left-radius: 50px;
    border-bottom-right-radius: 50px;
    box-shadow: 0 5px 15px rgba(207, 161, 246, 0.2);
    position: sticky;
    top: 0;
    z-index: 100;
  }

  .logo img {
    height: 60px;
    transition: transform 0.3s;
  }

  .logo img:hover {
    transform: scale(1.1);
  }

  .nav-links {
    list-style: none;
    display: flex;
    align-items: center;
    gap: 40px;
    margin: 0;
    padding: 0;
  }

  .nav-links li {
    position: relative;
  }

  .nav-links a, .dropbtn {
    text-decoration: none;
    color: #6b4d6d;
    font-weight: 500;
    font-size: 18px;
    background: none;
    border: none;
    cursor: pointer;
    transition: color 0.3s ease-in-out;
    position: relative;
  }

  .nav-links a::after, .dropbtn::after {
    content: '';
    position: absolute;
    width: 0;
    height: 2px;
    background: linear-gradient(90deg, #ff8db7, #fbb1ff);
    bottom: -6px;
    left: 0;
    transition: width 0.4s ease-in-out;
    border-radius: 2px;
  }

  .nav-links a:hover, .dropbtn:hover {
    color: #ff4f9d;
  }

  .nav-links a:hover::after, .dropbtn:hover::after {
    width: 100%;
  }

  /* Dropdown */
  .dropdown-content {
    display: none;
    position: absolute;
    background-color: #ffffff;
    min-width: 160px;
    box-shadow: 0 8px 16px rgba(0,0,0,0.1);
    border-radius: 10px;
    padding: 10px 0;
    animation: fadeIn 0.4s ease;
    z-index: 99;
  }

  .dropdown-content a {
    color: #6b4d6d;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
    transition: background-color 0.3s, color 0.3s;
    position: relative;
  }

  .dropdown-content a:hover {
    background-color: #ffe4f0;
    color: #ff4f9d;
  }

  .dropdown-content a::after {
    content: '';
    position: absolute;
    width: 0;
    height: 2px;
    background: linear-gradient(90deg, #ff8db7, #fbb1ff);
    bottom: 8px;
    left: 16px;
    transition: width 0.4s ease-in-out;
    border-radius: 2px;
  }

  .dropdown-content a:hover::after {
    width: 80%;
  }

  .dropdown:hover .dropdown-content {
    display: block;
  }

  .nav-icons {
    display: flex;
    align-items: center;
    gap: 20px;
  }

 .nav-icons .icon {
  font-size: 20px;
  color: #6b4d6d;
  text-decoration: none;
  background: none;
  border: none;
  outline: none;
  box-shadow: none;
  transition: color 0.3s ease, transform 0.2s;
}

  .nav-icons .icon:hover,
  .nav-icons .icon:focus {
    color: #ff4f9d;
    transform: scale(1.1);
    background: none;
    border: none;
    outline: none;
    box-shadow: none;
  }

  .login-btn {
    background: linear-gradient(90deg, #ff8db7, #fbb1ff);
    color: white;
    padding: 10px 20px;
    border-radius: 20px;
    text-decoration: none;
    font-weight: bold;
    transition: 0.3s ease;
  }

  .login-btn:hover {
    background: linear-gradient(90deg, #fbb1ff, #ff8db7);
    transform: scale(1.05);
  }

  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
  }

  @media (max-width: 768px) {
    nav {
      flex-direction: column;
      padding: 15px;
    }
    .nav-links {
      flex-direction: column;
      gap: 15px;
      margin-top: 10px;
    }
    .nav-icons {
      margin-top: 10px;
    }
  }

  .badge {
    font-size: 12px;
    padding: 5px 8px;
  }

  .user-btn {
    background: linear-gradient(90deg, #ff8db7, #fcb4ca);
    color: white;
    padding: 6px 16px;
    border-radius: 20px;
    font-weight: 500;
    border: none;
    cursor: pointer;
    font-size: 15px;
    transition: background 0.3s ease, transform 0.2s;
  }

  .user-btn:hover {
    background: linear-gradient(90deg, #fcb4ca, #ffe4f0);
    transform: scale(1.05);
  }
</style>
</head>
<body>
  <nav>
    <div class="logo">
      <img src="gambar/logo.png" alt="Glowgenic Logo" />
    </div>

    <ul class="nav-links">
      <li><a href="index.php">Home</a></li>
      <li><a href="about.php" class="active">About Us</a></li>
      <li class="dropdown">
        <span class="dropbtn">Produk <i class="bi bi-caret-down-fill"></i></span>
        <ul class="dropdown-content">
          <a href="skincare.php">Skincare</a>
          <a href="makeup.php">Makeup</a>
          <a href="diskon.php">Diskon</a>
        </ul> 
      </li>
      <li><a href="bestseller.php">Beauty Tips</a></li>
    </ul>

    <div class="nav-icons">
      <?php
        $cartCount = 0;
        if (isset($_SESSION['users_id'])) {
          $uid = $_SESSION['users_id'];
          $cartQuery = mysqli_query($koneksi, "SELECT SUM(jumlah_produk) AS total FROM keranjang WHERE users_id = $uid");
          $row = mysqli_fetch_assoc($cartQuery);
          $cartCount = $row['total'] ?? 0;
        }
      ?>
      <a href="shopping_bag.php" class="icon position-relative">
        <i class="fas fa-shopping-bag"></i>
        <?php if ($cartCount > 0): ?>
          <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
            <?= $cartCount ?>
          </span>
        <?php endif; ?>
      </a>
     

         <?php if (isset($_SESSION['users_id'])): ?>
  <div class="dropdown">
    <button class="dropbtn user-btn">
      Hai, <?= $_SESSION['username'] ?> <i class="bi bi-caret-down-fill"></i>
    </button>
    <ul class="dropdown-content">
      <!-- <a href="profile.php">Profil Saya</a> -->
      <a href="my_orders.php">Pesanan Saya</a>
      <a href="logout.php">Logout</a>
    </ul>
  </div>
<?php else: ?>
  <a href="login.php" class="login-btn">Login</a>
<?php endif; ?>

    </div>
  </nav>
</body>
</html>
