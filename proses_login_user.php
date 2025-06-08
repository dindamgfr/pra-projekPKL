<?php
session_start();
include "koneksi.php";

// Tangkap data dari form login
$username = mysqli_real_escape_string($koneksi, $_POST['username']);
$password = mysqli_real_escape_string($koneksi, $_POST['password']);

// Cek ke database, apakah username dan password cocok
$sql = "SELECT * FROM users WHERE username = '$username' AND password = MD5('$password')";
$query = mysqli_query($koneksi, $sql);

// Jika ditemukan, login berhasil
if (mysqli_num_rows($query) == 1) {
    $user = mysqli_fetch_assoc($query);
    $_SESSION['username'] = $user['username'];  
    $_SESSION['users_id'] = $user['users_id'];  // ✅ INI DILETAKKAN DI SINI SAJA
    header("Location: index.php?login=sukses");
    exit;
} else {
    header("Location: login.php?login=gagal");
    exit;
}
?>
