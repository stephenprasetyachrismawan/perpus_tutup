<?php
session_start();
$title = "Home";
$css = "style.css";
if (isset($_SESSION['username']) && ($_SESSION['role'] == "admin")) {
    header('location: dashboard.php');
    exit;
}
include "template/head.php";
include "template/nav.php";
include "template/carousel.php";
include "template/footW.php";
