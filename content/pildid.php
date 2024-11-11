<h2>PHP – Töö pildifailidega</h2>
<a href="https://www.metshein.com/unit/php-pildifailidega-ulesanne-14/">Töö pildifailidega</a>
<form method="post" action="">
    <select name="pildid">
        <option value="">Vali pilt</option>
        <?php
        $kataloog = 'content/img';
        $asukoht = opendir($kataloog);
        while ($rida = readdir($asukoht)) {
            if ($rida != '.' && $rida != '..') {
                echo "<option value='$rida'>$rida</option>\n";
            }
        }
        closedir($asukoht);
        ?>
    </select>
    <input type="submit" value="Vaata">
</form>
<form method="post" action="">
    <input type="submit" name="random_pilt" value="Näita suvalist pilti">
</form>

<?php
if (!empty($_POST['pildid'])) {
    $pilt = $_POST['pildid'];
    $pildi_aadress = 'content/img/' . $pilt;
    $pildi_andmed = getimagesize($pildi_aadress);

    if ($pildi_andmed) {
        $laius = $pildi_andmed[0];
        $korgus = $pildi_andmed[1];
        $formaat = $pildi_andmed[2];
        $max_laius = 120;
        $max_korgus = 90;

        $ratio = ($laius > $korgus) ? $max_laius / $laius : $max_korgus / $korgus;
        $pisi_laius = round($laius * $ratio);
        $pisi_korgus = round($korgus * $ratio);

        echo '<h3>Originaal pildi andmed</h3>';
        echo "Laius: $laius<br>";
        echo "Kõrgus: $korgus<br>";
        echo "Formaat: $formaat<br>";

        echo '<h3>Uue pildi andmed</h3>';
        echo "Arvutamise suhe: $ratio<br>";
        echo "Laius: $pisi_laius<br>";
        echo "Kõrgus: $pisi_korgus<br>";
        echo "<img width='$pisi_laius' height='$pisi_korgus' src='$pildi_aadress'><br>";
    } else {
        echo "Valitud fail ei ole pildifail.";
    }
}
?>
<h2>Ü1. Suvaline pilt – koosta kood, mis valib kataloogist suvalise pildi</h2>
<?php
$kataloog = 'content/img/';
$pildid = array_diff(scandir($kataloog), ['.', '..']); // Получаем список файлов, исключая "." и ".."
$suvalinePilt = $pildid[array_rand($pildid)]; // Выбираем случайный файл из списка

drawPildInfo($suvalinePilt); // Вызываем функцию для отображения данных изображения

function drawPildInfo($pilt_nimi) {
    $pilt = $pilt_nimi;
    $pildi_aadress = 'content/img/' . $pilt;
    $pildi_andmed = getimagesize($pildi_aadress);

    if ($pildi_andmed) {
        $laius = $pildi_andmed[0];
        $korgus = $pildi_andmed[1];
        $formaat = $pildi_andmed[2];
        $max_laius = 120;
        $max_korgus = 90;

        $ratio = ($laius > $korgus) ? $max_laius / $laius : $max_korgus / $korgus;
        $pisi_laius = round($laius * $ratio);
        $pisi_korgus = round($korgus * $ratio);

        echo '<h3>Originaal pildi andmed</h3>';
        echo "Laius: $laius<br>";
        echo "Kõrgus: $korgus<br>";
        echo "Formaat: $formaat<br>";

        echo '<h3>Uue pildi andmed</h3>';
        echo "Arvutamise suhe: $ratio<br>";
        echo "Laius: $pisi_laius<br>";
        echo "Kõrgus: $pisi_korgus<br>";
        echo "<img width='$pisi_laius' height='$pisi_korgus' src='$pildi_aadress'><br>";
    } else {
        echo "Valitud fail ei ole pildifail.";
    }
}
?>

