<?php
// Sertakan koneksi database atau file konfigurasi lainnya
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari formulir
    $idFoto = mysqli_real_escape_string($koneksi, $_POST['IdFoto']);
    $judulFoto = mysqli_real_escape_string($koneksi, $_POST['JudulFoto']);
    $albumId = mysqli_real_escape_string($koneksi, $_POST['AlbumId']);
    $deskripsiFoto = mysqli_real_escape_string($koneksi, $_POST['DeskripsiFoto']);

    // Update data foto di tabel
    $updateQuery = "UPDATE foto SET JudulFoto='$judulFoto', AlbumId='$albumId', DeskripsiFoto='$deskripsiFoto' WHERE FotoId=$idFoto";

    if (mysqli_query($koneksi, $updateQuery)) {
        echo "Data foto berhasil diupdate.";
        header("Location: photo.php"); // Redirect ke halaman photo setelah proses selesai
        exit();
    } else {
        echo "Error: " . $updateQuery . "<br>" . mysqli_error($koneksi);
    }
}

// Tutup koneksi database
mysqli_close($koneksi);
