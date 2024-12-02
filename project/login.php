<?php
session_start();
include 'koneksi.php'; // Pastikan koneksi.php sudah benar

// Cek apakah sudah login, arahkan sesuai status
if (isset($_SESSION['user_id'])) {
    if (isset($_SESSION['status']) && $_SESSION['status'] == 'admin') {
        header("Location: ../admin_dashboard.php");
        exit(); // Menghentikan eksekusi setelah redirect
    }
    header("Location: index.php"); // Arahkan ke halaman utama jika sudah login
    exit();
}

// Proses login jika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Validasi input
    if (empty($username) || empty($password)) {
        $error = "Username dan Password harus diisi!";
    } else {
        // Gunakan prepared statement untuk mencegah SQL Injection
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user) {
            // Verifikasi password
            if (password_verify($password, $user['password'])) {
                // Simpan data session
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['status'] = $user['status']; // Bisa 'admin' atau 'user'

                // Arahkan berdasarkan status
                if ($_SESSION['status'] == 'admin') {
                    header("Location: admin/admin_dashboard.php");
                    exit();
                } else {
                    header("Location: user/index.php"); // Arahkan ke halaman utama untuk user biasa
                    exit();
                }

            } else {
                $error = "Password salah!";
            }
        } else {
            $error = "Username tidak ditemukan!";
        }

        $stmt->close(); // Tutup statement setelah selesai
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container my-4">
        <h2>Login</h2>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
        <p>Belum punya akun? <a href="registrasi.php">Daftar</a></p>
    </div>
</body>
</html>
