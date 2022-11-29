<?php

if (isset($_GET['id_mhs'])) {
    $id = htmlspecialchars($_GET["id_mhs"]);
    $sql = "delete from mahasiswa where nim='$id'";
    
    $hasil = mysqli_query($koneksi, $sql);
    if ($hasil) {
        echo "<script>swal('Data Berhasil Dihapus', '', 'success').then(function(){
                window.location.assign('?page=viewanggota');
            });</script>";
    } else {
        echo "<script>swal('Data Gagal Dihapus', '', 'error').then(function(){
                window.location.assign('?page=viewanggota');
            });</script>";
    }
}

if (isset($_GET['id_tm'])) {
    $id = htmlspecialchars($_GET["id_tm"]);
    $sql = "delete from tamu where username='$id' ";
    $hasil = mysqli_query($koneksi, $sql);
    if ($hasil) {
        echo "<script>swal('Data Berhasil Dihapus', '', 'success').then(function(){
                window.location.assign('?page=viewanggota');
            });</script>";
    } else {
        echo "<script>swal('Data Gagal Dihapus', '', 'error').then(function(){
                window.location.assign('?page=viewanggota');
            });</script>";
    }
}
?>

<div class="container">
    <div class="card" style="margin-top: 100px;">
        <div class="card-body">
            <h4 class="text-center">Daftar Anggota</h4>
            <table id="anggota" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th style="width: 0;">ID Anggota</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>No Hp</th>
                        <th>Alamat</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM mahasiswa";
                    $hasil = mysqli_query($koneksi, $sql);
                    while ($data = mysqli_fetch_array($hasil)) {
                    ?>
                        <tr>
                            <td><?php echo $data["nim"] ?></td>
                            <td><?php echo $data["nama"] ?></td>
                            <td><?php echo $data["email"] ?></td>
                            <td><?php echo $data["no_hp"] ?></td>
                            <td><?php echo $data["alamat"] ?></td>
                            <td class="badge badge-primary">Mahasiswa</td>
                            <td><a href="?page=editanggota&id_mhs=<?php echo htmlspecialchars($data["nim"]) ?>" class="btn btn-warning" id="btnedit">Edit</a>
                                <a href="?page=viewanggota&id_mhs=<?php echo $data["nim"] ?>" class="btn btn-danger confirmAlert" id="btnhapus">Hapus</a>
                                </td>
                        </tr>
                    <?php
                    }
                    $sql = "SELECT * FROM tamu";
                    $hasil = mysqli_query($koneksi, $sql);
                    while ($data = mysqli_fetch_array($hasil)) {
                        ?>
                            <tr>
                                <td><?php echo $data["username"] ?></td>
                                <td><?php echo $data["nama"] ?></td>
                                <td><?php echo $data["email"] ?></td>
                                <td><?php echo $data["no_hp"] ?></td>
                                <td><?php echo $data["alamat"] ?></td>
                                <td class="badge badge-secondary">Tamu</td>
                                <td><a href="?page=editanggota&id_tm=<?php echo htmlspecialchars($data["username"]) ?>" class="btn btn-warning" id="btnedit">Edit</a>
                                    <a href="?page=viewanggota&id_tm=<?php echo $data["username"] ?>" class="btn btn-danger confirmAlert" id="btnhapus">Hapus</a>
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