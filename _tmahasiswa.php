<?php
session_start();

include "koneksi.php";

if (isset($_SESSION['role'])) {
    if (!$_SESSION['role'] == "admin") {
        header("location: index.php");
    }
}
$hal = $_GET['page'];
if ($hal == "tmahasiswa") {
    $tabel_masuk = "mahasiswa";
} else if ($hal == "tamu") {
    $tabel_masuk = "tamu";
} else {
    echo '<script>
        swal("Jangan bikin error kamu!", "", "error").then(function(){
            window.location.assign("index.php");
        });
        </script>';
}


if (isset($_POST['regis'])) {
    $username = $_POST['username'];
    $nama = $_POST['nama'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $konpass = $_POST['konpass'];
    $email = $_POST['email'];
    $nohp = $_POST['nohp'];
    $alamat = $_POST['alamat'];

    if (password_verify($konpass, $password) == '') {
        echo "<script>
                swal('Password Tidak Sama!', '', 'error').then(function(){
                    window.location.assign('regis.php?sebagai=$tabel_masuk');
                })
            </script>";
        exit;
    }
    if ($tabel_masuk == "mahasiswa") {
        $result = mysqli_query($koneksi, "SELECT nim FROM $tabel_masuk WHERE nim = '$username'");
    } else {
        $result = mysqli_query($koneksi, "SELECT username FROM $tabel_masuk WHERE username = '$username'");
    }
    if (mysqli_fetch_assoc($result)) {
        echo "<script>
                swal('Username Sudah Terdaftar!', '', 'error').then(function(){
                    window.location.assign('dashboard.php?page=tmahasiswa');
                })
		      </script>";
        return false;
    } else {
        $query = "insert into $tabel_masuk values ('', '$username', '$nama', '$password', '$email', '$nohp', '$alamat')";
        $sql = mysqli_query($koneksi, $query);
    }

    if (mysqli_affected_rows($koneksi) > 0) {
        echo "<script>
                swal('User Baru Berhasil Ditambahkan!', '', 'success').then(function(){
                    window.location.assign('dashboard.php?page=tmahasiswa');
                })
			  </script>";
    } else {
        echo mysqli_error($koneksi);
    }
}
?>
<div class="container">
    <div class="card" style="margin-top: 100px;">
        <div class="card-body">
            <h4 class="text-center">Pendaftaran Anggota Perpustakaan</h4>
            <form action="dashboard.php?page=tmahasiswa" method="post" name="regis" id="regis">
                <?php
                if ($tabel_masuk == "mahasiswa") {
                    echo "<div class='form-field'><label>NIM:</label><input type='text' name='username' id='username' class='form-control' placeholder='Masukan NIM' required /></div>";
                } else {
                    echo '<div class="form-field">
                        <label>Username:</label>
                        <input type="text" name="username" id="username" class="form-control" placeholder="Masukan Username" required />
                    </div>';
                }
                ?>
                <div class="form-group">
                    <label>Nama:</label>
                    <input type="text" name="nama" id="nama" class="form-control" placeholder="Masukan Nama" required />
                </div>

                <div class="form-group">
                    <label>Password:</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Masukan Password" required />
                </div>

                <div class="form-group">
                    <label>Konfirmasi Password:</label>
                    <input type="password" name="konpass" id="konpass" class="form-control" placeholder="Konfirmasi Password" required />
                </div>

                <div class="form-group">
                    <label>Email:</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="Masukan Email" required />
                </div>

                <div class="form-group">
                    <label>No HP:</label>
                    <input type="text" name="nohp" id="nohp" class="form-control" placeholder="Masukan No HP" />
                </div>

                <div class="form-group">
                    <label>Alamat:</label>
                    <textarea name="alamat" id="alamat" cols="30" rows="10" class="form-control" placeholder="Masukan Alamat"></textarea>
                </div>

                <button class="btn btn-primary" type="submit" name="regis" id="regis">Daftar</button>
            </form>
        </div>
    </div>
</div>

<?php
include "template/foot.php";
?>