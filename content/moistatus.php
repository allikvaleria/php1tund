<?php
echo "<h2>Mõistatus. Euroopa riik</h2>";
// 6 подсказок при помощи тесктовых функций
// выводить списком <ul> / <ol>
echo "<bt>";
$moistatustext='Millise riigi lipp peegeldab "meie järvede sinist ja meie talve valget lund"?';
echo $moistatustext;
echo "<br>";
$riik='Soome';
// esimene täht
echo "<ol>";
echo "<li>Esimene täht riigis on - ".substr($riik,0,1)."</li>";

// teksti pikkus
echo "<br>";

echo "<li>Teksti pikkus on - ".strlen($riik)."</li>";

// leiame on positsiooni
echo "<br>";
$otsing2='m';

echo "<li>'M' asukoht sõnas on - ".strpos($riik, $otsing2)."</li>";

echo "<br>";
// massiv algab nullist

echo "<li>2.täht - ".$riik[1]."</li>";
echo "<br>";
echo "<li>4.täht - ".$riik[4]."</li>";

echo "<br>";
//str_replace()
$otsi = array('S', 'm');
$asenda = array('*', '*');
echo "<li>Sisesta vahelejäänud tähed - ".str_replace($otsi, $asenda, $riik)."</li>";
echo "</ol>";
?>
<div id="vastus">
    <h2>Vastus</h2>
    <form method="post" action="">
        Sisesta sinu vastus
        <input type="text" name="euriik" placeholder="">
        <input type="submit" value="OK">
    </form>
    <?php
    if (isset($_REQUEST["euriik"])){
        if(empty($_REQUEST["euriik"])){
            echo "Sisesta sinu vastus!";
        }
        else{
            if ($_REQUEST["euriik"]=="Soome"){
                echo "Õige!";
            }else{
                echo "Vale!";
            }
        }
    }
highlight_file('moistatus.php');
    ?>
</div>
