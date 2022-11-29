<?php
$title = "Dashboard";
$css = "sb-admin-2.min.css";
session_start();
if ($_SESSION['role'] != "admin") header('Location: index.php');
include "template/head.php";
include "koneksi.php";
?>


<!-- Page Wrapper -->
<div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="dashboard.php">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-solid fa-book-open"></i>
            </div>
            <div class="sidebar-brand-text mx-3">Perpustakaan <br> Tutup</div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->
        <li class="nav-item active">
            <a class="nav-link" href="dashboard.php">
                <i class="fas fa-fw fa-home"></i>
                <span>Dashboard</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Manajemen Anggota
        </div>

        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-user-circle"></i>
                <span>Manajemen Anggota</span>
            </a>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="?page=tmahasiswa">Tambah Anggota</a>
                    <a class="collapse-item" href="?page=ttamu">Tambah Tamu</a>
                    <a class="collapse-item" href="?page=viewanggota">Daftar Seluruh Anggota</a>
                </div>
            </div>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Manajemen Buku
        </div>


        <!-- Nav Item - Utilities Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities1" aria-expanded="true" aria-controls="collapseUtilities">
                <i class="fas fa-fw fa-folder"></i>
                <span>Manajemen Buku</span>
            </a>
            <div id="collapseUtilities1" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="?page=tbuku">Tambah Buku</a>
                    <a class="collapse-item" href="?page=viewbuku">Daftar Buku</a>
                </div>
            </div>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">

        <!-- Heading -->
        <div class="sidebar-heading">
            Transaksi Buku
        </div>


        <!-- Nav Item - Utilities Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities2" aria-expanded="true" aria-controls="collapseUtilities">
                <i class="fas fa-fw fa-folder"></i>
                <span>Transaksi Buku</span>
            </a>
            <div id="collapseUtilities2" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="?page=pinjam">Pinjam Buku</a>
                    <a class="collapse-item" href="?page=viewpinjam">Daftar Peminjaman Buku</a>
                </div>
            </div>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">
            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                <!-- Sidebar Toggle (Topbar) -->
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                    <i class="fa fa-bars"></i>
                </button>


                <!-- Topbar Navbar -->
                <ul class="navbar-nav ml-auto">


                    <div class="topbar-divider d-none d-sm-block"></div>

                    <!-- Nav Item - User Information -->
                    <?php
                    $sql = mysqli_query($koneksi, "SELECT pic FROM admin WHERE username = '" . $_SESSION['username'] . "'");
                    $data = mysqli_fetch_array($sql);
                    ?>
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small text-capitalize"><?php echo $_SESSION['nama'] ?></span>
                            <img class="img-profile rounded-circle" src="<?php echo $data['pic'] ?>" alt="profile">
                        </a>
                        <!-- Dropdown - User Information -->
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="dashboard.php?page=pengaturan">
                                <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                Pengaturan
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                Logout
                            </a>
                        </div>
                    </li>
                    <?php
                    ?>

                </ul>

            </nav>
            <!-- End of Topbar -->

            <!-- Begin Page Content -->
            <div class="container-fluid">

                <?php
                $act = "dashboard";
                $judul = "home";

                if (isset($_GET['page'])) {
                    $act = $_GET['page'];
                }
                ?>
                <?php
                switch ($act) {
                    case "":
                        $halaman = "_home.php";
                        $judul = "Dashboard";
                        break;
                    case "dashboard":
                        $halaman = "_home.php";
                        $judul = "Dashboard";
                        break;
                    case "pengaturan":
                        $halaman = "_pengaturan.php";
                        $judul = "Pengaturan";
                        break;
                    case "tmahasiswa":
                        $halaman = "_tmahasiswa.php";
                        $judul = "Tambah Mahasiswa";
                        break;
                    case "ttamu":
                        $halaman = "_ttamu.php";
                        $judul = "Tambah Tamu";
                        break;
                    case "viewanggota":
                        $halaman = "_viewanggota.php";
                        $judul = "Daftar Anggota";
                        break;
                    case "editanggota":
                        $halaman = "_editanggota.php";
                        $judul = "Edit Anggota";
                        break;
                    case "tbuku":
                        $halaman = "_tbuku.php";
                        $judul = "Tambah Buku";
                        break;
                    case "viewbuku":
                        $halaman = "_viewbuku.php";
                        $judul = "Lihat Buku";
                        break;
                    case "editbuku":
                        $halaman = "_editbuku.php";
                        $judul = "Edit Buku";
                        break;
                    case "pinjam":
                        $halaman = "_pinjam.php";
                        $judul = "Peminjaman Buku";
                        break;
                    case "viewpinjam":
                        $halaman = "_viewpinjam";
                        $judul = "Daftar Pinjam";
                        break;
                    default:
                        echo '<script>swal("Maaf halaman tidak ada", "", "error").then(function(){
            window.location.assign("?page=dashboard");

        });
        </script>';
                }
                ?>
                <!-- Page Heading -->
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800 text-uppercase"><?php echo $judul; ?></h1>
                </div><?php
                        include $halaman;
                        ?>

            </div>

        </div>
        <!-- End of Main Content -->

        <!-- Footer -->
        <footer class="sticky-footer bg-white">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>
                        <p class="mb-1">Copyright &copy; 2022 | Sistem Informasi Perpustakaan</p>
                    </span><br>
                </div>
            </div>
        </footer>

    </div>
    <!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Yakin Mau Keluar?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Pilih Option "Logout" Untuk Keluar Dan Pilih Option "Cancel" Untuk Membatalkan</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="keluar.php">Logout</a>
            </div>
        </div>
    </div>
</div>

<?php
include "template/foot.php";
?>