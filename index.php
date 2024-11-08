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
<footer>
    <p>&copy;ValeriaA 2024</p>
    <p>
        <a href="http://jigsaw.w3.org/css-validator/check/referer">
            <img style="border:0;width:88px;height:31px"
                 src="http://jigsaw.w3.org/css-validator/images/vcss"
                 alt="Valid CSS!" />
        </a>
    </p>

</footer>
</body>
</html>
