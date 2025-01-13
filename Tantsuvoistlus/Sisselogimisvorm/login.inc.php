<?php
if (isset($_POST["submit"])) {
    $username = $_POST["uid"];
    $pwd = $_POST["pwd"];

    require_once 'functions.inc.php';
    require_once '../tantsuConf.php';
    global $yhendus;
    if (emptyInputLogin($username, $pwd)) {
        header("location: ../login.php?error=emptyinput");
        exit();
    }
    loginUser($yhendus, $username, $pwd);
} else {
    header("location: ../login.php");
    exit();
}