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

//kommentaaride lisamine
if(isset($_REQUEST["uusKomment"])){
    $paring=$yhendus->prepare("UPDATE konkurss SET kommentaarid=CONCAT(kommentaarid,?) WHERE id=?");
    $kommentLisa="\n".$_REQUEST["komment"];
    $paring->bind_param("si", $kommentLisa, $_REQUEST["uusKomment"]);
    $paring->execute();

}

?>

    <!DOCTYPE html>
    <html lang="et">
    <head>
        <title>Jõulu konkursid - Konkurss 1 kaupa</title>
        <link rel="stylesheet" href="konkurssStyle.css">
    </head>
    <body>
    <h1>Jõulu konkursid - Konkurss 1 kaupa</h1>
    <nav>
        <ul>
            <li><a href="konkurssPunktideLisamine.php">Klassitöö</a></li>
            <li><a href="KonkurssAdmin.php">Admin</a></li>
            <li><a href="KonkurssKasutaja.php">Kasutaja</a></li>
        </ul>
    </nav>

    <main>
        <div id="konkurss">
            <h2>Konkurss: </h2>
            <form action="?" method="post">
                <label for="uusKonkurs">Lisa konkurssi nimi</label>
                <input type="text" name="uusKonkurs" id="uusKonkurs">
                <label for="pilt">Pilt</label><br>
                <textarea id="pilt" name="pilt" cols="30" rows="10">Sisesta pildi link</textarea><br>
                <input type="submit" value="OK">

            </form>
            <ul>
                <?php
                $paring = $yhendus->prepare("SELECT id, konkursiNimi FROM konkurss WHERE avalik = 1");
                $paring->bind_result($id, $konkursiNimi);
                $paring->execute();
                while ($paring->fetch()) {
                    echo "<li><a href='?konkurss_id=$id'>$konkursiNimi</a></li>";
                }
                ?>

            </ul>
        </div>

        <div id="konkurss_info">
            <?php
            if (isset($_REQUEST["konkurss_id"])) {
                $konkurss_id = $_REQUEST["konkurss_id"];
                $paring = $yhendus->prepare("SELECT id, konkursiNimi, lisamisaeg, punktid, kommentaarid, avalik, pilt FROM konkurss WHERE id = ?");
                $paring->bind_param("i", $konkurss_id);
                $paring->bind_result($id, $konkurssnimi, $lisamisaeg, $punktid, $kommentaarid, $avalik ,$pilt);
                $paring->execute();
                if ($paring->fetch()) {
                    echo "<p><strong>Konkursi nimi:</strong> $konkurssnimi</p>";
                    echo "<p><strong>Lisamisaeg:</strong> $lisamisaeg</p>";
                    echo "<p><strong>Punktid:</strong> $punktid</p>";
                    echo "<p><strong>Kommentaarid:</strong> $kommentaarid</p>";
                    echo "<p><strong>Konkursi pilt:</strong></p>";
                    echo "<p><img src='$pilt' alt='pilt' width='100px'></p>";
                    ?>

                    <form action="?">
                        <input type="hidden" name="uusKomment" value="<?=$id?>">
                        <input type="text" name="komment" id="komment">

                        <input type="submit" value="Lisa kommentaar">
                    </form>
                    <br>
                    <?php
                    echo "<td><a href='?heakonkurss_id=$id' class='link-button'>Lisa +1 punkt</a></td>";

                    echo "<td><a href='?halvastikonkurss_id=$id' class='link-button'>-1 punkt</a></td>";
                }
            }
            ?>
        </div>
    </main>
    </body>
    </html>

<?php
$yhendus->close();
?>