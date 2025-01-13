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
if(!empty($_REQUEST["uustantsupaari"]) && !empty($_REQUEST["osaleja_nimi1"]) && !empty($_REQUEST["osaleja_nimi2"])) {
    $paring = $yhendus->prepare("INSERT INTO tantsupaari (Paari_nimi, Osaleja_nimi1, Osaleja_nimi2, avalik, punktid) VALUES (?,?,?,?,?)");
    $avalik = 0;
    $punktid = 0;
    $paring->bind_param("ssssi", $_REQUEST["uustantsupaari"], $_REQUEST["osaleja_nimi1"], $_REQUEST["osaleja_nimi2"], $avalik, $punktid);
    $paring->execute();
    header("Location:$_SERVER[PHP_SELF]");
}

//tabeli uuendamine 0 punkt
if(isset($_REQUEST["nulltantsupaari_id"])){
    $paring=$yhendus->prepare("UPDATE tantsupaari set punktid=0 where id=?");
    $paring->bind_param('i',$_REQUEST["nulltantsupaari_id"]);
    $paring->execute();
}

//tantsupaari peidmine
if(isset($_REQUEST["peitmine_id"])){
    $paring=$yhendus->prepare("UPDATE tantsupaari SET avalik=0
where id=?");
    $paring->bind_param('i',$_REQUEST["peitmine_id"]);
    $paring->execute();
}

//tantsupaari näitmine
if(isset($_REQUEST["naitmine_id"])){
    $paring=$yhendus->prepare("UPDATE tantsupaari SET avalik=1
where id=?");
    $paring->bind_param('i',$_REQUEST["naitmine_id"]);
    $paring->execute();
}

?>

    <!DOCTYPE html>
    <html lang="et">
    <head>
        <title>TARpv23 arvestustöö</title>
        <link rel="stylesheet" href="tantsuStyle.css">
    </head>
    <body>
    <h1>Tantsuvõistlus</h1>
    <nav>
        <ul>
            <li><a href="login.php">Exit</a></li>
        </ul>
    </nav>
    <br>
    <form action="?" method="GET">
        <label for="uustantsupaari">Paari nimi:</label>
        <input type="text" name="uustantsupaari" id="uustantsupaari" required><br>
        <br>
        <label for="osaleja_nimi1">Osaleja 1 nimi:</label>
        <input type="text" name="osaleja_nimi1" id="osaleja_nimi1" required><br>
        <br>
        <label for="osaleja_nimi2">Osaleja 2 nimi:</label>
        <input type="text" name="osaleja_nimi2" id="osaleja_nimi2" required><br>
        <br>
        <input type="submit" class='link-button' value="Lisa uus tantsupaari">
    </form>
    <br><br>
    <table border="1">
        <tr>
            <th>PaariNimi</th>
            <th>OsalejaNimi1</th>
            <th>OsalejaNimi2</th>
            <th>Avalik</th>
            <th>Punktid</th>
            <th colspan="4">Haldus</th>

        </tr>
        <?php
        $paring=$yhendus->prepare("SELECT id, Paari_nimi, Osaleja_nimi1, Osaleja_nimi2, avalik, punktid FROM tantsupaari");
        $paring->bind_result($id, $Paari_nimi, $Osaleja_nimi1, $Osaleja_nimi2, $avalik, $punktid);
        $paring->execute();
        while($paring->fetch()){
            echo "<tr>";
            $Paari_nimi=htmlspecialchars($Paari_nimi);
            echo "<td>".$Paari_nimi."</td>";
            echo "<td>".$Osaleja_nimi1."</td>";
            echo "<td>".$Osaleja_nimi2."</td>";
            echo "<td>".$avalik."</td>";
            echo "<td>".$punktid."</td>";
            echo "<td><a href='?nulltantsupaari_id=$id' class='link-button'>Lähtestage punktid</a></td>";
            echo "<td><a href='?kustuta_tantsupaari=$id' class='link-button'>Kustuta konkurss</a></td>";
            ?>
            <?php
            //ava peida nuppud
            $avamistekst="Ava";
            $avamisparam="naitmine_id";
            $avamisseisund="Peidetud";
            if($avalik==1){
                $avamistekst="Peida";
                $avamisparam="peitmine_id";
                $avamisseisund="Näitetud";

            }
            echo "<td><a href='?$avamisparam=$id'class='link-button'>$avamistekst</a></td>";
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