<?php
if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] != "admin") {
        header("Location: index.php");
    }
    $id = $_GET['id'];
    $_SESSION['idbuku'] = $id;
}

if (isset($_POST['editkategori'])) {
    $nama = $_POST['namakategori'];
    $sql = mysqli_query($koneksi, "INSERT INTO jenis_buku(jenis) VALUES('$nama')");
    if ($sql) {
        echo "<script>
            swal('Kategori baru berhasil ditambahkan!', '', 'success');
        </script>";
    } else {
        echo "<script>
            swal('Kategori baru gagal ditambahkan!', '', 'error');
        </script>";
    }
}

if (isset($_POST['editbuku'])) {
    $judul = $_POST['judul'];
    $pengarang = $_POST['pengarang'];
    $thnterbit = $_POST['thnterbit'];
    $stok = $_POST['stok'];
    $kategori = $_POST['kategori'];

    $query = "UPDATE buku SET judul='$judul', pengarang='$pengarang', tahun=$thnterbit, stok=$stok, id_jenis='$kategori' where id = $_SESSION[idjenis] ";

    $sql = mysqli_query($koneksi, $query);


    if ($sql) {

        echo "<script>
                swal('Data Buku Berhasil Diedit', '', 'success').then(function(){
                    window.location.assign('dashboard.php?page=viewbuku');
                })
                </script>";
    } else echo "<script>
                swal('Data Buku Gagal Diedit!', '', 'error');
                </script>";
}
?>
<div class="container">
    <div class="card" style="margin-top: 100px;">
        <div class="card-body">
            <h4 class="text-center">Tambah Buku Perpustakaan</h4>
            <form action="dashboard.php?page=editbuku&id=<?php echo $id ?>" method="post" name="editbuku">
                <?php
                $sql = mysqli_query($koneksi, "SELECT * FROM buku where id = $id");
                while ($data1 = mysqli_fetch_array($sql)) {
                    $judul = $data1['judul'];
                    $pengarang = $data1['pengarang'];
                    $tahun = $data1['tahun'];
                    $id_jenis = $data1['id_jenis'];
                    $_SESSION['idjenis'] = $id_jenis;
                    $stok = $data1['stok'];
                }
                ?>
                <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Judul</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <input type="text" name="judul" id="judul" class="form-control" placeholder="Masukan Judul Buku" required value="<?php echo $judul ?>">
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Pengarang</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <input type="text" name="pengarang" id="pengarang" class="form-control" placeholder="Masukan Pengarang" required value="<?php echo $pengarang ?>">
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Tahun Terbit</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <input type="number" min="1900" max="2022" name="thnterbit" id="thnterbit" class="form-control" placeholder="Masukan Tahun Terbit" required value="<?php echo $tahun ?>">
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Stok</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <input type="number" min="0" name="stok" id="stok" class="form-control" placeholder="Masukan Stok" required value="<?php echo $stok ?>">
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Kategori</h6>
                    </div>
                    <div class="col-sm-5 text-secondary">
                        <select name="kategori" id="kategori" class="form-control" required>

                            <?php
                            $sql = mysqli_query($koneksi, "SELECT * FROM jenis_buku");
                            while ($data = mysqli_fetch_array($sql)) if ($id_jenis == $data['id']) echo '<option value="' . $data['id'] . '" class="form-control" selected>' . $data['jenis'] . '</option>';
                            else echo '
                                <option value="' . $data['id'] . '" class="form-control">' . $data['jenis'] . '</option>'
                            ?>
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <a href="#" data-toggle="modal" data-target="#kategoriModal" class="btn btn-primary">Tambah Kategori</a>
                    </div>
                </div>
                <hr>
                <button type="submit" class="btn btn-primary" name="editbuku">Simpan Perubahan</button>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="kategoriModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Kategori</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="dashboard.php?page=editbuku" method="post" name="editkategori">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Nama Kategori</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <input type="text" name="namakategori" id="namakategori" class="form-control" placeholder="Masukan Nama Kategori" required>
                        </div>
                    </div>
                    <hr>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button type="submit" name="editkategori" class="btn btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>