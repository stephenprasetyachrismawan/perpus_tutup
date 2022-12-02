<?php

if (isset($_POST['tambahpeminjaman'])) {
    $id_buku = $_POST['id_buku'];
    $id_anggota = $_POST['id_anggota'];
    $tanggal_pinjam = date("Y-m-d h:i:sa");
    $status = "process";
    $query = "INSERT INTO peminjaman(id_buku, id_anggota, tanggal_pinjam, status) VALUES('$id_buku', '$id_anggota', '$tanggal_pinjam', '$status')";
    $sql = mysqli_query($koneksi, $query);
    $query2 = "update buku set stok = (select stok from buku where id = $id_buku)-1 where id = $id_buku";
    $sql2 = mysqli_query($koneksi, $query2);
    if ($sql && $sql2) {
        echo "<script>
                swal('Data Peminjaman Berhasil Ditambahkan!', '', 'success')
                </script>";
    } else echo "<script>
                swal('Data Peminjaman Gagal Ditambahkan!', '', 'error');
                </script>";
}
if (isset($_GET['id_del'])) {
    $hapus = $_GET['id_del'];
    $data = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM peminjaman WHERE id=$hapus"));
    $id_buku = $data['id_buku'];

    if ($data['status'] != "done") {
        $query2 = "update  buku set stok = (select stok from buku where id = $id_buku)+1 where id = $id_buku";
        $sql2 = mysqli_query($koneksi, $query2);
    }
    $query  = "DELETE from peminjaman where id= $hapus";
    $sql = mysqli_query($koneksi, $query);

    if ($sql && $sql2 && $data['status'] != "done") {
        echo "<script>swal('Data Berhasil Dihapus', '', 'success').then(function(){
            window.location.assign('?page=viewpinjam');
        });</script>";
        exit;
    } elseif ($sql) {
        echo "<script>swal('Data Berhasil Dihapus', '', 'success').then(function(){
            window.location.assign('?page=viewpinjam');
        });</script>";
    } else {
        echo "<script>swal('Data Gagal Dihapus', '', 'error').then(function(){
            window.location.assign('?page=viewpinjam');
        });</script>";
    }
}

if (isset($_GET['id_acc'])) {
    $id = htmlspecialchars($_GET["id_acc"]);
    $waktusekarang = date("Y-m-d h:i:sa");
    $sql = "UPDATE peminjaman SET tanggal_pinjam = '$waktusekarang', status = 'process' WHERE id=$id";
    $hasil = mysqli_query($koneksi, $sql);
    if ($hasil) {
        echo "<script>swal('Peminjaman Berhasil Dikonfirmasi', '', 'success').then(function(){
            window.location.assign('?page=viewpinjam');
        });</script>";
    } else {
        echo "<script>swal('Peminjaman Gagal Dikonfirmasi', '', 'error').then(function(){
            window.location.assign('?page=viewpinjam');
        });</script>";
    }
}

if (isset($_GET['id_kem'])) {
    $id = $_GET['id_kem'];
    $data = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM peminjaman WHERE id=$id"));
    $id_buku = $data['id_buku'];
    $kembali = date("Y-m-d h:i:sa");
    $sql = mysqli_query($koneksi, "UPDATE peminjaman SET tanggal_kembali = '$kembali', status = 'done' WHERE id = $id");
    $sql2 = mysqli_query($koneksi, "UPDATE  buku SET stok = (SELECT stok FROM buku WHERE id = $id_buku)+1 where id = $id_buku");
    if ($sql && $sql2) {
        echo "<script>swal('Pengembalian Berhasil Dikonfirmasi', '', 'success').then(function(){
            window.location.assign('?page=viewpinjam');
        });</script>";
    } else {
        echo "<script>swal('Pengembalian Gagal Dikonfirmasi', '', 'error').then(function(){
            window.location.assign('?page=viewpinjam');
        });</script>";
    }
}
?>

