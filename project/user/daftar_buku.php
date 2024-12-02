<?php
include 'navbar_user.php';
include '../koneksi.php';

// if (!isset($_SESSION['user_id'])) {
//     header("Location: login.php");
//     exit();
// }

$user_id = $_SESSION['user_id']; // Ambil user ID dari session

// Proses pencarian judul buku
$search_keyword = "";
if (isset($_GET['search'])) {
    $search_keyword = $_GET['search'];
    $query = $conn->prepare("SELECT * FROM books WHERE title LIKE ?");
    $search_term = "%" . $search_keyword . "%";
    $query->bind_param("s", $search_term);
    $query->execute();
    $result = $query->get_result();
} else {
    $query = mysqli_query($conn, "SELECT * FROM books");
}

function sudahMeminjam($conn, $user_id, $book_id) {
    $check_query = mysqli_query($conn, "SELECT * FROM borrowing WHERE user_id = $user_id AND book_id = $book_id AND return_date IS NULL");
    return mysqli_num_rows($check_query) > 0;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Buku</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container my-4">
        <h2>Daftar Buku</h2>

        <!-- Form Pencarian -->
        <form method="GET" action="daftar_buku.php" class="mb-3">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Cari judul buku..." value="<?= htmlspecialchars($search_keyword) ?>">
                <button type="submit" class="btn btn-primary">Cari</button>
            </div>
        </form>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Judul Buku</th>
                    <th>Pengarang</th>
                    <th>Status</th>
                    <th>Stok</th>
                    <th>PDF</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (isset($result) ? $result->num_rows > 0 : mysqli_num_rows($query) > 0): ?>
                    <?php while ($book = isset($result) ? $result->fetch_assoc() : mysqli_fetch_assoc($query)): ?>
                        <tr>
                            <td><?= htmlspecialchars($book['title']) ?></td>
                            <td><?= htmlspecialchars($book['author']) ?></td>
                            <td><?= htmlspecialchars($book['status']) ?></td>
                            <td><?= $book['stok'] ?></td>
                            <td>
                                <?php if (!empty($book['pdf_file'])): ?>
                                    <a href="uploads/<?= htmlspecialchars($book['pdf_file']) ?>" target="_blank" class="btn btn-link">Unduh PDF</a>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Tidak Tersedia</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($book['stok'] > 0 && !sudahMeminjam($conn, $user_id, $book['book_id'])): ?>
                                    <a href="pinjam_buku.php?book_id=<?= $book['book_id'] ?>" class="btn btn-primary">Pinjam</a>
                                <?php elseif (sudahMeminjam($conn, $user_id, $book['book_id'])): ?>
                                    <span class="badge bg-warning">Sudah Dipinjam</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Tidak Tersedia</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">Buku tidak ditemukan</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
