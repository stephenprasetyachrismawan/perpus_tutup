<?php
if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] != "admin") {
        header("Location: index.php");
    }
}

if (isset($_POST['tambahkategori'])) {
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

if (isset($_POST['tambahbuku'])) {
    $judul = $_POST['judul'];
    $pengarang = $_POST['pengarang'];
    $thnterbit = $_POST['thnterbit'];
    $stok = $_POST['stok'];
    $kategori = $_POST['kategori'];

    $query = "INSERT INTO buku(judul, pengarang, tahun, stok, id_jenis) VALUES('$judul', '$pengarang', '$thnterbit', '$stok', '$kategori')";
    $sql = mysqli_query($koneksi, $query);
    if ($sql) {
        echo "<script>
                swal('Data Buku Berhasil Ditambahkan!', '', 'success').then(function(){
                    window.location.assign('dashboard.php?page=viewbuku');
                })
                </script>";
    } else echo "<script>
                swal('Data Buku Gagal Ditambahkan!', '', 'error');
                </script>";
}
?>
<div class="container">
    <div class="card" style="margin-top: 100px;">
        <div class="card-body">
            <h4 class="text-center">Tambah Buku Perpustakaan</h4>
            <form action="dashboard.php?page=tbuku" method="post" name="tambahbuku">
                <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Judul</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <input type="text" name="judul" id="judul" class="form-control" placeholder="Masukan Judul Buku" required>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Pengarang</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <input type="text" name="pengarang" id="pengarang" class="form-control" placeholder="Masukan Pengarang" required>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Tahun Terbit</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <input type="number" min="1900" max="2022" name="thnterbit" id="thnterbit" class="form-control" placeholder="Masukan Tahun Terbit" required>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Stok</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <input type="number" min="0" name="stok" id="stok" class="form-control" placeholder="Masukan Stok" required>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Kategori</h6>
                    </div>
                    <div class="col-sm-5 text-secondary">
                        <select name="kategori" id="kategori" class="form-control" required>
                            <option value="" class="form-control">-- pilih kategori --</option>
                            <?php
                            $sql = mysqli_query($koneksi, "SELECT * FROM jenis_buku");
                            while ($data = mysqli_fetch_array($sql)) echo '
                                <option value="' . $data['id'] . '" class="form-control">' . $data['jenis'] . '</option>'
                            ?>
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <a href="#" data-toggle="modal" data-target="#kategoriModal" class="btn btn-primary">Tambah Kategori</a>
                    </div>
                </div>
                <hr>
                <button type="submit" class="btn btn-primary" name="tambahbuku">Tambah Buku</button>
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
            <form action="dashboard.php?page=tbuku" method="post" name="tambahkategori">
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
                    <button type="submit" name="tambahkategori" class="btn btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>