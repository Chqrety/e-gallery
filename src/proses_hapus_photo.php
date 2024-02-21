<?php
// Sertakan file koneksi
include('koneksi.php');

// Periksa apakah parameter id album diberikan
if (isset($_GET['id'])) {
    // Ambil AlbumId dari parameter query string
    $photoId = $_GET['id'];

    // Query untuk menghapus album berdasarkan AlbumId
    $queryDeletePhoto = "DELETE FROM foto WHERE FotoId = $photoId";

    // Jalankan query dan periksa keberhasilannya
    if ($koneksi->query($queryDeletePhoto)) {
        // Jika berhasil, alihkan kembali ke halaman album.php
        header("Location: photo.php");
        exit();
    } else {
        // Jika gagal, tampilkan pesan kesalahan
        echo "Error deleting album: " . $koneksi->error;
    }

    // Tutup koneksi ke database
    $koneksi->close();
} else {
    // Jika parameter id tidak diberikan, alihkan kembali ke halaman album.php
    header("Location: photo.php");
    exit();
}
