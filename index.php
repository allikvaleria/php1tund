<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>PHP tunnitööd</title>
</head>
<body>
<?php
//päis
include('header.php');
?>

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
        include('content/kodu.php');
    }
    ?>
</section>
<?php
include('footer.php');
?>
</body>
</html>
