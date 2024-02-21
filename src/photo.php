<?php
// cek login
include('cek_login.php');

// view photo
include('koneksi.php');

$userId = $_SESSION['UserId'];

// Ambil data semua foto dari database
$queryPhoto = "SELECT user.Username, foto.*, album.NamaAlbum, COUNT(DISTINCT likefoto.LikeId) AS JumlahLike, COUNT(DISTINCT komentarfoto.KomentarId) AS JumlahKomentar
FROM foto
INNER JOIN user ON foto.UserId = user.UserId
INNER JOIN album ON foto.AlbumId = album.AlbumId
LEFT JOIN likefoto ON foto.FotoId = likefoto.FotoId
LEFT JOIN komentarfoto ON foto.FotoId = komentarfoto.FotoId
WHERE foto.UserId = $userId
GROUP BY foto.FotoId";

$resultPhoto = $koneksi->query($queryPhoto);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E - Gallery | Photo</title>

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
        $currentPage = 'photo';
        include('navbar.php');
        ?>
    </header>

    <section class="px-14 mt-5 flex items-center w-full">
        <div class="flex justify-center w-full">
            <div onclick="window.location.href='upload_photo.php'" class="border-2 border-secondary/50 border-dashed rounded-lg cursor-pointer py-1 w-full max-w-lg">
                <div class="flex flex-col items-center justify-center gap-4 text-secondary/70">
                    <span class="material-symbols-rounded text-7xl">
                        add_circle
                    </span>
                    <span class="font-semibold">Add Photo</span>
                </div>
            </div>
        </div>
    </section>

    <section class="columns-5 px-14 py-5 gap-5">
        <?php foreach ($resultPhoto as $row) :

            $photoId = $row['FotoId'];

            // menmeriksa apakah user yang login sudah like
            $checkLikeQuery = "SELECT * FROM likefoto WHERE FotoId = $photoId AND UserId = $userId";
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

        <?php
        // Bebaskan hasil query
        $resultPhoto->free();

        // Tutup koneksi
        $koneksi->close();
        ?>

    </section>

</body>

</html>