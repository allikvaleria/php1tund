<?php
session_start();
?>
<!DOCTYPE html>
<html lang="et">
<head>
    <title>TARpv23 loginvorm</title>
    <link rel="stylesheet" href="loginVormStyle.css">
</head>
<body>
<nav>
    <ul>
        <?php
        if (isset($_SESSION['useruid']) && isset($_SESSION['rolli'])) {
            if ($_SESSION['rolli'] == 1) {
                echo '<li><a href="tantsuAdmin.php">Admin</a></li>';
            } else if ($_SESSION['rolli'] == 0) {
                echo '<li><a href="tantsuparidHindamine.php">Kasutaja</a></li>';
            }
            echo '<li><a href="Sisselogimisvorm/logout.inc.php">Logi välja (' . htmlspecialchars($_SESSION['useruid']) . ')</a></li>';
        } else {
            echo '<li><a href="login.php">Sisse loogimine</a></li>';
            echo '<li><a href="signup.php">Registreerimine</a></li>';
            echo '<li><a href="tavakasutaja.php">Tavakasutaja</a></li>';
        }
        ?>
    </ul>
</nav>
<section class="signup-form">
    <h2>Sign up</h2>
    <div class="signup-form">
        <form action="Sisselogimisvorm/signup.inc.php" method="post">
            <input type="text" name="name" placeholder="Full name..."> <br><br>
            <input type="text" name="email" placeholder="Email..."> <br><br>
            <input type="text" name="uid" placeholder="Username..."> <br><br>
            <input type="password" name="pwd" placeholder="Password..."> <br><br>
            <input type="password" name="pwdrepeat" placeholder="Repeat password..."> <br><br>
            <button type="submit" name="submit">Sign Up</button>
        </form>
    </div>
</section>
</body>
<?php


 if(isset($_GET["error"])){
     if($_GET["error"] == "emptyinput"){
         echo "<p class='error'>Fill in all the fields!</p>";
     }
     else if($_GET["error"] == "invaliduid"){
         echo "<p class='error'>Choose a proper username!</p>";
     }
     else if($_GET["error"] == "invalidemail"){
         echo "<p class='error'>Choose a proper email!</p>";
     }
     else if($_GET["error"] == "passwordsdontmatch"){
         echo "<p class='error'>Passwords do not match!</p>";
     }
     else if($_GET["error"] == "stmtfailed"){
         echo "<p class='error'>Something went wrong, try again!</p>";
     }
     else if($_GET["error"] == "usertaken"){
         echo "<p class='error'>Username already taken!</p>";
     }
     else if($_GET["error"] == "none"){
         echo "<p class='success'>Signed up successfully!</p>";
     }
 }
?>