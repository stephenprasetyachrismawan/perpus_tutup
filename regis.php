<?php
session_start();
$title = "Registrasi";
$css = "login.css";
include "template/head.php";
include "koneksi.php";
?>
<?php
if ($_GET['sebagai'] == "admin") {
    $_SESSION['role'] = "admin";
} else if ($_GET['sebagai'] == "anggota") {
    $_SESSION['role'] = "mahasiswa";
} else if ($_GET['sebagai'] == "tamu") {
    $_SESSION['role'] = "tamu";
} else{
    echo '<script>
        alert("Jangan bikin error kamu!");
        window.location.assign("index.php");
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


    $result = mysqli_query($koneksi, "SELECT username FROM $tabel_masuk WHERE username = '$username'");
    if (mysqli_fetch_assoc($result)) {
        echo "<script>
				alert('username sudah terdaftar!')
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
				alert('User baru berhasil ditambahkan!');
                window.location.assign('./index.php');
			  </script>";
        
    } else {
        echo mysqli_error($koneksi);
    }
}
?>
<div id="bg"></div>
<form action="regis.php" method="post">
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
        <button class="btn" type="submit" name="login" id="login">Daftar</button>
    </div>
</form>

<?php
include "template/foot.php";
?>