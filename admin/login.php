<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login - Admin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

  <!-- AOS (Animate On Scroll) -->
  <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

  <!-- Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body {
      background: url('..gambar/blur-login.png') no-repeat center center fixed;
      background-size: cover;
      font-family: 'Poppins', sans-serif;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      margin: 0;
    }

    /* Container for Login and Register */
    .auth-container {
      background: rgba(255, 255, 255, 0.8); 
      border-radius: 25px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
      padding: 50px;
      width: 100%;
      max-width: 400px;
      animation: fadeIn 1s ease-out;
    }

    /* Fade-in animation */
    @keyframes fadeIn {
      0% { opacity: 0; transform: translateY(-20px); }
      100% { opacity: 1; transform: translateY(0); }
    }

    .auth-container h2 {
      color: #d94e84;
      text-align: center;
      font-weight: 600;
      margin-bottom: 30px;
    }

    .form-control {
      border-radius: 12px;
      border: 1px solid #e6e6e6;
      padding-left: 35px;
      transition: all 0.3s ease;
    }

    .form-control:focus {
      border-color: #ff69a0;
      box-shadow: 0 0 0 0.2rem rgba(255, 105, 160, 0.2);
    }

    .form-icon {
      position: absolute;
      left: 12px;
      top: 50%;
      transform: translateY(-50%);
      color: #d94e84;
    }

    .input-group {
      position: relative;
      margin-bottom: 20px;
    }

    .btn-primary {
      background-color: #ff69a0;
      border: none;
      border-radius: 12px;
      font-weight: bold;
      transition: 0.3s ease;
    }

    .btn-primary:hover {
      background-color: #e05589;
    }

    .register-link {
      text-align: center;
      margin-top: 15px;
    }

    .register-link a {
      color: #d94e84;
      text-decoration: none;
    }
  </style>
</head>
<body>

  <div class="auth-container" data-aos="fade-up" data-aos-duration="1000">
    <h2>Welcome Back!</h2>
    <form action="proses_login.php" method="POST">
      <div class="input-group">
        <i class="bi bi-person-fill form-icon"></i>
        <input type="text" class="form-control" name="username" placeholder="Username or Email" required>
      </div>
      <div class="input-group">
        <i class="bi bi-lock-fill form-icon"></i>
        <input type="password" class="form-control" name="password" placeholder="Password" required>
      </div>
      <button type="submit" class="btn btn-primary w-100">Login</button>
    </form>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <!-- AOS JS -->
  <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
  <script>
    AOS.init();
  </script>
</body>
</html>