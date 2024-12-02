<?php
include 'navbar_user.php';
include '../koneksi.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

$query = mysqli_query($conn, "SELECT b.title, br.borrow_date, br.return_date 
                              FROM borrowing br 
                              JOIN books b ON br.book_id = b.book_id 
                              WHERE br.user_id = $user_id");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Peminjaman Saya</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container my-4">
        <h2>Daftar Peminjaman Saya</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Judul Buku</th>
                    <th>Tanggal Pinjam</th>
                    <th>Tanggal Kembali (Batas 7 hari)</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($borrow = mysqli_fetch_assoc($query)): ?>
                    <tr>
                        <td><?= $borrow['title'] ?></td>
                        <td><?= $borrow['borrow_date'] ?></td>
                        <td><?= $borrow['return_date'] ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
