<?php
require('tantsuConf.php');
global $yhendus;

?>

    <!DOCTYPE html>
    <html lang="et">
    <head>
        <title>TARpv23 arvestustöö</title>
        <link rel="stylesheet" href="tantsuStyle.css">
    </head>
    <body>
    <h1>Tantsuvõistlus 'Tavakasutaja'</h1>
    <nav>
        <ul>
            <li><a href="login.php">Exit</a></li>
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
            <th>Hinne 3</th>
            <th>Punktid</th>
        </tr>
        <?php
        // Запрос для выборки только тех пар, у которых "avalik" = 0
        $paring = $yhendus->prepare("SELECT id, Paari_nimi, Osaleja_nimi1, Osaleja_nimi2, avalik, punktid, hinne1, hinne2, hinne3 FROM tantsupaari WHERE avalik = 1");
        $paring->bind_result($id, $Paari_nimi, $Osaleja_nimi1, $Osaleja_nimi2, $avalik, $punktid, $hinne1, $hinne2, $hinne3);
        $paring->execute();
        while ($paring->fetch()) {
            // Calculate punktid as the sum of hinne1, hinne2, and hinne3
            $calculated_punktid = $hinne1 + $hinne2 + $hinne3;

            echo "<tr>";
            $Paari_nimi = htmlspecialchars($Paari_nimi);
            echo "<td>".$Paari_nimi."</td>";
            echo "<td>".$Osaleja_nimi1."</td>";
            echo "<td>".$Osaleja_nimi2."</td>";
            echo "<td>".$avalik."</td>";
            echo "<td>".$hinne1."</td>"; // Display hinne1 but it's not editable
            echo "<td>".$hinne2."</td>"; // Display hinne2 but it's not editable
            echo "<td>".$hinne3."</td>"; // Display hinne3 but it's not editable
            echo "<td>".$calculated_punktid."</td>"; // Display punktid (sum of hinne1 + hinne2 + hinne3)

            echo "</tr>";
        }
        ?>
    </table>
    </body>
    </html>

<?php
$yhendus->close();
?>