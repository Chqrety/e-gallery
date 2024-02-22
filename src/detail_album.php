<?php
include('cek_login.php');
include('koneksi.php');

if (isset($_GET['id'])) {
    $albumId = $_GET['id'];
    $userIdAktif = $_SESSION['UserId'];


    // Query untuk mengambil data album dari database berdasarkan ID
    $queryAlbum = "SELECT album.*, album.UserId, user.Username
    FROM album
    INNER JOIN user ON album.UserId = user.UserId
    WHERE album.AlbumId = $albumId";
    $resultAlbum = $koneksi->query($queryAlbum);

    // Cek apakah query album berhasil dijalankan
    if ($resultAlbum) {
        $rowAlbum = $resultAlbum->fetch_assoc();
        $userId = $rowAlbum['UserId'];
        $username = $rowAlbum['Username'];
        $namaAlbum = $rowAlbum['NamaAlbum'];
        $deskripsi = $rowAlbum['Deskripsi'];

        // Rilis hasil query album
        $resultAlbum->free();
    }
}

// query untuk mengambil data foto  dari database berdasarkan album
$queryPhoto = "SELECT foto.FotoId, foto.LokasiFile, album.NamaAlbum, user.UserId, user.Username, COUNT(likefoto.LikeId) AS JumlahLike, COUNT(komentarfoto.KomentarId) AS JumlahKomentar
FROM foto
INNER JOIN user ON foto.UserId = user.UserId
INNER JOIN album ON foto.AlbumId = album.AlbumId
LEFT JOIN likefoto ON foto.FotoId = likefoto.FotoId
LEFT JOIN komentarfoto ON foto.FotoId = komentarfoto.FotoId
WHERE album.AlbumId = $albumId
GROUP BY foto.FotoId";

$resultPhoto = $koneksi->query($queryPhoto);

$action = $userIdAktif === $userId ? 'flex' : 'hidden';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E - Gallery | Album</title>

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
        $currentPage = 'album';
        include('navbar.php');
        ?>
    </header>
    <section class="px-14 py-5">
        <div class="mb-8 flex flex-col w-full items-center">
            <span class="text-3xl font-semibold"><?= $namaAlbum ?></span>
            <span class="text-secondary/50">By <?= $username ?></span>
            <span class="">"<?= $deskripsi ?>"</span>
            <div class="<?php echo $action ?> gap-2 mt-5">
                <a href="edit_album.php?id=<?= $albumId ?>" class="flex items-center text-yellow-500 gap-1 border border-yellow-500/50 rounded px-2 py-1 transition-all hover:bg-yellow-500 hover:text-white hover:scale-110">
                    <span class="material-symbols-outlined">edit</span>
                    <span class="font-semibold text-sm">Edit</span>
                </a>
                <a href="proses_hapus_album.php?id=<?= $albumId ?>" class="flex items-center text-red-500 gap-1 border border-red-500/50 rounded px-2 py-1 transition-all hover:bg-red-500 hover:text-white hover:scale-110">
                    <span class="material-symbols-outlined">delete</span>
                    <span class="font-semibold text-sm">Delete</span>
                </a>
            </div>
        </div>
        <div class="columns-5 gap-5">
            <!-- perulangan untuk foto darin DB -->
            <?php foreach ($resultPhoto as $row) :

                $photoId = $row['FotoId'];
                $userIdAktif = $row['UserId'];

                // menmeriksa apakah user yang login sudah like
                $checkLikeQuery = "SELECT * FROM likefoto WHERE FotoId = $photoId AND UserId = $userIdAktif";
                $resultCheckLike = mysqli_query($koneksi, $checkLikeQuery);
                $userAlreadyLiked = mysqli_num_rows($resultCheckLike) > 0;
                mysqli_free_result($resultCheckLike);

            ?>
                <div class="break-inside-avoid flex flex-col items-center w-full mb-5 transition-all hover:scale-105 hover:rounded-lg hover:shadow-xl">
                    <div class="w-full p-2 flex justify-between border-t border-x border-secondary/30 rounded-t-lg">
                        <span class="font-bold"><?= $row['Username'] ?></span>
                        <span class="italic"><?= $row['NamaAlbum'] ?></span>
                    </div>
                    <div class="overflow-hidden">
                        <!-- button untuk pindah halaman ke detail foto -->
                        <img onclick="window.location.href='detail_photo.php?id=<?= $row['FotoId'] ?>'" src="<?= $row['LokasiFile'] ?>" alt="random unsplash image" class="w-full h-full object-cover object-center cursor-pointer">
                    </div>
                    <div class="border-b border-x border-secondary/30 rounded-b-lg w-full">
                        <div class="flex gap-x-3 text-sm p-2">
                            <div class="flex items-center">
                                <form method="post" action="proses_like.php?id=<?= $photoId ?>">
                                    <button type="submit" class="flex items-center">
                                        <span class="<?php echo $userAlreadyLiked ? 'material-symbols-outlined text-red-500' : 'material-symbols-rounded'; ?>">favorite</span>
                                    </button>
                                </form>
                                <span class="font-semibold"><?= $row['JumlahLike'] ?></span>
                            </div>
                            <div class="flex items-center">
                                <span class="material-symbols-rounded">chat_bubble</span>
                                <span class="font-semibold"><?= $row['JumlahKomentar'] ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

    </section>
</body>

</html>