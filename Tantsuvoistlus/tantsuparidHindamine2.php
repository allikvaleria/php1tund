<?php
require('tantsuConf.php');
global $yhendus;

// Сброс баллов на начальное значение (по запросу)
if (isset($_REQUEST["nulltantsupaari_id"])) {
    $paring = $yhendus->prepare("UPDATE tantsupaari SET punktid = 0 WHERE id = ?");
    $paring->bind_param('i', $_REQUEST["nulltantsupaari_id"]);
    $paring->execute();
}

// Изменение баллов на выбранное значение
if (isset($_REQUEST["muuda_punktid_id"]) && isset($_REQUEST["punktid"])) {
    $paring = $yhendus->prepare("UPDATE tantsupaari SET punktid = ? WHERE id = ?");
    $paring->bind_param('ii', $_REQUEST["punktid"], $_REQUEST["muuda_punktid_id"]);
    $paring->execute();
}

// Изменение оценок hinne2
if (isset($_REQUEST["muuda_hinne_id"]) && isset($_REQUEST["hinne2"])) {
    $paring = $yhendus->prepare("UPDATE tantsupaari SET hinne2 = ? WHERE id = ?");
    $paring->bind_param('ii', $_REQUEST["hinne2"], $_REQUEST["muuda_hinne_id"]);
    $paring->execute();
}

// Проверка, есть ли хотя бы одна пара с punktid = 0
$paring_check = $yhendus->prepare("SELECT COUNT(*) FROM tantsupaari WHERE hinne2 = 0");
$paring_check->bind_result($count_zero_points);
$paring_check->execute();
$paring_check->fetch();
$paring_check->close();

?>

    <!DOCTYPE html>
    <html lang="et">
    <head>
        <title>TARpv23 arvestustöö</title>
        <link rel="stylesheet" href="tantsuStyle.css">
    </head>
    <body>
    <h1>Tantsuvõistlus 'hinne 2'</h1>
    <nav>
        <ul>
            <?php if ($count_zero_points == 0): ?>
                <li><a href="tantsuparidHindamine3.php">Hinne 3</a></li>
            <?php endif; ?>
        </ul>
    </nav>
    <br><br>
    <table border="1">
        <tr>
            <th>PaariNimi</th>
            <th>OsalejaNimi1</th>
            <th>OsalejaNimi2</th>
            <th>Avalik</th>
            <th>Hinne 1</th>
            <th>Hinne 2</th>
            <th colspan="4">Haldus</th>
        </tr>
        <?php
        // Запрос для выборки только тех пар, у которых "avalik" = 0
        $paring = $yhendus->prepare("SELECT id, Paari_nimi, Osaleja_nimi1, Osaleja_nimi2, avalik, punktid, hinne1, hinne2 FROM tantsupaari WHERE avalik = 0");
        $paring->bind_result($id, $Paari_nimi, $Osaleja_nimi1, $Osaleja_nimi2, $avalik, $punktid, $hinne1, $hinne2);
        $paring->execute();
        while ($paring->fetch()) {
            echo "<tr>";
            $Paari_nimi = htmlspecialchars($Paari_nimi);
            echo "<td>".$Paari_nimi."</td>";
            echo "<td>".$Osaleja_nimi1."</td>";
            echo "<td>".$Osaleja_nimi2."</td>";
            echo "<td>".$avalik."</td>";
            echo "<td>".$hinne1."</td>"; // Display hinne1 but it's not editable
            echo "<td>".$hinne2."</td>"; // Display hinne2, which is editable



            // Форма для изменения оценки hinne2 (hinne1 не меняется)
            echo "<td>";
            echo "<form action='' method='GET'>";
            echo "<input type='hidden' name='muuda_hinne_id' value='$id'>";
            echo "Hinne 2: <input type='number' name='hinne2' value='$hinne2' min='0' max='5'> ";
            echo "<input type='submit' class='link-button' value='Muuda hinne'>";
            echo "</form>";
            echo "</td>";
        }
        ?>
    </table>
    </body>
    </html>

<?php
$yhendus->close();
?>