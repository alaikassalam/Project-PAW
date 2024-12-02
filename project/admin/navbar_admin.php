<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<?php
include '../koneksi.php';

// Redirect ke login jika belum login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$user_status = $_SESSION['status'];
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">PustakaNow</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
            <?php if ($user_status == 'admin'): ?>
                <!-- Menu untuk Admin -->
                <li class="nav-item">
                    <a class="nav-link" href="admin_dashboard.php">Dashboard Admin</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="manage_users.php">Kelola Pengguna</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="reports.php">Laporan</a>
                </li>
                <li class="nav-item"><a class="nav-link" href="../logout.php">Logout</a></li>
            <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
