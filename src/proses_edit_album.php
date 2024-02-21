<?php
// Sertakan file koneksi
include('koneksi.php');

// Periksa apakah data dari formulir telah dikirim
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari formulir
    $albumId = $_POST["AlbumId"]; // Anda perlu menambahkan input hidden di form untuk menyimpan AlbumId
    $namaAlbum = $_POST["NamaAlbum"];
    $deskripsi = $_POST["Deskripsi"];

    // Query untuk memperbarui data album
    $queryUpdateAlbum = "UPDATE album SET NamaAlbum = '$namaAlbum', Deskripsi = '$deskripsi' WHERE AlbumId = $albumId";

    // Jalankan query dan periksa keberhasilannya
    if ($koneksi->query($queryUpdateAlbum)) {
        // Jika berhasil, alihkan kembali ke halaman album.php
        echo '<script>alert("Album berhasil diedit");</script>';
        echo '<script>window.location.href = "album.php";</script>';
        exit(); //memberhantikan eksekusi script
    } else {
        // Jika gagal, tampilkan pesan kesalahan
        echo "Error updating album: " . $koneksi->error;
    }

    // Tutup koneksi ke database
    $koneksi->close();
} else {
    // Jika tidak, alihkan kembali ke halaman album.php
    header("Location: album.php");
    exit();
}
