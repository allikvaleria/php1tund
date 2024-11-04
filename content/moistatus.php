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
echo "</ol>";
// teksti pikkus
echo "<br>";
echo "<ul>";
echo "<li>Teksti pikkus on - ".strlen($riik)."</li>";
echo "</ul>";
// leiame on positsiooni
echo "<br>";
$otsing2='m';
echo "<ul>";
echo "<li>'M' asukoht sõnas on - ".strpos($riik, $otsing2)."</li>";
echo "</ul>";
echo "<br>";
// massiv algab nullist
echo "<ul>";
echo "<li>2.täht - ".$riik[1]."</li>";
echo "<br>";
echo "<li>4.täht - ".$riik[4]."</li>";
echo "</ul>";

//str_replace()