<?php
$title = "Profil";
$css = "";
session_start();
if (!isset($_SESSION['username'])) {
    header("location: index.php");
}
include "koneksi.php";
include "template/head.php";
include "template/nav.php";

if (isset($_SESSION['username']) && $_SESSION['role'] != 'admin') {
    $tabel = $_SESSION['role'];
    $user = $_SESSION['username'];
    if($tabel=="mahasiswa") $sql = mysqli_query($koneksi, "SELECT * FROM $tabel WHERE nim = '$user'");
    else $sql = mysqli_query($koneksi, "SELECT * FROM $tabel WHERE username = '$user'");
    $data = mysqli_fetch_array($sql);
}

if(isset($_POST['edit'])){
    $tabel = $_SESSION['role'];
    $username = $_SESSION['username'];
    if($tabel=="mahasiswa") $pass = mysqli_fetch_array(mysqli_query($koneksi, "SELECT password FROM $tabel WHERE nim = '$username'"));
    else $pass = mysqli_fetch_array(mysqli_query($koneksi, "SELECT password FROM $tabel WHERE username = '$username'"));
    if (!password_verify($_POST['password'], $pass['password'])){
        echo '<script> swal("Password salah! Data gagal diedit!", "", "error").then(function(){
            window.location.assign("pengaturan.php")
            }) </script>';
        exit;
    }
    if(isset($_POST['passwordbaru'])){
        $password = password_hash($_POST['passwordbaru'], PASSWORD_DEFAULT);
        $konpass = $_POST['passwordbarukonf'];
        if(!password_verify($konpass, $password)){
            echo '<script> swal("Password baru berbeda! Data gagal diedit!", "", "error").then(function(){
                window.location.assign("pengaturan.php")
                }) </script>';
            exit;
        }
    }
    $email = $_POST['email'];
    $nohp = $_POST['nohp'];
    $alamat = $_POST['alamat'];
    if($tabel=="mahasiswa"){
        if(!empty($_POST['passwordbaru'])) $query = "UPDATE $tabel SET email = '$email', no_hp = '$nohp', alamat = '$alamat', password = '$password' WHERE nim = '$username'";
        else $query = "UPDATE $tabel SET email = '$email', no_hp = '$nohp', alamat = '$alamat' WHERE nim = '$username'";
        $sql = mysqli_query($koneksi, $query);
        if($sql){
            echo '<script> swal("Data berhasil diperbarui!", "", "success").then(function(){
                window.location.assign("profil.php")
                }) </script>';
        }else echo 'swal("Data gagal diperbarui!", "", "error").then(function(){
            window.location.assign("pengaturan.php")
            }) </script>';
    }else{
        if(!empty($_POST['passwordbaru'])) $query = "UPDATE $tabel SET email = '$email', no_hp = '$nohp', alamat = '$alamat', password = '$password' WHERE username = '$username'";
        else $query = "UPDATE $tabel SET email = '$email', no_hp = '$nohp', alamat = '$alamat' WHERE username = '$username'";
        $sql = mysqli_query($koneksi, $query);
        if($sql){
            echo '<script> swal("Data berhasil diperbarui!", "", "success").then(function(){
                window.location.assign("profil.php")
                }) </script>';
        }else echo 'swal("Data gagal diperbarui!", "", "error").then(function(){
            window.location.assign("pengaturan.php")
            }) </script>';
    }
}
?>
<div class="container">
    <div class="col-md-12">
        <div class="card" style="margin-top: 100px; margin-bottom: 20px;">
            <div class="card-body">
                <h4 class="text-center">Edit Data Profile</h4>
                <form action="pengaturan.php" method="post" name="edit" enctype="multipart/form-data">
                    <?php if($tabel=="mahasiswa") echo '<div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">NIM</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <input type="text" name="username" id="username" value="'.$data['nim'].'" class="form-control text-uppercase" disabled>
                        </div>
                    </div>';
                    else echo '<div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Username</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <input type="text" name="username" id="username" value="'.$data['username'].'" class="form-control text-uppercase" disabled>
                    </div>
                </div>'; ?>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Nama</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <input type="text" name="nama" id="nama" value="<?php echo $data['nama'] ?>" class="form-control text-capitalize" disabled>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Email</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <input type="email" name="email" id="email" value="<?php echo $data['email'] ?>" class="form-control" placeholder="Masukan Email">
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">No HP</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <input type="text" name="nohp" id="nohp" value="<?php echo $data['no_hp'] ?>" class="form-control" placeholder="Masukan No HP">
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Alamat</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <textarea name="alamat" id="alamat" cols="30" rows="10" class="form-control" placeholder="MasukanAlamat"><?php echo $data['alamat'] ?></textarea>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Password</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <input type="password" name="password" id="password" class="form-control" placeholder="Masukan Password Lama" required>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Password Baru</h6>
                            <p><strong>*isi jika ingin mengganti password</strong></p>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <input type="password" name="passwordbaru" id="passwordbaru" class="form-control" placeholder="Masukan Password Baru">
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Konfirmasi Password Baru</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <input type="password" name="passwordbarukonf" id="passwordbarukonf" class="form-control" placeholder="Konfirmasi Password Baru">
                        </div>
                    </div>
                    <hr>
                    <button type="submit" class="btn btn-primary" name="edit">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
include "template/foot.php";
?>