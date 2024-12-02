<?php
require ('konkursconf.php');
global $yhendus;

//konkurssi lisamine
if(!empty($_REQUEST["uusKonkurs"])){
    $paring=$yhendus->prepare("INSERT INTO konkurss (konkursiNimi, lisamisAeg) VALUES (?,NOW())");
    $paring->bind_param("s", $_REQUEST["uusKonkurs"]);
    $paring->execute();
    header("Location:$_SERVER[PHP_SELF]");
}
//kommentaaride lisamine
if(isset($_REQUEST["uusKomment"])){
    $paring=$yhendus->prepare("UPDATE konkurss SET kommentaarid=CONCAT(kommentaarid,?) WHERE id=?");
    $kommentLisa="\n".$_REQUEST["komment"];
    $paring->bind_param("si", $kommentLisa, $_REQUEST["uusKomment"]);
    $paring->execute();
}

//tabeli uuendamine +1 punkt
if(isset($_REQUEST["heakonkurss_id"])){
    $paring=$yhendus->prepare("UPDATE konkurss SET punktid=punktid+1
where id=?");
    $paring->bind_param('i',$_REQUEST["heakonkurss_id"]);
    $paring->execute();
}

//tabeli uuendamine -1 punkt
if(isset($_REQUEST["halvastikonkurss_id"])){
    $paring=$yhendus->prepare("UPDATE konkurss set punktid=punktid-1 where id=?");
    $paring->bind_param('i',$_REQUEST["halvastikonkurss_id"]);
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
    <h1>Jõulu konkursid - Kasutaja</h1>
    <nav>
        <ul>
            <li><a href="KonkurssAdmin.php">Admin</a></li>
            <li><a href="konkurssPunktideLisamine.php">Klassitöö</a></li>
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
            <th colspan="2">Kommentaarid</th>
            <th colspan="4">Haldus</th>
        </tr>
        <?php
        $paring=$yhendus->prepare("SELECT id, konkursiNimi, lisamisAeg, punktid, kommentaarid FROM konkurss where avalik=1");
        $paring->bind_result($id, $konkursiNimi, $lisamisAeg, $punktid, $kommentaarid);
        $paring->execute();
        while($paring->fetch()){
            echo "<tr>";
            $konkursiNimi=htmlspecialchars($konkursiNimi);
            $kommentaarid=nl2br(htmlspecialchars($kommentaarid));
            echo "<td>".$konkursiNimi."</td>";
            echo "<td>".$lisamisAeg."</td>";
            echo "<td>".$punktid."</td>";
            echo "<td>".$kommentaarid."</td>";
            ?>
            <td>
                <form action="?">
                    <input type="hidden" name="uusKomment" value="<?=$id?>">
                    <input type="text" name="komment" id="komment">
                    <input type="submit" value="Lisa kommentaar">
                </form>
            </td>
            <?php
            echo "<td><a href='?heakonkurss_id=$id' class='link-button'>Lisa +1 punkt</a></td>";
            echo "<td><a href='?halvastikonkurss_id=$id' class='link-button'>-1 punkt</a></td>";
            echo "</tr>";
        }
        ?>
    </table>
    </body>
    </html>
<?php
$yhendus->close();
?>