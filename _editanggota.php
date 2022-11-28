<?php
if ($_GET['id_mhs']) {
    $_SESSION['id_anggota'] = $_GET['id_mhs'];
    $_SESSION['tabel'] = "mahasiswa";
} elseif ($_GET['id_tm']) {
    $_SESSION['id_anggota'] = $_GET['id_tm'];
    $_SESSION['tabel'] = "tamu";
}

if(isset($_SESSION['id_anggota'])){
    $id = $_SESSION['id_anggota'];
    $tabel = $_SESSION['tabel'];
    if($tabel=='mahasiswa') $sql = "SELECT * FROM $tabel WHERE nim = '$id'";
    else $sql = "SELECT * FROM $tabel WHERE username='$id'";
    $data = mysqli_fetch_array(mysqli_query($koneksi, $sql));
}

if (isset($_POST['editanggota'])) {
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $konpass = $_POST['konpass'];
    if (!password_verify($konpass, $password)) {
        echo "<script>
                    swal('Password Baru Tidak Sama!', '', 'error').then(function(){
                        window.location.assign('dashboard.php?page=tmahasiswa');
                    })
                </script>";
        exit;
    }
    $id = $_SESSION['id_anggota'];
    $tabel = $_SESSION['tabel'];
    $username = $_POST['username'];
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $nohp = $_POST['nohp'];
    $alamat = $_POST['alamat'];

    if ($id != $username) {
        $result = mysqli_query($koneksi, "SELECT nim FROM mahasiswa WHERE nim = '$username'");
        if (mysqli_fetch_assoc($result)) {
            echo "<script>
                        swal('NIM Sudah Terdaftar!', '', 'error').then(function(){
                            window.location.assign('dashboard.php?page=tmahasiswa');
                        })
                      </script>";
            return false;
        }
    } else {
        if($tabel=='mahasiswa' && !empty($konpass)) $query = "UPDATE $tabel SET nim = '$username', nama = '$nama', password = '$password', email = '$email', no_hp = '$nohp', alamat = '$alamat' WHERE nim = '$id'";
        elseif($tabel=='mahasiswa' && empty($konpass)) $query = "UPDATE $tabel SET nim = '$username', nama = '$nama', email = '$email', no_hp = '$nohp', alamat = '$alamat' WHERE nim = '$id'";
        elseif($tabel=='tamu' && !empty($konpass)) $query = "UPDATE $tabel SET username = '$username', nama = '$nama', password = '$password', email = '$email', no_hp = '$nohp', alamat = '$alamat' WHERE username = '$id'";
        elseif($tabel=='tamu' && empty($konpass)) $query = "UPDATE $tabel SET username = '$username', nama = '$nama', email = '$email', no_hp = '$nohp', alamat = '$alamat' WHERE username = '$id'";
        $sql = mysqli_query($koneksi, $query);
    }

    if ($sql) {
        echo "<script>
                    swal('Data User Berhasil Diedit!', '', 'success').then(function(){
                        window.location.assign('dashboard.php?page=viewanggota');
                    })
                  </script>";
    } else {
        echo "<script>
                    swal('Data User Gagal Diedit!', '', 'error').then(function(){
                        window.location.assign('dashboard.php?page=viewanggota');
                    })
                  </script>";
    }
}
?>
<div class="container">
    <div class="card" style="margin-top: 100px;">
        <div class="card-body">
            <h4 class="text-center text-capitalize">Edit Data Anggota <?php echo $_SESSION['tabel'] ?></h4>
            <form action="dashboard.php?page=editanggota" method="post" name="edit" id="edit">
                <?php if ($_SESSION['tabel'] == "mahasiswa") echo "<div class='form-field'>
                        <label>NIM:</label>
                        <input type='text' name='username' id='username' class='form-control' value ='".$data['nim']."' placeholder='Masukan NIM' required />
                    </div>";
                else echo '<div class="form-field">
                        <label>Username:</label>
                        <input type="text" name="username" id="username" class="form-control" value ="'.$data['username'].'" placeholder="Masukan Username" required />
                    </div>';
                ?>
                <div class="form-group">
                    <label>Nama:</label>
                    <input type="text" name="nama" id="nama" class="form-control" value="<?php echo $data['nama'] ?>" placeholder="Masukan Nama" required />
                </div>


                <div class="form-group">
                    <label>Email:</label>
                    <input type="email" name="email" id="email" class="form-control" value="<?php echo $data['email'] ?>" placeholder="Masukan Email" required />
                </div>

                <div class="form-group">
                    <label>No HP:</label>
                    <input type="text" name="nohp" id="nohp" class="form-control" value="<?php echo $data['no_hp'] ?>" placeholder="Masukan No HP" />
                </div>

                <div class="form-group">
                    <label>Alamat:</label>
                    <textarea name="alamat" id="alamat" cols="30" rows="10" class="form-control" placeholder="Masukan Alamat"><?php echo $data['alamat'] ?></textarea>
                </div>

                <div class="form-group">
                    <label>Password:</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Masukan Password Baru" />
                </div>

                <div class="form-group">
                    <label>Konfirmasi Password:</label>
                    <input type="password" name="konpass" id="konpass" class="form-control" placeholder="Konfirmasi Password Baru" />
                </div>
                <button class="btn btn-primary" type="submit" name="editanggota" id="editanggota">Edit</button>
            </form>
        </div>
    </div>
</div>