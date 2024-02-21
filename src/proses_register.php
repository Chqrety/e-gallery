<?php
// Pastikan Anda sudah memasukkan informasi koneksi.php di sini
include "koneksi.php";

// Tangkap data dari formulir registrasi
$username = bersihkanInput($_POST['Username']);
$email = bersihkanInput($_POST['Email']);
$password = bersihkanInput($_POST['Password']);
$namaLengkap = bersihkanInput($_POST['NamaLengkap']);
$alamat = bersihkanInput($_POST['Alamat']);

// Hash password sebelum menyimpan ke database (gunakan metode keamanan yang lebih aman)
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Query untuk memasukkan data pengguna baru ke dalam tabel users
$query = "INSERT INTO user (Username, Email, Password, NamaLengkap, Alamat) VALUES ('$username', '$email', '$hashedPassword', '$namaLengkap', '$alamat')";

// Eksekusi query
if ($koneksi->query($query) === TRUE) {
    // Registrasi berhasil, lakukan sesuatu (contoh: redirect ke halaman login)
    echo '<script>alert("Berhasil registrasi akun");</script>';
    echo '<script>window.location.href = "login.php";</script>';
    exit();
} else {
    // Registrasi gagal, tampilkan pesan kesalahan atau lakukan sesuatu yang sesuai dengan kebutuhan Anda
    echo "Error: " . $query . "<br>" . $koneksi->error;
}

// Tutup koneksi (jika menggunakan mysqli)
$koneksi->close();
