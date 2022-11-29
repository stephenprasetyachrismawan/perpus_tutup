<?php
$user = $_SESSION['username'];
$data = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM admin WHERE username = '$user'"));

if (isset($_POST['editprofil'])) {
    $pass = $_POST['password'];
    if (!password_verify($pass, $data['password'])) {
        echo "<script>
                swal('Password Salah!', '', 'error').then(function(){
                    window.location.assign('dashboard.php?page=profil');
                })
            </script>";
        exit;
    }
    $nama = $_POST['nama'];
    if (!empty($_FILES['pic']['name'])) {
        $namafoto = $data['username'] . "." . strtolower(end(explode('.', $_FILES["pic"]["name"])));
        $lokasifoto = $_FILES['pic']['tmp_name'];
        $fulldir = "img/" . $namafoto;
        $dir = "img/";
        $foto = $dir . $namafoto;
        $query = "UPDATE admin SET nama = '$nama', pic='$foto' WHERE username = '" . $data['username'] . "'";
        $sql = mysqli_query($koneksi, $query);
        if ($sql) {
            move_uploaded_file($lokasifoto, $fulldir);
            $_SESSION['nama'] = $nama;
            echo "<script>
                swal('Data Profil Berhasil Diedit!', '', 'success').then(function(){
                    window.location.assign('dashboard.php?page=pengaturan');
                })
                </script>";
            exit;
        } else {
            echo "<script>
                swal('Data Profil Gagal Diedit!', '', 'error').then(function(){
                    window.location.assign('dashboard.php?page=pengaturan');
                })
                </script>";
            exit;
        }
    } else {
        $query = "UPDATE admin SET nama = '$nama' WHERE username = '" . $data['username'] . "'";
        $sql = mysqli_query($koneksi, $query);
        if ($sql) {
            $_SESSION['nama'] = $nama;
            echo "<script>
                swal('Data Profil Berhasil Diedit!', '', 'success').then(function(){
                    window.location.assign('dashboard.php?page=pengaturan');
                })
                </script>";
            exit;
        } else {
            echo "<script>
                swal('Data Profil Gagal Diedit!', '', 'error').then(function(){
                    window.location.assign('dashboard.php?page=pengaturan');
                })
                </script>";
            exit;
        }
    }
}

if (isset($_POST['gantipass'])) {
    $passlama = $_POST['passlama'];
    $passbaru = password_hash($_POST['passbaru'], PASSWORD_DEFAULT);
    $passbarukonf = $_POST['passbarukonf'];
    if (!password_verify($passlama, $data['password'])) {
        echo "<script>
                swal('Password Salah!', '', 'error').then(function(){
                    window.location.assign('dashboard.php?page=pengaturan');
                })
            </script>";
        exit;
    } else if (!password_verify($passbarukonf, $passbaru)) {
        echo "<script>
                swal('Password Baru Tidak Sama!', '', 'error').then(function(){
                    window.location.assign('dashboard.php?page=pengaturan');
                })
            </script>";
        exit;
    }
    $sql = mysqli_query($koneksi, "UPDATE admin SET password='$passbaru' WHERE username = '" . $data['username'] . "'");
    if ($sql) {
        echo "<script>
                swal('Password Berhasil Diganti!', '', 'success').then(function(){
                    window.location.assign('dashboard.php?page=pengaturan');
                })
                </script>";
        exit;
    }
}
?>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="text-center">Profil</h5>
            </div>
            <div class="card-body">
                <form action="?page=pengaturan" method="post" name="editprofil" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Nama</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <input type="text" name="nama" id="nama" class="form-control" value="<?php echo $data['nama'] ?>" placeholder="Masukan Nama" required>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Foto</h6>
                        </div>
                        <div class="col-sm-9 align-items-center text-center">
                            <input type="file" name="pic" id="pic" accept=".jpg, .jpeg, .png" onchange="return valid();">
                            <img src="<?php echo $data['pic'] ?>" id="display" alt="pic" width="150" <?php if (!isset($data['pic'])) echo "hidden" ?>>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Password</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <input type="password" name="password" id="password" class="form-control" placeholder="Masukan Password" required>
                        </div>
                    </div>
                    <hr>
                    <button type="submit" name="editprofil" class="btn btn-primary">Edit</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="text-center">Ubah Password</h5>
            </div>
            <div class="card-body">
                <form action="?page=pengaturan" method="post" name="gpass">
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Password Lama</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <input type="password" name="passlama" id="passlama" class="form-control" placeholder="Masukan Password Lama" required>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Password Baru</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <input type="password" name="passbaru" id="passbaru" class="form-control" placeholder="Masukan Password Baru" required>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Konfirmasi Password Baru</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <input type="password" name="passbarukonf" id="passbarukonf" class="form-control" placeholder="Konfirmasi Password Baru" required>
                        </div>
                    </div>
                    <hr>
                    <button type="submit" name="gantipass" id="gantipass" class="btn btn-primary">Ganti</button>
                </form>
            </div>
        </div>
    </div>
</div>