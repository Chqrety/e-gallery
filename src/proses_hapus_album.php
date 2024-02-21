<?php
// Sertakan file koneksi
include('koneksi.php');

// Periksa apakah parameter id album diberikan
if (isset($_GET['id'])) {
    // Ambil AlbumId dari parameter query string
    $albumId = $_GET['id'];

    // Query untuk menghapus album berdasarkan AlbumId
    $queryDeleteAlbum = "DELETE FROM album WHERE AlbumId = $albumId";

    // Jalankan query dan periksa keberhasilannya
    if ($koneksi->query($queryDeleteAlbum)) {
        // Menampilkan mengarahkan ke album.php setelah menampilkan alert 
        echo '<script>alert("Album berhasil dihapus");</script>';
        echo '<script>window.location.href = "album.php";</script>';
        exit(); //memberhantikan eksekusi script
    } else {
        // Jika gagal, tampilkan pesan kesalahan
        echo "Error deleting album: " . $koneksi->error;
    }

    // Tutup koneksi ke database
    $koneksi->close();
} else {
    // Jika parameter id tidak diberikan, alihkan kembali ke halaman sebelumnya
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
}
