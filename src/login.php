<?php
// Mulai atau resume sesi
session_start();

// Pengecekan apakah sesi UserId sudah diatur
if (isset($_SESSION['UserId'])) {
    // Jika tidak diatur, redirect ke halaman login
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Gallery | Login</title>

    <!-- link font poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <!-- link material -->
    <!-- no fill -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@40,400,0,0" />

    <!-- fill -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@40,400,1,0" />

    <!-- css -->
    <link rel="stylesheet" href="style.css">

</head>

<body>

    <section class="flex h-screen">
        <!-- form untuk melakukan proses login -->
        <form method="POST" action="proses_login.php" class="basis-1/2">
            <div class="flex flex-col px-24 py-10">
                <div class="flex items-center gap-5 text-ascent mb-20">
                    <span class="material-symbols-rounded text-7xl">
                        photo_library
                    </span>
                    <span class="text-4xl font-bold">Gallery</span>
                </div>
                <div class="flex flex-col mb-20">
                    <span class="font-semibold text-3xl text-primary">Selamat Datang Kembali!</span>
                    <span class="text-secondary/70">Silahkan login ke dalam akun anda</span>
                </div>
                <div class="flex flex-col gap-14 max-w-xl">
                    <div class="flex flex-col gap-3">
                        <div class="flex flex-col">
                            <label for="username/email" class="font-semibold pb-1">Username/Email</label>
                            <input type="text" name="UsernameOrEmail" placeholder="masukkan username atau password" class="border border-secondary/70 w-full px-2 py-2 rounded-lg">
                        </div>
                        <div class="flex flex-col">
                            <label for="password" class="font-semibold pb-1">Password</label>
                            <input type="password" name="Password" placeholder="masukkan password" class="border border-secondary/70 w-full px-2 py-2 rounded-lg">
                        </div>
                    </div>
                    <div class="flex flex-col gap-5">
                        <button type="submit" class="font-semibold bg-ascent text-white py-2 rounded-lg transition-all hover:scale-105">Login</button>
                        <div class="w-full">
                            <div class="border-b-2 border-secondary/30 w-full relative">
                                <span class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 px-5 bg-white text-secondary/80">atau</span>
                            </div>
                        </div>
                        <!-- button untuk pindah kehalaman register -->
                        <button type="button" onclick="window.location.href='register.php'" class="border border-ascent py-2 rounded-lg font-semibold text-ascent transition-all hover:scale-105 hover:bg-ascent hover:text-white">Register</button>
                    </div>
                </div>
            </div>
        </form>
        <div class="basis-1/2 overflow-hidden">
            <img src="/img/day.jpg" alt="day" class="w-full h-full object-cover object-center rounded-bl-[50%] select-none pointer-events-none">
        </div>
    </section>

</body>

</html>