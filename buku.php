<?php
$title = "Daftar Buku";
$css = "style.css";
session_start();
include "template/head.php";
include "template/nav.php";
include "koneksi.php";

if ($_SESSION['login'] && $_GET['book']) {
    $id_buku = $_GET['book'];
    $username = $_SESSION['username'];
    $current = date("Y-m-d h:i:sa");
    $query = "INSERT INTO peminjaman set id_buku = $id_buku, id_anggota = '$username', tanggal_pinjam = '$current', status = 'book'";
    $sql = mysqli_query($koneksi, $query);
    $query2 = "update  buku set stok = (select stok from buku where id = $id_buku)-1 where id = $id_buku";
    $sql2 = mysqli_query($koneksi, $query2);
    if ($sql && $sql2) {

        header("location: buku.php");
    }
}
// if (isset($_GET['id'])) {
//     $id = htmlspecialchars($_GET["id"]);
//     $sql = "delete from buku where id='$id' ";
//     $hasil = mysqli_query($koneksi, $sql);
//     if ($hasil) {
//         echo "<script>swal('Data Berhasil Dihapus', '', 'success').then(function(){
//                 window.location.assign('buku.php');
//             });</script>";
//     } else {
//         echo "<script>swal('Data Gagal Dihapus', '', 'error').then(function(){
//                 window.location.assign('buku.php');
//             });</script>";
//     }
// }
?>

<div class="container">
    <div class="card" style="margin-top: 100px;">
        <div class="card-body">
            <h4 class="text-center">Daftar Buku</h4>
            <table id="table" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th style="width: 0;">ID Buku</th>
                        <th>Judul Buku</th>
                        <th>Pengarang</th>
                        <th>Tahun Terbit</th>
                        <th>Jenis Buku</th>
                        <?php if (isset($_SESSION['username'])) echo '<th>Aksi</th>' ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include("koneksi.php");
                    $sql = "select buku.id, buku.judul, buku.pengarang, buku.tahun, jenis_buku.jenis, buku.stok from buku join jenis_buku on buku.id_jenis = jenis_buku.id";
                    $hasil = mysqli_query($koneksi, $sql);
                    while ($data = mysqli_fetch_array($hasil)) {
                    ?>
                        <tr>
                            <td><?php echo $data["id"] ?></td>
                            <td><?php echo $data["judul"] ?></td>
                            <td><?php echo $data["pengarang"] ?></td>
                            <td><?php echo $data["tahun"] ?></td>
                            <td><?php echo $data["jenis"] ?></td>
                            <?php if ($_SESSION['role'] == 'admin') echo '<td><a href="edit.php?id=' . htmlspecialchars($data["id"]) . '" class="btn btn-warning" id="btnedit">Edit</a>
                                <a href="' . $_SERVER["PHP_SELF"] . '?id=' . $data["id"] . '" class="btn btn-danger confirmAlert" id="btnhapus">Hapus</a>
                                </td>';
                            else if (isset($_SESSION['username'])) {

                                $username = $_SESSION['username'];
                                $buku = $data['id'];
                                $stok  = $data['stok'];
                                $query = "select * from peminjaman where id_anggota = '$username' and id_buku = '$buku'";
                                $sql  = mysqli_query($koneksi, $query);
                                $baris = mysqli_fetch_array($sql);
                                if ($stok == "0") {
                                    if ($baris) {
                                        echo '<td><button  class="btn btn-secondary" id="btnbook" disabled>Ter-booking</button></div>';
                                    } else {
                                        echo '<td><button  class="btn btn-secondary" id="btnbook" disabled>Stok Habis</button></div>';
                                    }
                                } else
                                if ($baris && $stok) {
                                    echo '<td><button  class="btn btn-secondary" id="btnbook" disabled>Ter-booking</button></div>';
                                } else if (!$baris) {
                                    echo '<td><a href="buku.php?book=' . $buku . '" class="btn btn-primary" id="btnbook">Booking</a></div>';
                                }
                            } ?>

                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
include("template/foot.php")
?>