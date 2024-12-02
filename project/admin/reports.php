<?php
session_start();

// Cek apakah pengguna sudah login dan memiliki status admin
if (!isset($_SESSION['user_id']) || $_SESSION['status'] !== 'admin') {
    header("Location: login.php");
    exit();
}

include '../koneksi.php';

// Ambil data laporan dari database (misalnya, laporan buku yang dipinjam)
$query = "SELECT b.title, COUNT(bp.user_id) AS total_peminjaman 
          FROM books b 
          LEFT JOIN borrowing bp ON b.book_id = bp.book_id 
          GROUP BY b.title";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Peminjaman</title>
    <!-- Link ke CSS Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'navbar_admin.php'; ?>
    <div class="container mt-4">
        <h1>Laporan Peminjaman Buku</h1>
        
        <!-- Tabel Laporan Peminjaman -->
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Judul Buku</th>
                    <th>Total Peminjaman</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= $row['title']; ?></td>
                    <td><?= $row['total_peminjaman']; ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Link ke Bootstrap JS dan Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
