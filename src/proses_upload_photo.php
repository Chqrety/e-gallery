<?php
// Pastikan Anda sudah memasukkan informasi koneksi.php di sini
include "koneksi.php";

// Mulai atau resume sesi
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Tangkap data dari formulir upload
    $judulFoto = bersihkanInput($_POST["JudulFoto"]);
    $albumId = bersihkanInput($_POST["AlbumId"]);
    $deskripsiFoto = bersihkanInput($_POST["DeskripsiFoto"]);

    // Tangkap data file
    $lokasiFile = $_FILES["Foto"]["tmp_name"];
    $namaFile = $_FILES["Foto"]["name"];

    // Mendapatkan UserId dari sesi
    $userId = $_SESSION['UserId'];

    // Mendapatkan tanggal unggah (today)
    $tanggalUnggah = date("Y-m-d");

    // Lokasi penyimpanan file
    $lokasiSimpan = '/storage/' . $namaFile;
    $tempatSimpan = __DIR__ . '/storage/' . $namaFile;

    // Periksa apakah file berhasil diunggah
    if (move_uploaded_file($lokasiFile, $tempatSimpan)) {
        // Query untuk menyimpan data foto ke database
        $query = "INSERT INTO foto (JudulFoto, DeskripsiFoto, TanggalUnggah, LokasiFile, AlbumId, UserId) VALUES ('$judulFoto', '$deskripsiFoto', '$tanggalUnggah', '$lokasiSimpan', '$albumId', '$userId')";

        if ($koneksi->query($query) === TRUE) {
            // Redirect ke halaman photo.php atau halaman lain yang sesuai
            echo '<script>alert("Photo berhasil diupload");</script>';
            echo '<script>window.location.href = "photo.php";</script>';
            exit();
        } else {
            // Jika query gagal, tampilkan pesan kesalahan atau redirect ke halaman sebelumnya
            echo '<script>alert("Photo gagal diupload, harap periksa kembali");</script>';
        }
    } else {
        // Jika file tidak berhasil diunggah, tampilkan pesan kesalahan atau redirect ke halaman sebelumnya
        echo "Error uploading file.";
    }
}

// Tutup koneksi (jika menggunakan mysqli)
$koneksi->close();
