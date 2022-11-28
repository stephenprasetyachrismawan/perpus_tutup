<?php
    session_start();
    if(isset($_SESSION['username']) && $_SESSION['role']=="admin") header('location: dashboard.php');
    $title = "Home";
    $css = "style.css";
    include "template/head.php";
    include "template/nav.php";
    include "template/carousel.php";
    include "template/footW.php";
?>
