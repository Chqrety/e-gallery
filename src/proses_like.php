<?php
// Memasukkan koneksi kedalam code
include('koneksi.php');

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari formulir
    $fotoId = $_GET['id'];
    $userId = $_SESSION['UserId'];
    $tanggalLike = date("Y-m-d");

    // Query untuk memeriksa apakah pengguna sudah melakukan like sebelumnya
    $checkQuery = "SELECT * FROM likefoto WHERE FotoId = '$fotoId' AND UserId = '$userId'";
    $result = mysqli_query($koneksi, $checkQuery);

    if (mysqli_num_rows($result) > 0) {
        // Pengguna sudah melakukan like, maka lakukan unlike
        $unlikeQuery = "DELETE FROM likefoto WHERE FotoId = '$fotoId' AND UserId = '$userId'";
        if (mysqli_query($koneksi, $unlikeQuery)) {
            echo "Unlike berhasil.";
        } else {
            echo "Error: " . $unlikeQuery . "<br>" . mysqli_error($koneksi);
        }
    } else {
        // Pengguna belum melakukan like, maka lakukan like
        $insertQuery = "INSERT INTO likefoto (FotoId, UserId, TanggalLike) VALUES ('$fotoId', '$userId', '$tanggalLike')";
        if (mysqli_query($koneksi, $insertQuery)) {
            echo "Like berhasil ditambahkan.";
        } else {
            echo "Error: " . $insertQuery . "<br>" . mysqli_error($koneksi);
        }
    }
}

// Redirect kembali ke halaman foto yang sedang dilihat
header("Location: " . $_SERVER['HTTP_REFERER']);
exit();

// Tutup koneksi database
mysqli_close($koneksi);
