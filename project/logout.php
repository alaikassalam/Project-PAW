<?php
// Hapus session dan logout
session_start();
session_unset();
session_destroy();

// Arahkan ke halaman login
header("Location: login.php");
exit();
