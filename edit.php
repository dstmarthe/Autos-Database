<?php
session_start();
require_once "pdo.php";
if ( ! isset($_SESSION['name']) ) {
    die('ACCESS DENIED');
    header('Location: logout.php');
    return;
}





?>