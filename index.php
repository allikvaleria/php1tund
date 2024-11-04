<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>PHP tunnitööd</title>
</head>
<body>
<header>
    <h1>PHP tunnitööd</h1>
    <link rel="stylesheet" href="style/newstyle.css">
</header>
<?php
// navigeerimis menüü
    include('nav.php');
?>
<section>
    <?php
    if(isset($_GET["leht"]))
    {
        include('content/'.$_GET["leht"]);
    }
    else
    {
        echo "Tere tulemast";
    }
    ?>
</section>
<?php
    echo "Valeria Allik &copy; ";
    echo date('Y');
?>
</body>
</html>
