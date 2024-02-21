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
        <?php
        $currentPage = 'album';
        include('navbar.php');
        ?>
    </header>
    <?php
    include('koneksi.php');
    // Periksa apakah ID album telah diberikan pada parameter URL
    if (isset($_GET['id'])) {
        $albumId = $_GET['id'];

        // Query untuk mengambil data album dari database berdasarkan ID
        $queryAlbum = "SELECT * FROM album WHERE AlbumId = $albumId";
        $resultAlbum = $koneksi->query($queryAlbum);

        // Cek apakah query album berhasil dijalankan
        if ($resultAlbum) {
            $rowAlbum = $resultAlbum->fetch_assoc();
            $namaAlbum = $rowAlbum['NamaAlbum'];
            $deskripsi = $rowAlbum['Deskripsi'];
            // ...

            // Rilis hasil query album
            $resultAlbum->free();
        } else {
            echo "Error: " . $queryAlbum . "<br>" . $koneksi->error;
        }
    } else {
        echo "Album ID not provided.";
    }

    // Tutup koneksi ke database
    $koneksi->close();
    ?>

    <!-- Sekarang, isi nilai awal input dengan data dari database -->
    <section class="px-56 py-10">
        <div class="mb-20">
            <span class="font-bold text-2xl">Edit Album</span>
        </div>
        <form action="proses_edit_album.php" method="post">
            <input type="text" name="AlbumId" value="<?php echo htmlspecialchars($albumId); ?>" hidden>
            <div class="max-w-xl mb-5">
                <label class="font-semibold">Nama Album</label>
                <input type="text" placeholder="masukkan nama album disini" name="NamaAlbum" class="border-2 border-secondary/50 w-full rounded-lg py-1 px-2" required value="<?php echo htmlspecialchars($namaAlbum); ?>">
            </div>
            <div class="max-w-xl mb-20">
                <label for="deskripsi" class="font-semibold">Deskripsi</label>
                <textarea name="Deskripsi" id="deskripsi" cols="30" rows="10" class="border-2 border-secondary/50 w-full rounded-lg py-1 px-2" required><?php echo htmlspecialchars($deskripsi); ?></textarea>
            </div>

            <div class="flex justify-between">
                <a href="album.php">
                    <button type="button" class="flex items-center bg-red-500 py-2 px-6 text-white rounded gap-2 transition-all hover:scale-105">
                        <span class="material-symbols-rounded align-middle">
                            arrow_back_ios_new
                        </span>
                        <span>Kembali</span>
                    </button>
                </a>
                <button type="submit" class="flex items-center bg-yellow-500 py-2 px-6 text-white rounded gap-2 transition-all hover:scale-105">
                    <span>Update</span>
                    <span class="material-symbols-rounded">
                        Edit
                    </span>
                </button>
            </div>
        </form>
    </section>

</body>

</html>