<?php
if( isset($_POST["submit"]) )
{
    $name       = $_POST["name"];
    $email          = $_POST["email"];
    $username       = $_POST["uid"];
    $pwd       = $_POST["pwd"];
    $pwdRepeat = $_POST["pwdrepeat"];

    require_once 'functions.inc.php';
    require_once '../tantsuConf.php';
    global $yhendus;

    if( emptyInputSignup($name, $email, $username, $pwd, $pwdRepeat) !== false )
    {
        header("location: ../signup.php?error=emptyinput");
        exit();
    }
    if( invalidUsername($username) !== false )
    {
        header("location: ../signup.php?error=invalidusername");
        exit();
    }
    if( invalidEmail($email) !== false )
    {
        header("location: ../signup.php?error=invalidemail");
        exit();
    }
    if( passwordsMatch($pwd, $pwdRepeat) !== false )
    {
        header("location: ../signup.php?error=passwordmismatch");
        exit();
    }
    if( usernameExists($yhendus, $username) !== false )
    {
        header("location: ../signup.php?error=usernametaken");
        exit();
    }
    if( emailExists($yhendus, $email) !== false )
    {
        header("location: ../signup.php?error=emailregistered");
        exit();
    }
    createUser($yhendus, $name, $email, $username, $pwd);
}
else {
    header("location: ../signup.php?error=none");
    exit();
}