<?php
$title = "Daftar Buku";
$css = "style.css";
include "koneksi.php";
include("template/head.php");
// include "template/nav.php";

if (isset($_GET['id'])) {
    $id=htmlspecialchars($_GET["id"]);

    $sql="delete from buku where id='$id' ";
    $hasil=mysqli_query($koneksi,$sql);
    if ($hasil) {
        header("location: buku.php");
    }
    else {
        echo "<div class='alert alert-danger'> Data Gagal dihapus!</div>";
    }
}
?>

<div class="container">
    <div class="card mt-5">
        <div class="card-body">
            <table id="table" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th style="width: 0;">ID Buku</th>
                        <th>Judul Buku</th>
                        <th>Pengarang</th>
                        <th>Tahun Terbit</th>
                        <th>Jenis Buku</th>
                        <th>Aksi</th>
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
                            <td><a href="edit.php?id=<?php echo htmlspecialchars($data["id"]) ?>" class="btn btn-warning" id="btnedit">Edit</a>
                                <a href="<?php $_SERVER["PHP_SELF"] ?>?id=<?php echo $data["id"] ?>" class="btn btn-danger" id="btnhapus">Hapus</a>
                            </td>

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