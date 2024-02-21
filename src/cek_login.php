<?php
// Mulai atau resume sesi
session_start();

// Pengecekan apakah sesi UserId sudah diatur
if (!isset($_SESSION['UserId'])) {
    // Jika tidak diatur, redirect ke halaman login
    header("Location: login.php");
    exit();
}
