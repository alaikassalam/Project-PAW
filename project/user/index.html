<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

include 'navbar_user.php';
$conn = mysqli_connect("localhost", "root", "", "projectPAW");

// Validasi koneksi
if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Ambil data pengguna
$user_id = $_SESSION['user_id'];
$user_query = mysqli_query($conn, "SELECT * FROM users WHERE user_id = $user_id");
$user_data = mysqli_fetch_assoc($user_query);

// Ambil statistik pengguna
$total_books_borrowed_query = mysqli_query($conn, "SELECT COUNT(*) AS total FROM borrowing WHERE user_id = $user_id");
$total_books_borrowed = mysqli_fetch_assoc($total_books_borrowed_query)['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PustakaNow</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container my-4">
        <h1>Selamat Datang di PustakaNow</h1>
        <p>Nama: <?= $user_data['username'] ?></p>
        <p>Email: <?= $user_data['email'] ?></p>
        <p>Total Buku yang Dipinjam: <?= $total_books_borrowed ?></p>
    </div>
</body>
</html>
