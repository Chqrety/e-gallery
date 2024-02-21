<?php
// Informasi koneksi ke database
$host = "localhost"; // nama host
$user = "root"; // nama pengguna myqsql
$pass = "";  // kosong karena tidak ada password
$dbname = "e_gallery"; // nama database

// Buat koneksi ke database
$koneksi = new mysqli($host, $user, $pass, $dbname);

// Periksa koneksi
if ($koneksi->connect_error) {
    die("Koneksi ke database gagal: " . $koneksi->connect_error);
}

// Fungsi untuk membersihkan dan melindungi input
function bersihkanInput($data)
{
    global $koneksi;
    return htmlspecialchars(mysqli_real_escape_string($koneksi, $data));
}
