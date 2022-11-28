<?php
if (isset($_SESSION['role'])) {
    if (!$_SESSION['role'] == "admin") {
        header("location: index.php");
    }
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
                    window.location.assign('dashboard.php?page=tmahasiswa');
                })
            </script>";
        exit;
    }
    $result = mysqli_query($koneksi, "SELECT nim FROM mahasiswa WHERE nim = '$username'");
    if (mysqli_fetch_assoc($result)) {
        echo "<script>
                swal('NIM Sudah Terdaftar!', '', 'error').then(function(){
                    window.location.assign('dashboard.php?page=tmahasiswa');
                })
		      </script>";
        return false;
    } else {
        $query = "insert into mahasiswa values ('', '$username', '$nama', '$password', '$email', '$nohp', '$alamat')";
        $sql = mysqli_query($koneksi, $query);
    }

    if (mysqli_affected_rows($koneksi) > 0) {
        echo "<script>
                swal('User Baru Berhasil Ditambahkan!', '', 'success').then(function(){
                    window.location.assign('dashboard.php?page=viewanggota');
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
                <div class='form-field'>
                    <label>NIM:</label>
                    <input type='text' name='username' id='username' class='form-control' placeholder='Masukan NIM' required />
                </div>
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
