<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <div class="container">
        <a class="navbar-brand" href="index.php">Perpustakaan</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="./index.php">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
                        <?php
                        $nama = $_SESSION['nama'];
                        if (!isset($_SESSION['username'])) {
                            echo 'Masuk
                            </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="masuk.php?sebagai=admin">Sebagai Admin</a>
                                <a class="dropdown-item" href="masuk.php?sebagai=mahasiswa">Sebagai Mahasiswa</a>

                                <a class="dropdown-item" href="masuk.php?sebagai=tamu">Sebagai Tamu</a>
                            </div>';
                        } else {
                            echo $nama;
                            echo '</a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="profil.php">Profile</a>
                                <a class="dropdown-item" href="pengaturan.php">Pengaturan</a>
                                <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="keluar.php">Logout</a>
                            </div>';
                        }
                        ?>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="./buku.php">Lihat Buku</a>
                </li>
            </ul>
            <?php if ($title != "Daftar Buku") echo '<form name="search" action="buku.php" method="post" class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" name="searchkey" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" name="searchbtn" type="submit" value="Search">Search</button>
            </form>' ?>
        </div>
    </div>
</nav>