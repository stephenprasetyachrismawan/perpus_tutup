<?php
$title = "Profil";
$css = "";
session_start();
//if(!isset($_SESSION['username'])){
//  header("location: index.php");
//}
include "koneksi.php";
include "template/head.php";
include "template/nav.php";
if (isset($_GET['del'])) {
    $hapus = $_GET['del'];

    $user = $_SESSION['username'];
    $query  = "DELETE from peminjaman where id_buku = '$hapus' and id_anggota = '$user'";
    $sql = mysqli_query($koneksi, $query);
    $query2 = "update  buku set stok = (select stok from buku where id = $hapus)+1 where id = $hapus";


    $sql2 =
        mysqli_query($koneksi, $query2);
    if ($sql && $sql2) {

        header("location: profil.php");
    }
}
if (isset($_SESSION['username']) && $_SESSION['role'] == 'mahasiswa') {
    $tabel = $_SESSION['role'];
    $user = $_SESSION['username'];
    $sql = mysqli_query($koneksi, "SELECT * FROM $tabel WHERE nim = '$user'");
    $data = mysqli_fetch_array($sql);
}
?>
<div class="container">
    <div class="col-md-12">
        <div class="card mb-3" style="margin-top: 100px;">
            <div class="card-body">
                <h4 class="text-center">Data Profile</h4>
                <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">NIM</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <?php echo $data['nim'] ?>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Nama</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <?php echo $data['nama'] ?>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Email</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <?php echo $data['email'] ?>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">No HP</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <?php echo $data['no_hp'] ?>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Alamat</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <?php echo $data['alamat'] ?>
                    </div>
                </div>
                <hr>
            </div>
        </div>
    </div>
    <div class="card" style="margin-top: 10px;">
        <div class="card-body">
            <h4 class="text-center">Riwayat Peminjaman</h4>
            <table id="riwayat" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Judul Buku</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Kembali</th>
                        <th>Status</th>

                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM peminjaman JOIN buku ON peminjaman.id_buku = buku.id WHERE id_anggota = '$user'";
                    $hasil = mysqli_query($koneksi, $sql);
                    while ($data = mysqli_fetch_array($hasil)) {
                    ?>
                        <tr>
                            <td><?php echo $data["judul"] ?></td>
                            <td><?php echo $data["tanggal_pinjam"] ?></td>
                            <td><?php echo $data["tanggal_kembali"] ?></td>
                            <td><?php echo $data["status"];
                                if ($data['status'] == "book") {
                                    $buku = $data['id_buku'];
                                    echo " || " . "<a href='profil.php?del=$buku'><button class='btn btn-danger'>Batal</button><a>";
                                }
                                ?> </td>

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
include "template/foot.php";
?>