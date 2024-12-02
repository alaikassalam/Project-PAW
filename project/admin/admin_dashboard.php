<?php
session_start();

// Cek apakah pengguna sudah login dan memiliki status admin
if (!isset($_SESSION['user_id']) || $_SESSION['status'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Ambil data pengguna dan informasi lainnya jika diperlukan
include '../koneksi.php';

// Ambil jumlah pengguna dari database
$query = "SELECT COUNT(*) as total_users FROM users";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);
$total_users = $data['total_users'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <!-- Link ke Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'navbar_admin.php'; ?>

    <div class="container my-4">
        <h1>Dashboard Admin</h1>
        <p>Total Pengguna Terdaftar: <?= $total_users ?></p>
        
        <!-- Link untuk mengelola data -->
        <div class="mt-4">
            <a href="./admin/manage_users.php" class="btn btn-primary">Kelola Pengguna</a>
            <a href="./admin/reports.php" class="btn btn-secondary">Lihat Laporan</a>
        </div>
    </div>

    <!-- Link ke Bootstrap JS dan Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