<div class="container">
    <div class="card">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-9">
                    <h4 class="text-center">Daftar Peminjaman Buku</h4>
                </div>
                <div class="col-md-3">
                    <a href="#" data-toggle="modal" data-target="#pinjamModal" class="btn btn-primary">Tambah Peminjaman</a>
                </div>
            </div>
            <table id="pinjam" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th style="width: 0;">ID Peminjaman</th>
                        <th style="width: 0;">ID Buku</th>
                        <th style="width: 0;">NIM</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Kembali</th>
                        <th>Status</th>
                        <th style="width: 140px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $hasil = mysqli_query($koneksi, "SELECT * FROM peminjaman");
                    while ($data = mysqli_fetch_array($hasil)) {
                    ?>
                        <tr>
                            <td><?php echo $data["id"] ?></td>
                            <td><?php echo $data["id_buku"] ?></td>



                            <td><?php echo $data["id_anggota"] ?></td>
                            <?php
                            $id_buku = $data["id_buku"];
                            $id_anggota = $data["id_anggota"];
                            ?>
                            <td><?php echo $data["tanggal_pinjam"] ?></td>
                            <td><?php echo $data["tanggal_kembali"] ?></td>
                            <td class="badge <?php if ($data['status'] == 'done') echo "badge-success";
                                                elseif ($data['status'] == 'process') echo "badge-primary";
                                                else echo "badge-warning" ?> text-uppercase"><?php echo $data['status'] ?></td>
                            <td>
                                <?php
                                $buku = mysqli_fetch_array(mysqli_query($koneksi, "SELECT judul FROM buku WHERE id=$id_buku"));
                                if ($data['status'] == 'book') echo '<a href="?page=viewpinjam&id_acc=' . $data['id'] . '" class="btn btn-success confirmAcc" id="btnacc"><i class="fas fa-check"></i></a>';
                                elseif ($data['status'] == 'process') echo '<a href="?page=viewpinjam&id_kem=' . $data['id'] . '" class="btn btn-success confirmKembali" data-buku="' . $buku['judul'] . '" data-id=' . $data['id'] . '>Kembalikan</a>' ?>
                                <a href="?page=viewpinjam&id_del=<?php echo $data['id'] ?>" class="btn btn-danger confirmAlert" id="btnhapus"><i class="fas fa-trash"></i></a>
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

<div class="modal fade" id="pinjamModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Peminjaman</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="dashboard.php?page=viewpinjam" method="post" name="tambahpeminjaman">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-4">
                            <h6 class="mb-0">Buku</h6>
                        </div>
                        <div class="col-sm-8 text-secondary">
                            <select name="id_buku" id="id_buku" class="form-control" required>
                                <option value="" class="form-control">-- pilih buku --</option>
                                <?php
                                $sql = mysqli_query($koneksi, "SELECT * FROM buku");
                                while ($data = mysqli_fetch_array($sql)) {
                                    if ($data['stok'] > 0) {
                                        echo '
                                    <option value="' . $data['id'] . '" class="form-control">' . $data['id'] . ' - ' . $data['judul'] . '</option>';
                                    }
                                } ?>
                            </select>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-4">
                            <h6 class="mb-0">Anggota</h6>
                        </div>
                        <div class="col-sm-8 text-secondary">
                            <select name="id_anggota" id="anggota" class="form-control" required>
                                <option value="" class="form-control">-- pilih anggota --</option>
                                <?php
                                $sql = mysqli_query($koneksi, "SELECT * FROM mahasiswa");
                                while ($data = mysqli_fetch_array($sql)) echo '
                                <option value="' . $data['nim'] . '" class="form-control">' . $data['nim'] . ' - ' . $data['nama'] . '</option>';
                                $sql = mysqli_query($koneksi, "SELECT * FROM tamu");
                                while ($data = mysqli_fetch_array($sql)) echo '
                                <option value="' . $data['username'] . '" class="form-control">' . $data['username'] . ' - ' . $data['nama'] . '</option>';
                                ?>
                            </select>
                        </div>
                        <hr>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" name="tambahpeminjaman">Tambah Peminjaman</button>
                </div>
            </form>
        </div>
    </div>
</div>