<?php

include "koneksi.php";


if (isset($_GET['id'])) {
    $id = htmlspecialchars($_GET["id"]);
    $sql = "delete from buku where id='$id' ";
    $hasil = mysqli_query($koneksi, $sql);
    if ($hasil) {
        echo "<script>swal('Data Berhasil Dihapus', '', 'success').then(function(){
                window.location.assign('buku.php');
            });</script>";
    } else {
        echo "<script>swal('Data Gagal Dihapus', '', 'error').then(function(){
                window.location.assign('buku.php');
            });</script>";
    }
}
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
                    $sql = "select buku.id, buku.judul, buku.pengarang, buku.tahun, jenis_buku.jenis from buku join jenis_buku on buku.id_jenis = jenis_buku.id";
                    $hasil = mysqli_query($koneksi, $sql);
                    while ($data = mysqli_fetch_array($hasil)) {
                    ?>
                        <tr>
                            <td><?php echo $data["id"] ?></td>
                            <td><?php echo $data["judul"] ?></td>
                            <td><?php echo $data["pengarang"] ?></td>
                            <td><?php echo $data["tahun"] ?></td>
                            <td><?php echo $data["jenis"] ?></td>
                            <?php if ($_SESSION['role'] == 'admin') echo '<td><a href="?page=editbuku&id=' . htmlspecialchars($data["id"]) . '" class="btn btn-warning" id="btnedit">Edit</a>
                                <a href="' . $_SERVER["PHP_SELF"] . '?id=' . $data["id"] . '" class="btn btn-danger confirmAlert" id="btnhapus">Hapus</a>
                                </td>';
                            else if (isset($_SESSION['username'])) {
                                $buku = $data['id'];
                                echo '<td><a href="buku-booking.php?id=' . $buku . '" class="btn btn-primary" id="btnbook">Pinjam</a></div>';
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