<nav class="flex border-b-2 drop-shadow-lg border-ascent justify-between px-8 py-6">
    <div class="flex gap-x-5 items-center font-semibold text-ascent">
        <span class="material-symbols-outlined text-5xl">
            photo_library
        </span>
        <span class="text-2xl">
            E-Gallery
        </span>
    </div>
    <div class="flex items-center gap-x-5 text-xl font-semibold text-ascent">
        <div onclick="window.location.href='index.php'" class="cursor-pointer <?php echo $currentPage === 'dashboard' ? 'text-white bg-ascent' : 'hover:bg-ascent/20'; ?> px-5 py-2 rounded-lg transition-all">Dashboard</div>
        <div onclick="window.location.href='album.php'" class="cursor-pointer <?php echo $currentPage === 'album' ? 'text-white bg-ascent' : 'hover:bg-ascent/20'; ?> px-5 py-2 rounded-lg transition-all">Album</div>
        <div onclick="window.location.href='photo.php'" class="cursor-pointer <?php echo $currentPage === 'photo' ? 'text-white bg-ascent' : 'hover:bg-ascent/20'; ?> px-5 py-2 rounded-lg transition-all">Photo</div>
        <div onclick="window.location.href='proses_logout.php'" class="flex items-center cursor-pointer px-5 py-2 rounded-lg transition-all hover:bg-ascent/20">
            <span class="material-symbols-rounded font-bold text-2xl">
                logout
            </span>
        </div>
    </div>

</nav>