<!-- cek login -->
<?php
include('cek_login.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E - Gallery</title>

    <!-- link font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <!-- link icon -->
    <!-- no fill -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@40,400,1,0" />

    <!-- fill -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@40,400,0,0" />

    <!-- css -->
    <link rel="stylesheet" href="style.css">

    <!-- import costum css -->
    <link rel="stylesheet" href="costum.css">

</head>

<body>
    <header>
        <!-- menambahkan navbar -->
        <?php
        $currentPage = 'photo';
        include('navbar.php');

        // Pastikan Anda sudah memasukkan informasi koneksi.php di sini
        include "koneksi.php";

        // Query untuk mengambil data album dari database
        $queryAlbum = "SELECT AlbumId, NamaAlbum FROM album";
        $resultAlbum = $koneksi->query($queryAlbum);

        // Tutup koneksi (jika menggunakan mysqli)
        $koneksi->close();
        ?>
    </header>
    <section class="px-56 py-10">
        <div class="mb-20">
            <span class="font-bold text-2xl">Upload Foto</span>
        </div>
        <form method="POST" action="proses_upload_photo.php" enctype="multipart/form-data">
            <div class="flex mb-5">
                <div class="basis-1/2 flex flex-col gap-y-3">
                    <div class="flex flex-col max-w-xl">
                        <label class="font-semibold pb-1">Judul Foto</label>
                        <input type="text" placeholder="masukkan judul foto" name="JudulFoto" class="bg-secondary/10 w-full rounded-lg px-3 py-3" required>
                    </div>
                    <div class="flex flex-col max-w-xl">
                        <label class="font-semibold pb-1">Album</label>
                        <select name="AlbumId" class="bg-secondary/10 w-full rounded-lg px-3 py-3" required>
                            <option selected value="NULL">pilih album</option>
                            <?php
                            // Loop melalui hasil query dan buat opsi untuk setiap entri album
                            while ($row = $resultAlbum->fetch_assoc()) {
                                $albumId = $row['AlbumId'];
                                $namaAlbum = $row['NamaAlbum'];
                                echo "<option value=\"$albumId\">$namaAlbum</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="flex flex-col max-w-xl">
                        <label class="font-semibold pb-1">Deskripsi Foto</label>
                        <textarea placeholder="masukkan deskripsi foto" name="DeskripsiFoto" class="bg-secondary/10 w-full px-3 py-5 rounded-lg" required></textarea>
                    </div>
                </div>
                <div class="basis-1/2">
                    <div class="flex justify-center items-center w-full h-full">
                        <div class="border-2 border-secondary/50 border-dashed rounded-lg cursor-pointer w-full h-96 relative">
                            <div id="previewContainer" class="flex flex-col items-center justify-center gap-4 text-secondary/70 w-full h-full">
                                <span class="material-symbols-rounded text-7xl">
                                    info
                                </span>
                                <span class="font-semibold">Preview Image</span>
                            </div>
                            <label for="fileInput" class="text-xs text-secondary/50">Tekan kotak diatas untuk memasukkan atau mengganti foto</label>
                            <input type="file" id="fileInput" name="Foto" class="absolute top-0 left-0 w-full h-full opacity-0 cursor-pointer" onchange="handleFileSelect()" required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex justify-between">
                <!-- redirect ke photo -->
                <button onclick="window.location.href='photo.php'" type="button" class="flex items-center bg-red-500 py-2 px-6 text-white rounded gap-2 transition-all hover:scale-105">
                    <span class="material-symbols-rounded align-middle">
                        arrow_back_ios_new
                    </span>
                    <span class="font-semibold">Kembali</span>
                </button>
                <button type="submit" class="flex items-center bg-ascent py-2 px-6 text-white rounded gap-2 transition-all hover:scale-105">
                    <span class="font-semibold">Upload</span>
                    <span class="material-symbols-outlined">
                        add_photo_alternate
                    </span>
                </button>
            </div>
        </form>
    </section>

    <script>
        // fitur preview image
        function handleFileSelect() {
            const fileInput = document.getElementById('fileInput');
            const previewContainer = document.getElementById('previewContainer');
            const selectedFile = fileInput.files[0];

            if (selectedFile) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    // Tampilkan gambar sebagai preview
                    previewContainer.innerHTML = `
                    <img src="${e.target.result}" alt="preview" class="h-full rounded-lg">
                `;
                };

                reader.readAsDataURL(selectedFile);
            }
        }
    </script>
</body>

</html>