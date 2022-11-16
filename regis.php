<?php
session_start();
$title = "Registrasi";
$css = "regis.css";
include "template/head.php";
include "koneksi.php";

if ($_GET['sebagai'] == "admin") {
    $_SESSION['role'] = "admin";
} else if ($_GET['sebagai'] == "mahasiswa") {
    $_SESSION['role'] = "mahasiswa";
} else if ($_GET['sebagai'] == "tamu") {
    $_SESSION['role'] = "tamu";
} else if(!(($_GET['sebagai'] == "admin")||($_GET['sebagai'] == "anggota")||($_GET['sebagai'] == "tamu")) && !empty($_GET['sebagai'])){
    echo '<script>
        swal("Jangan bikin error kamu!", "", "error").then(function(){
            window.location.assign("index.php");
        });
        </script>';
}

$tabel_masuk = $_SESSION['role'];
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    if($tabel_masuk == "mahasiswa"){
    $nim = $_POST['nim'];
    }
    $nama = $_POST['nama'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $konpass = $_POST['konpass'];

    if(password_verify($konpass, $password)==''){
        echo "<script>
                swal('Password Tidak Sama!', '', 'error').then(function(){
                    window.location.assign('regis.php?sebagai=$tabel_masuk');
                })
            </script>";
        exit;
    }
    $result = mysqli_query($koneksi, "SELECT username FROM $tabel_masuk WHERE username = '$username'");
    if (mysqli_fetch_assoc($result)) {
        echo "<script>
                swal('Username Sudah Terdaftar!', '', 'error').then(function(){
                    window.location.assign('regis.php?sebagai=$tabel_masuk');
                })
		      </script>";
        return false;
    } else {
        if($tabel_masuk == "mahasiswa"){
        $query = "insert into $tabel_masuk values ('$nim', '$username', '$nama', '$password')";
        }else{
            $query = "insert into $tabel_masuk values ('', '$username', '$nama', '$password')";
        }
        $sql = mysqli_query($koneksi, $query);
    }

    if (mysqli_affected_rows($koneksi) > 0) {
        echo "<script>
                swal('User Baru Berhasil Ditambahkan!', '', 'error').then(function(){
                    window.location.assign('index.php');
                })
			  </script>";
        
    } else {
        echo mysqli_error($koneksi);
    }
}
?>
<div id="bg"></div>
<form action="regis.php" method="post" name="regis" id="regis">
    <?php 
        if($tabel_masuk == "mahasiswa"){
            echo"<div class='form-field'><input type='text' name='nim' id='nim' placeholder='NIM' required /></div>";
        }

    ?>
    <div class="form-field">
        <input type="text" name="username" id="username" placeholder="Username" required />
    </div>
    <div class="form-field">
        <input type="text" name="nama" id="nama" placeholder="Nama" required />
    </div>

    <div class="form-field">
        <input type="password" name="password" id="password" placeholder="Password" required />
    </div>

    <div class="form-field">
        <input type="password" name="konpass" id="konpass" placeholder="Konfirmasi Password" required />
    </div>

    <div class="form-field">
        <button class="btn" type="submit" name="login" id="login">Daftar</button>
    </div>
</form>

<?php
include "template/foot.php";
?>