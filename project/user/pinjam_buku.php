<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$book_id = $_GET['book_id'];

// Cek stok buku
$book_query = mysqli_query($conn, "SELECT * FROM books WHERE book_id = $book_id");
$book = mysqli_fetch_assoc($book_query);

if ($book['stok'] > 0) {
    // Kurangi stok buku dan tambahkan ke tabel borrowing
    $update_stok = mysqli_query($conn, "UPDATE books SET stok = stok - 1 WHERE book_id = $book_id");
    $insert_borrow = mysqli_query($conn, "INSERT INTO borrowing (user_id, book_id, borrow_date) VALUES ($user_id, $book_id, NOW())");

    if ($update_stok && $insert_borrow) {
        echo "<script>alert('Buku berhasil dipinjam!'); window.location='daftar_buku.php';</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan!'); window.location='daftar_buku.php';</script>";
    }
} else {
    echo "<script>alert('Buku tidak tersedia!'); window.location='daftar_buku.php';</script>";
}
?>
