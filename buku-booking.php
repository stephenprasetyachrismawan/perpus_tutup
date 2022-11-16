<?php
    $title = 'Pinjam Buku';
    $style = 'style.css';
    session_start();
    include 'template/head.php';
    include("koneksi.php"); 

    if(!isset($_SESSION['username'])){
        echo "<script>
        alert('Silahkan Masuk ke Akun Anda Dulu!');
        window.location.assign('index.php');
        </script>";
    }

    function cek($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    if(isset($_POST["submit"])){
        $nip = cek($_POST["nip"]);
        $nama = cek($_POST["nama"]);
        $tgl_lahir = cek($_POST["tgl_lahir"]);
        $alamat = cek($_POST["alamat"]);
        $divisi = cek($_POST["divisi"]);
            
        $sql = "insert into pegawai (NIP, nama, tanggal_lahir, alamat, divisi, foto) values
                ('$nip','$nama','$tgl_lahir','$alamat','$divisi','$foto')";
        $status = mysqli_query($con, $sql);
        if($status==1){
            header("Location: index.php");
        }else if($status==0){
            echo "<div class='alert alert-danger'>Data gagal disimpan!</div>";
        }
    }
?>
<!--
<div class="container">
    <h4 class="text-center mt-5">Permintaan Pinjam Buku</h4>
    <form action="<?php $_SERVER['PHP_SELF']?>" method="POST">
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <table>
                <tr class="form-group">
                    <td></td>
                    <td><input type="text" name="nip" id="nip" class="form-control" placeholder="Masukan NIP" required></td>
                </tr>
                <tr class="form-group">
                    <td>Nama</td>
                    <td><input type="text" name="nama" id="nama" class="form-control" placeholder="Masukan Nama" required></td>
                </tr>
                <tr class="form-group">
                    <td>Tanggal Lahir</td>
                <td><input type="date" name="tgl_lahir" id="tgl_lahir"  class="form-control" required></td>
                </tr>
                <tr class="form-group">
                    <td>Alamat</td>
                    <td><textarea name="alamat" id="alamat" class="form-control" cols="30" rows="10" placeholder="Masukan Alamat" required></textarea></td>
                </tr>
                <tr class="form-group">
                    <td>Divisi</td>
                    <td><select name="divisi" id="divisi" class="form-control" required>
                        <option value="" selected>-- Masukan Divisi --</option>
                        <option value="IT">IT</option>
                        <option value="HRD">HRD</option>
                        <option value="Umum">Umum</option>
                    </select></td>
                </tr>
                <tr>
                    <td colspan="2" class="text-center"><input type="submit" name="submit" id="submit" value="Submit" class="btn btn-primary me-5">
                    <input type="reset" name="reset" id="reset" value="Reset" class="btn border border-primary"></td>
                </tr>
                </table>
            </div>
        </div>
    </form>
</div>
    -->
<?php
    include 'template/foot.php'
?>