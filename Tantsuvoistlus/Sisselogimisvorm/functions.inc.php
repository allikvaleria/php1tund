<?php
function emptyInputSignup($name, $email, $username, $pwd, $pwdRepeat)
{
    $result = false;
    if (empty(trim($name)) || empty(trim($email)) || empty(trim($username)) || empty(trim($pwd)) || empty(trim($pwdRepeat)))
    {
        $result = true;
    }
    return $result;
}

function invalidUsername($username)
{
    $result = false;
    if( !preg_match("/^[a-zA-Z0-9]*$/", $username) )
    {
        $result = true;
    }
    return $result;
}

function invalidEmail($email)
{
    $result = false;
    if( !filter_var($email, FILTER_VALIDATE_EMAIL) )
    {
        $result = true;
    }
    return $result;
}

function passwordsMatch($pwd, $pwdRepeat)
{
    $result = false;
    if( $pwd !== $pwdRepeat )
    {
        $result = true;
    }
    return $result;
}

function emailExists($conn, $email)
{
    $sql = "SELECT * FROM users WHERE usersEmail = ?;";

    $stmt = mysqli_stmt_init($conn);

    if( !mysqli_stmt_prepare($stmt, $sql) )
    {
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    mysqli_stmt_close($stmt);

    if( $row = mysqli_fetch_assoc($resultData) )
    {
        return $row;
    }
    else
    {
        return false;
    }
}

function createUser($conn, $name, $email, $username, $pwd)
{
    $sql = "INSERT INTO users (usersName, usersEmail, usersUid, usersPwd, rolli) VALUES (?, ?, ?, ?, 0);";

    $stmt = mysqli_stmt_init($conn);

    if ( !mysqli_stmt_prepare($stmt, $sql) )
    {
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }

    $hashedPassword = password_hash($pwd, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $username, $hashedPassword);

    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../signup.php?error=none");
    exit();
}
function usernameExists($conn, $username)
{
    $sql = "SELECT * FROM users WHERE usersUid = ?;";

    $stmt = mysqli_stmt_init($conn);

    if( !mysqli_stmt_prepare($stmt, $sql) )
    {
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    mysqli_stmt_close($stmt);

    if( $row = mysqli_fetch_assoc($resultData) )
    {
        return $row;
    }
    else
    {
        return false;
    }
}
function emptyInputLogin($username, $pwd)
{
    $result = false;
    if( empty($username) || empty($pwd) )
    {
        $result = true;
    }
    return $result;
}
function loginUser($conn, $username, $pwd)
{
    $usernameExists = usernameExists($conn, $username);

    if ($usernameExists === false) {
        header("location: ../login.php?error=wronglogin");
        exit();
    }

    $hashedPassword = $usernameExists["usersPwd"];
    $checkPassword = password_verify($pwd, $hashedPassword);

    if ($checkPassword === false) {
        header("location: ../login.php?error=wronglogin");
        exit();
    } else if ($checkPassword === true) {
        session_start();
        $_SESSION["userid"] = $usernameExists["usersId"];
        $_SESSION["useruid"] = $usernameExists["usersUid"];
        $_SESSION["rolli"] = $usernameExists["rolli"];
        if ($_SESSION["rolli"] == 0) {
            header("Location: ../tantsuparidHindamine.php");
        } else {
            header("Location: ../tantsuAdmin.php");
        }
        exit();
    }
}