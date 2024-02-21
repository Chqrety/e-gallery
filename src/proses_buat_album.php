<?php
include('koneksi.php');

session_start();

// cek jika form telah terkirim
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // mengambil dan mmebersihkan form data
    $namaAlbum = bersihkanInput($_POST['NamaAlbum']);
    $deskripsi = bersihkanInput($_POST['Deskripsi']);

    // validasi form data
    if (empty($namaAlbum) || empty($deskripsi)) {
        echo "Please fill in all fields.";
    } else {
        // Mengambil id dari user yang login
        $userId = $_SESSION['UserId'];

        // mendapatkan tanggal hari ini
        $todayDate = date("Y-m-d");

        // sql untuk memasukkan data ke dalam database
        $sql = "INSERT INTO album (NamaAlbum, Deskripsi, TanggalDibuat, UserId) VALUES ('$namaAlbum', '$deskripsi', '$todayDate', '$userId')";

        if ($koneksi->query($sql) === TRUE) {
            // Menampilkan mengarahkan ke album.php setelah menampilkan alert 
            echo '<script>alert("Album berhasil dibuat");</script>';
            echo '<script>window.location.href = "album.php";</script>';
            exit(); //memberhantikan eksekusi script
        } else {
            echo "Error: " . $sql . "<br>" . $koneksi->error;
        }
    }
}
