<?php
include('cek_login.php');
include('koneksi.php');

if (isset($_GET['id'])) {
    $photoId = $_GET['id'];
    $userIdAktif = $_SESSION['UserId'];

    // Query untuk mengambil data foto dari database berdasarkan ID
    $queryPhoto = "SELECT foto.*, user.UserId, user.Username, album.NamaAlbum, COUNT(DISTINCT likefoto.LikeId) AS JumlahLike, COUNT(DISTINCT komentarfoto.KomentarId) AS JumlahKomentar
                FROM foto
                INNER JOIN user ON foto.UserId = user.UserId
                INNER JOIN album ON foto.AlbumId = album.AlbumId
                LEFT JOIN likefoto ON foto.FotoId = likefoto.FotoId
                LEFT JOIN komentarfoto ON foto.FotoId = komentarfoto.FotoId
                WHERE foto.FotoId = $photoId
                GROUP BY foto.FotoId";
    $resultPhoto = $koneksi->query($queryPhoto);

    // Cek apakah query foto berhasil dijalankan
    if ($resultPhoto) {
        $rowPhoto = $resultPhoto->fetch_assoc();
        $userId = $rowPhoto['UserId'];
        $username = $rowPhoto['Username'];
        $namaAlbum = $rowPhoto['NamaAlbum'];
        $photoId = $rowPhoto['FotoId'];
        $judulPhoto = $rowPhoto['JudulFoto'];
        $deskripsiPhoto = $rowPhoto['DeskripsiFoto'];
        $lokasiPhoto = $rowPhoto['LokasiFile'];
        $jumlahLike = $rowPhoto['JumlahLike'];
        $jumlahKomentar = $rowPhoto['JumlahKomentar'];
        // ...

        // Rilis hasil query foto
        $resultPhoto->free();
    } else {
        echo "Error: " . $queryPhoto . "<br>" . $koneksi->error;
    }

    // mengambil data komentar
    $queryKomentar = "SELECT user.Username, komentarfoto.IsiKomentar, COUNT(DISTINCT komentarfoto.KomentarId) AS JumlahKomentar
                FROM komentarfoto
                LEFT JOIN user ON komentarfoto.UserId = user.UserId
                WHERE komentarfoto.FotoId = $photoId
                GROUP BY komentarfoto.KomentarId";
    $resultKomentar = $koneksi->query($queryKomentar);

    // menmeriksa apakah user yang login sudah like
    $checkLikeQuery = "SELECT * FROM likefoto WHERE FotoId = $photoId AND UserId = $userId";
    $resultCheckLike = mysqli_query($koneksi, $checkLikeQuery);
    $userAlreadyLiked = mysqli_num_rows($resultCheckLike) > 0;
    mysqli_free_result($resultCheckLike);
} else {
    echo "Foto tidak ditemukan";
}

$action = $userIdAktif === $userId ? 'flex' : 'hidden';

// Tutup koneksi ke database
$koneksi->close();
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
        include('navbar.php');
        ?>
    </header>
    <section class="mx-14 my-5">

        <div class="flex h-[85vh]">
            <div class="basis-1/2 px-10">
                <div class="flex flex-col justify-center items-center w-full h-full">
                    <div class=" w-[45vh] relative">
                        <div class="flex flex-col items-center justify-center gap-4 text-secondary/70 w-full h-full">
                            <img src="<?= $lokasiPhoto ?>" alt="post" class="h-full object-cover object-center">
                        </div>
                    </div>
                    <div>
                        <div class="<?php echo $action ?> gap-2 mt-2">
                            <a href="edit_photo.php?id=<?= $photoId ?>" class="flex items-center text-yellow-500 gap-1 border border-yellow-500/50 rounded px-2 py-1 transition-all hover:bg-yellow-500 hover:text-white hover:scale-110">
                                <span class="material-symbols-outlined">edit</span>
                                <span class="font-semibold text-sm">Edit</span>
                            </a>
                            <a href="proses_hapus_photo.php?id=<?= $photoId ?>" class="flex items-center text-red-500 gap-1 border border-red-500/50 rounded px-2 py-1 transition-all hover:bg-red-500 hover:text-white hover:scale-110">
                                <span class="material-symbols-outlined">delete</span>
                                <span class="font-semibold text-sm">Delete</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex flex-col basis-1/2">
                <div class="flex flex-col">
                    <span class="text-3xl font-semibold mb-5"><?= $judulPhoto ?></span>
                    <span class="font font-semibold text-secondary/50">Upload By <?= $username ?> | <?= $namaAlbum ?> </span>
                    <span>"<?= $deskripsiPhoto ?>"</span>
                </div>
                <div class="flex flex-col w-full h-full overflow-y-scroll border-y border-secondary/50 py-2 gap-y-3">
                    <?php
                    if ($resultKomentar) {
                        // Loop untuk menampilkan setiap baris komentar dalam HTML
                        foreach ($resultKomentar as $rowKomentar) {
                            $usernameKomentar = $rowKomentar['Username'];
                            $isiKomentar = $rowKomentar['IsiKomentar'];
                    ?>
                            <div class="flex flex-col bg-secondary/10 rounded w-fit px-2 py-2">
                                <span class="font-semibold"><?= $usernameKomentar ?></span>
                                <span class="text-sm text-justify"><?= $isiKomentar ?></span>
                            </div>
                    <?php
                        }

                        // Bebaskan hasil query setelah digunakan
                        mysqli_free_result($resultKomentar);
                    } else {
                        // Tampilkan pesan kesalahan jika query tidak berhasil
                        echo "Error: " . $queryKomentar . "<br>" . mysqli_error($koneksi);
                    }
                    ?>
                </div>
                <span></span>
                <div class="border-b border-x border-secondary/30 rounded-b-lg w-full">
                    <div class="flex items-center gap-x-3 text-sm p-2 w-full">
                        <div class="flex items-center gap-1">
                            <form method="post" action="proses_like.php?id=<?= $photoId ?>">
                                <button type="submit" class="flex items-center">
                                    <span class="<?php echo $userAlreadyLiked ? 'material-symbols-outlined text-red-500' : 'material-symbols-rounded'; ?>">favorite</span>
                                </button>
                            </form>
                            <span class="font-semibold"><?= $jumlahLike ?></span>
                        </div>
                        <div class="flex items-center gap-1">
                            <span class="material-symbols-rounded">chat_bubble</span>
                            <span class="font-semibold"><?= $jumlahKomentar ?></span>
                        </div>
                        <form method="post" action="proses_komen.php?id=<?= $photoId ?>" class="w-full">
                            <div class="flex items-center gap-1">
                                <div class="w-full">
                                    <input type="text" name="IsiKomentar" placeholder="masukkan komentar" class="border border-secondary/50 rounded-lg w-full p-2 focus:outline-none">
                                </div>
                                <button type="submit" class="flex items-center">
                                    <span class="material-symbols-rounded">send</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </section>
</body>

</html>