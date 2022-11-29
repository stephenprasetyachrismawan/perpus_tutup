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

if (isset($_POST['pinjam'])) {
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
            <h4 class="text-center">Tambahkan Peminjaman</h4>
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

                </div>
                <hr>
                <button type="submit" class="btn btn-primary" name="tambahbuku">Tambah Buku</button>
            </form>
        </div>
    </div>
</div>