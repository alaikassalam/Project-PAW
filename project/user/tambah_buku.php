<?php
session_start();
include '../koneksi.php';

// Cek apakah user adalah admin
if (!isset($_SESSION['user_id']) || $_SESSION['status'] != 'admin') {
    header("Location: index.php");
    exit();
}

// Proses penambahan buku
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $status = 'Tersedia';

    // Proses upload file PDF
    $pdf_file = null;
    if (!empty($_FILES['pdf_file']['name'])) {
        $file_name = basename($_FILES['pdf_file']['name']);
        $target_file = "uploads/" . $file_name;
        if (move_uploaded_file($_FILES['pdf_file']['tmp_name'], $target_file)) {
            $pdf_file = $file_name;
        }
    }

    // Simpan data buku ke database
    $query = "INSERT INTO books (title, author, status, pdf_file) VALUES ('$title', '$author', '$status', '$pdf_file')";
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Buku berhasil ditambahkan!'); window.location='daftar_buku.php';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan buku!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Buku</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container my-4">
        <h1>Tambah Buku</h1>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="title" class="form-label">Judul Buku</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="mb-3">
                <label for="author" class="form-label">Penulis</label>
                <input type="text" class="form-control" id="author" name="author" required>
            </div>
            <div class="mb-3">
                <label for="pdf_file" class="form-label">File PDF</label>
                <input type="file" class="form-control" id="pdf_file" name="pdf_file" accept=".pdf">
            </div>
            <button type="submit" class="btn btn-primary">Tambah Buku</button>
        </form>
    </div>
</body>
</html>
