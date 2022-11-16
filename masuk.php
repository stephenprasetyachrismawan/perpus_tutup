<?php
    session_start();
    $title = "Login";
    $css = "login.css";
    include "template/head.php";
    include "koneksi.php";
?>
<?php 
if($_GET['sebagai']=="admin"){
        $_SESSION['role'] = "admin";
    }else if($_GET['sebagai']=="anggota"){
        $_SESSION['role'] = "mahasiswa";
    }else if($_GET['sebagai']=="tamu"){
        $_SESSION['role'] = "tamu";
    }else{
        echo '<script>
            alert("Jangan bikin error kamu!");
            window.location.assign("index.php");
            </script>';
    }
    $role = $_SESSION['role'];
if( isset($_COOKIE['id']) && isset($_COOKIE['key']) ) {
	$id = $_COOKIE['id'];
	$key = $_COOKIE['key'];

	// ambil username berdasarkan id
    
        $result = mysqli_query($koneksi, "SELECT username FROM $role WHERE id = $id");
   
	
	$row = mysqli_fetch_assoc($result);

	// cek cookie dan username
	if( $key === hash('sha256', $row['username']) ) {
		$_SESSION['login'] = true;
	}


}

if( isset($_SESSION["login"]) ) {
	header("Location: index.php");
	exit;
}


    
    if(isset($_POST['login'])){

        $tabel_masuk = $_SESSION['role'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $query = "select * from $tabel_masuk where (id = '$username' or username = '$username')";
        $sql = mysqli_query($koneksi, $query);
        $data = mysqli_fetch_array($sql);
        $verif = password_verify($password, $data['password']);
        $sql = mysqli_query($koneksi, $query);
        if(mysqli_num_rows($sql) === 1){
            $_SESSION['username'] = $username;
            $_SESSION['nama'] = $data['nama'];
            if(password_verify($_POST['password'], $data['password'])){
                $_SESSION["login"] = true;
                if( isset($_POST['remember']) ) {
				// buat cookie
				setcookie('id', $data['id'], time()+60);
				setcookie('key', hash('sha256', $data['username']), time()+60);
			}

            }
            header('location: index.php');
            exit;
        }else{
            echo "<div class='alert alert-danger'>Username atau password salah!</div>";
        }
    }
?>
    <div id="bg"></div>
    <form action="masuk.php" method="post">
    <?php 
        if($tabel_masuk == "mahasiswa"){
            echo '<div class="form-field">
            <input type="text" name="username" id="username" placeholder="Username/NIM" required/>
        </div>';
        }else{
            echo '<div class="form-field">
            <input type="text" name="username" id="username" placeholder="Username" required/>
        </div>';
        }

    ?>
        
        <div class="form-field">
            <input type="password" name="password" id="password" placeholder="Password" required/>                         
        </div>
        <span>
            <input type="checkbox" name="remember" id="remember"/>
            <label for="remember" class="label text-white">Remember Me</label>                         
        </span>
        
        <div class="form-field">
            <button class="btn" type="submit" name="login" id="login">Log in</button>
        </div>
    </form>

<?php
    include "template/foot.php";
?>