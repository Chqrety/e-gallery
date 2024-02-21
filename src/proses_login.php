<?php
// Memasukkan koneksi kedalam code
include "koneksi.php";

// Mulai atau resume sesi
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Tangkap data dari formulir login
    $usernameOrEmail = bersihkanInput($_POST["UsernameOrEmail"]);
    $password = bersihkanInput($_POST['Password']);

    // Query untuk mengambil data pengguna berdasarkan username atau email
    $query = "SELECT * FROM user WHERE Username = '$usernameOrEmail' OR Email = '$usernameOrEmail'";
    $result = $koneksi->query($query);

    // Periksa apakah data pengguna ditemukan
    if ($result->num_rows > 0) {
        $user_data = $result->fetch_assoc(); // Ambil data pengguna dari hasil query

        // Bandingkan password yang dimasukkan dengan password di database
        if (password_verify($password, $user_data['Password'])) {
            // Password valid, set session
            $_SESSION['UserId'] = $user_data['UserId'];
            $_SESSION['Username'] = $user_data['Username'];
            $_SESSION['Email'] = $user_data['Email'];

            // Redirect ke halaman index
            echo '<script>alert("Berhasil login");</script>';
            echo '<script>window.location.href = "index.php";</script>';
            // Tambahkan pernyataan debug
            echo "Session 'UserId' set: " . $_SESSION['UserId'];
            exit(); // Pastikan untuk keluar dari script setelah melakukan redirect
        } else {
            // Password tidak valid, tampilkan pesan kesalahan atau redirect ke halaman login kembali
            echo '<script>alert("Password Salah!");</script>';
            echo '<script>window.location.href = "login.php";</script>';
            exit();
        }
    } else {
        // Data pengguna tidak ditemukan, tampilkan pesan kesalahan atau redirect ke halaman login kembali
        echo '<script>alert("Akun tidak ditemukan!");</script>';
        echo '<script>window.location.href = "login.php";</script>';
        exit();
    }
}

// Tutup koneksi (jika menggunakan mysqli)
$koneksi->close();
