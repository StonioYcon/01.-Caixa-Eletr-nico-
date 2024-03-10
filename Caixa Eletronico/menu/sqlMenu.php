<?php
session_start();

if (!isset($_SESSION["logged_in"]) || $_SESSION['looged_in'] == true) {
    header("location: ..login/index.html");
}else{
    header("location: menu.html");
}
?>