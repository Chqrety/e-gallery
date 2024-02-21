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
    <section class="grid grid-cols-5 px-14 py-5 place-items-center gap-10">
        <a href="buat_album.php">
            <article class="border-2 border-secondary/50 border-dashed w-72 h-72 rounded-lg">
                <div class="flex flex-col items-center justify-center gap-4 text-secondary/70 h-full">
                    <span class="material-symbols-rounded text-7xl">
                        add_circle
                    </span>
                    <span class="font-semibold">Create Album</span>
                </div>
            </article>
        </a>
        <?php
        include('koneksi.php');

        // Query untuk mengambil data album dari database
        $query = "SELECT album.*, user.Username 
        FROM album 
        INNER JOIN user 
        ON album.UserId = user.UserId";
        $result = $koneksi->query($query);

        // Cek apakah query berhasil dijalankan
        if ($result) {
            // Loop untuk setiap baris hasil query
            while ($row = $result->fetch_assoc()) {
                $albumId = $row['AlbumId'];  // Menambahkan kolom IdAlbum (gantilah sesuai dengan nama kolom yang sesuai)
                $albumName = $row['NamaAlbum'];
                $description = $row['Deskripsi'];
                $userId = $row['UserId'];
                $userName = $row['Username'];
        ?>

                <a href="detail_album.php?id=<?php echo $albumId; ?>">
                    <article class="border border-secondary/50 w-72 h-72 rounded-lg bg-white p-4">
                        <div class="grid grid-cols-1 place-items-center h-full gap-2">
                            <div class="flex flex-col items-center">
                                <span class="font-semibold text-lg"><?php echo $albumName; ?></span>
                                <span class="text-secondary/50">by User: <?php echo $userName; ?></span>
                            </div>
                        </div>
                    </article>
                </a>

        <?php
            }

            // Bebaskan hasil query
            $result->free();
        } else {
            echo "Error: " . $query . "<br>" . $koneksi->error;
        }

        // Tutup koneksi ke database
        $koneksi->close();
        ?>
    </section>
</body>

</html>