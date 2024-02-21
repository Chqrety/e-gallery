<?php
include('koneksi.php');

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari formulir
    $userId = $_SESSION['UserId'];
    $fotoId = $_GET['id'];
    $isiKomentar = bersihkanInput($_POST['IsiKomentar']);
    $tanggalKomentar = date("Y-m-d");

    // Query untuk menyimpan komentar ke dalam tabel komentarfoto
    $insertQuery = "INSERT INTO komentarfoto (FotoId, UserId, IsiKomentar, TanggalKomentar) VALUES ('$fotoId', '$userId', '$isiKomentar', '$tanggalKomentar')";

    if (mysqli_query($koneksi, $insertQuery)) {
        echo "Komentar berhasil ditambahkan.";
    } else {
        echo "Error: " . $insertQuery . "<br>" . mysqli_error($koneksi);
    }
}

// Redirect kembali ke halaman foto yang sedang dilihat
header("Location: detail_photo.php?id=" . $fotoId);
exit();

// Tutup koneksi database
mysqli_close($koneksi);
