<?php
session_start();
$title = "Login";
$css = "login.css";
include "template/head.php";
include "koneksi.php";
?>
<?php
if ($_GET['sebagai'] == "admin") {
    $_SESSION['role'] = "admin";
} else if ($_GET['sebagai'] == "mahasiswa") {
    $_SESSION['role'] = "mahasiswa";
} else if ($_GET['sebagai'] == "tamu") {
    $_SESSION['role'] = "tamu";
} else {
    echo '<script>
            swal("Jangan bikin error kamu!", "", "error").then(function(){
                window.location.assign("index.php");
            });
            </script>';
}
if (isset($_COOKIE['id']) && isset($_COOKIE['key'])) {
    $role = $_SESSION['role'];
    $id = $_COOKIE['id'];
    $key = $_COOKIE['key'];
    if ($_GET['sebagai'] == "tamu") {
        $result = mysqli_query($koneksi, "SELECT username FROM $role WHERE username = '$id'");
        $row = mysqli_fetch_assoc($result);

        if ($key === hash('sha256', $row['username'])) {
            $_SESSION['login'] = true;
        }
    } else if ($_GET['sebagai'] == "mahasiswa") {
        $result = mysqli_query($koneksi, "SELECT nim FROM $role WHERE nim = '$id'");
        $row = mysqli_fetch_assoc($result);

        if ($key === hash('sha256', $row['nim'])) {
            $_SESSION['login'] = true;
        }
    }
}

if (isset($_SESSION["login"])) {
    if ($_SESSION['role'] == "admin") {
        header('location: dashboard.php');
        exit;
    } else {
        header('location: index.php');
        exit;
    }
}
if (isset($_POST['login'])) {
    $tabel_masuk = $_SESSION['role'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    if ($tabel_masuk == "mahasiswa") {
        $query = "select * from $tabel_masuk where nim = '$username'";
    } else {
        $query = "select * from $tabel_masuk where username = '$username'";
    }
    $sql = mysqli_query($koneksi, $query);
    $data = mysqli_fetch_array($sql);
    if (mysqli_num_rows($sql) === 1) {
        if (password_verify($_POST['password'], $data['password'])) {
            $_SESSION['username'] = $username;
            $_SESSION['nama'] = $data['nama'];
            $_SESSION["login"] = true;
            if (isset($_POST['remember'])) {
                setcookie('id', $data['id'], time() + 60);
                setcookie('key', hash('sha256', $data['username']), time() + 60);
            }
        } else {
            echo '<script>
            swal("password salah!", "", "error").then(function(){
                window.location.assign("masuk.php?sebagai=' . $tabel_masuk . '");
            });
            </script>';
            exit;
        }
        if ($tabel_masuk == "admin") {
            header('location: dashboard.php');
            exit;
        } else {
            header('location: index.php');
            exit;
        }
    } else {
        echo '<script>
            swal("username salah!", "", "error").then(function(){
                window.location.assign("masuk.php?sebagai=' . $tabel_masuk . '");
            });
            </script>';
    }
}
?>
<div id="bg"></div>
<form action="masuk.php" method="post" name="masuk" id="masuk">
    <?php
    if ($tabel_masuk == "mahasiswa") {
        echo '<div class="form-field">
                <input type="text" name="username" id="username" placeholder="NIM" required/>
            </div>';
    } else {
        echo '<div class="form-field">
                <input type="text" name="username" id="username" placeholder="Username" required/>
            </div>';
    }

    ?>

    <div class="form-field">
        <input type="password" name="password" id="password" placeholder="Password" required />
    </div>
    <span>
        <input type="checkbox" name="remember" id="remember" />
        <label for="remember" class="label text-white">Remember Me</label>
    </span>

    <div class="form-field">
        <button class="btn" type="submit" name="login" id="login">Log in</button>
    </div>
</form>

<?php
include "template/foot.php";
?>