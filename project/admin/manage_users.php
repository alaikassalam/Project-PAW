<?php
session_start();

// Cek apakah pengguna sudah login dan memiliki status admin
if (!isset($_SESSION['user_id']) || $_SESSION['status'] !== 'admin') {
    header("Location: login.php");
    exit();
}

include '../koneksi.php';

// Ambil data pengguna dari database
$query = "SELECT * FROM users";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pengguna</title>
    <!-- Link ke CSS Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'navbar_admin.php'; ?>

    <div class="container mt-4">
        <h1 class="text-center">Kelola Pengguna</h1>

        <div class="card">
            <div class="card-header">
                <h5>Daftar Pengguna</h5>
            </div>
            <div class="card-body">
                <!-- Tabel Daftar Pengguna -->
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ID Pengguna</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= $row['user_id']; ?></td>
                            <td><?= $row['username']; ?></td>
                            <td><?= $row['email']; ?></td>
                            <td><?= $row['status']; ?></td>
                            <td>
                                <a href="/admin/edit_user.php?id=<?= $row['user_id']; ?>" class="btn btn-warning btn-sm">Edit</a> 
                                <a href="/admin/delete_user.php?id=<?= $row['user_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')">Hapus</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- Script Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
