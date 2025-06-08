<?php
session_start();
include 'koneksi.php'; 

$username = htmlspecialchars($_POST['username']);
$email    = htmlspecialchars($_POST['email']);
$password = md5($_POST['password']); 


$cek = mysqli_query($koneksi, "SELECT * FROM users WHERE email = '$email' OR username = '$username'");
if (mysqli_num_rows($cek) > 0) {
    echo "<script>
            alert('Username atau Email sudah terdaftar!');
            window.location.href='register.php';
          </script>";
    exit;
}

$query = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
if (mysqli_query($koneksi, $query)) {
    echo "<script>
            alert('Registrasi berhasil! Silakan login.');
            window.location.href='login.php';
          </script>";
} else {
    echo "<script>
            alert('Terjadi kesalahan saat mendaftar.');
            window.location.href='register.php';
          </script>";
}
?>
