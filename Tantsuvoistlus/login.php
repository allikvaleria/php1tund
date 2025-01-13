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
                echo '<li><a href="tantsuparidHindamine.php">Zurii</a></li>';
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
    <h2>Log in</h2>
    <div class="signup-form">
        <form action="Sisselogimisvorm/login.inc.php" method="post">
            <input type="text" name="uid" placeholder="Username/Email..."> <br><br>
            <input type="password" name="pwd" placeholder="Password..."> <br><br>
            <button type="submit" name="submit">Log In</button>
        </form>
    </div>
</section>
</body>
</html>