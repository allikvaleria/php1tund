<?php
require ('tantsuConf.php');
global $yhendus;

//tantsupaari kustutamine
if(isset($_REQUEST["kustuta_tantsupaari"])){
    $kask=$yhendus->prepare("DELETE FROM tantsupaari WHERE id=?");
    $kask->bind_param("i",$_REQUEST["kustuta_tantsupaari"]);
    $kask->execute();
}

//tantsupaari lisamine
if(!empty($_REQUEST["uustantsupaari"])){
    $paring=$yhendus->prepare("INSERT INTO tantsupaari (Paari_nimi, Osaleja_nimi1, Osaleja_nimi2 ) VALUES (?,?,?");
    $paring->bind_param("s", $_REQUEST["uustantsupaari"]);
    $paring->execute();
    header("Location:$_SERVER[PHP_SELF]");
}

?>

    <!DOCTYPE html>
    <html lang="et">
    <head>
        <title>TARpv23 isseseisevtöö</title>
        <link rel="stylesheet" href="konkurssStyle.css">
    </head>
    <body>
    <h1>Jõulu konkursid - Admin</h1>
    <nav>
        <ul>
            <li><a href="KonkurssKasutaja.php">Kasutaja</a></li>
            <li><a href="konkurssPunktideLisamine.php">Klassitöö</a></li>
            <li><a href="konkurs1kaupa.php">Konkurs 1 kaupa</a></li>

        </ul>
    </nav>
    <br>
    <form action="?">
        <label for="uusKonkurs">Lisa konkurssi nimi</label>
        <input type="text" name="uusKonkurs" id="uusKonkurs">
        <input type="submit" value="OK">

    </form>
    <br>
    <table border="1">
        <tr>
            <th>KonkursiNimi</th>
            <th>LisamisAeg</th>
            <th>Punktid</th>
            <th>Avalik</th>
            <th colspan="2">Kommentaarid</th>
            <th colspan="4">Haldus</th>

        </tr>
        <?php
        $paring=$yhendus->prepare("SELECT id, konkursiNimi, lisamisAeg, punktid, kommentaarid, avalik FROM konkurss");
        $paring->bind_result($id, $konkursiNimi, $lisamisAeg, $punktid, $kommentaarid, $avalik);
        $paring->execute();
        while($paring->fetch()){
            echo "<tr>";
            $konkursiNimi=htmlspecialchars($konkursiNimi);
            $kommentaarid=nl2br(htmlspecialchars($kommentaarid));
            echo "<td>".$konkursiNimi."</td>";
            echo "<td>".$lisamisAeg."</td>";
            echo "<td>".$punktid."</td>";
            echo "<td>".$avalik."</td>";
            echo "<td>".$kommentaarid."</td>";
            ?>
            <td>
                <form action="?">
                    <input type="hidden" name="kustuta_komment" value="<?=$id?>">
                    <input type="submit" value="Kustuta kommentaar">
                </form>
            </td>
            <?php
            echo "<td><a href='?nullkonkurss_id=$id' class='link-button'>Lähtestage punktid</a></td>";
            echo "<td><a href='?kustuta_konkurss=$id' class='link-button'>Kustuta konkurss</a></td>";
            //ava peida nuppud
            $avamistekst="Ava";
            $avamisparam="naitmine_id";
            $avamisseisund="Peidetud";
            if($avalik==1){
                $avamistekst="Peida";
                $avamisparam="peitmine_id";
                $avamisseisund="Näitetud";

            }
            echo "<td><a href='?$avamisparam=$id'>$avamistekst</a></td>";
            echo"<td>$avamisseisund</td>";
            echo "</tr>";
        }
        ?>
    </table>
    </body>
    </html>
<?php
$yhendus->close();
?>