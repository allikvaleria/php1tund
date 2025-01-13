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
<main>
    <div class="overlay">

        <form action="Sisselogimisvorm/login.inc.php" method="post">
            <div class="con">
                <nav>
                    <ul>
                        <?php
                        if (isset($_SESSION['useruid']) && isset($_SESSION['rolli'])) {
                            if ($_SESSION['rolli'] == 1) {
                                echo '<li><a href="tantsuAdmin.php">Admin</a></li>';
                            } else if ($_SESSION['rolli'] == 0) {
                                echo '<li><a href="tantsuparidHindamine.php">Zurii</a></li>';
                            }
                            echo '<li><a href="Sisselogimisvorm/logout.inc.php">Logi välja</a></li>';
                        } else {
                            echo '<li><a href="login.php">Sisse loogimine</a></li>';
                            echo '<li><a href="signup.php">Registreerimine</a></li>';
                            echo '<li><a href="tavakasutaja.php">Tavakasutaja</a></li>';
                        }
                        ?>
                    </ul>
                </nav>
                <header class="head-form">
                    <h2>Sisse loogimine</h2>
                    <p>Logi siia oma kasutajanime ja parooli abil</p>
                </header>
                <div class="field-set">
                    <span class="input-item"><i class="fa fa-user-circle"></i></span>
                    <input class="form-input" id="txt-input" type="text" name="uid" placeholder="Kasutaja nimi" required>
                </div>
                <div class="field-set">
                    <span class="input-item"><i class="fa fa-key"></i></span>
                    <input class="form-input" type="password" placeholder="Parool" id="pwd" name="pwd" required>
                </div>
                <div class="field-set">
                    <button class="log-in" type="submit" name="submit">Loogi sisse</button><br><br>
                </div>
                <?php
                if (isset($_GET["error"])) {
                    if ($_GET["error"] == "emptyinput") {
                        echo "<p class='error-message'>Täida kõik väljad</p>";
                    }
                    if ($_GET["error"] == "wronglogin") {
                        echo "<p class='error-message'>Vale andmed</p>";
                    }
                }
                ?>
            </div>
        </form>
    </div>
</main>
</body>
</html>
