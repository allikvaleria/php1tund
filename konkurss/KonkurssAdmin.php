<?php
require ('konkursconf.php');
global $yhendus;

//laulu peidmine
if(isset($_REQUEST["peitmine_id"])){
    $paring=$yhendus->prepare("UPDATE konkurss SET avalik=0
where id=?");
    $paring->bind_param('i',$_REQUEST["peitmine_id"]);
    $paring->execute();
}

//laulu näitmine
if(isset($_REQUEST["naitmine_id"])){
    $paring=$yhendus->prepare("UPDATE konkurss SET avalik=1
where id=?");
    $paring->bind_param('i',$_REQUEST["naitmine_id"]);
    $paring->execute();
}

//konkurssi kustutamine
if(isset($_REQUEST["kustuta_konkurss"])){
    $kask=$yhendus->prepare("DELETE FROM konkurss WHERE id=?");
    $kask->bind_param("i",$_REQUEST["kustuta_konkurss"]);
    $kask->execute();
}

// Kommentaari kustutamine
if(isset($_REQUEST["kustuta_komment"])){
    $paring = $yhendus->prepare("UPDATE konkurss SET kommentaarid='' WHERE id=?");
    $paring->bind_param("i", $_REQUEST["kustuta_komment"]);
    $paring->execute();
}

//konkurssi lisamine
if(!empty($_REQUEST["uusKonkurs"])){
    $paring=$yhendus->prepare("INSERT INTO konkurss (konkursiNimi, lisamisAeg) VALUES (?,NOW())");
    $paring->bind_param("s", $_REQUEST["uusKonkurs"]);
    $paring->execute();
    header("Location:$_SERVER[PHP_SELF]");
}

//tabeli uuendamine 0 punkt
if(isset($_REQUEST["nullkonkurss_id"])){
    $paring=$yhendus->prepare("UPDATE konkurss set punktid=0 where id=?");
    $paring->bind_param('i',$_REQUEST["nullkonkurss_id"]);
    $paring->execute();
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