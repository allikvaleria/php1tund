<?php
require ('matkalehtConf.php');
global $yhendus;
//kustutamine
if(isset($_REQUEST["kustuta"])){
    $kask=$yhendus->prepare("DELETE FROM osalejad WHERE id=?");
    $kask->bind_param("i",$_REQUEST["kustuta"]);
    $kask->execute();
}
//tabeli andmete lisamine
if(isset($_REQUEST["nimi"]) && !empty($_REQUEST["nimi"])){
    global $yhendus;
    $paring=$yhendus->prepare("INSERT INTO osalejad(nimi, telefon, pilt, synniaeg)
VALUES (?, ?, ?, ?)");
    //i- integer, s- string
    $paring->bind_param("ssss", $_REQUEST["nimi"], $_REQUEST["telefon"], $_REQUEST["pilt"], $_REQUEST["synniaeg"]);
    $paring->execute();
}
?>
<!DOCTYPE html>
<html lang="et">

<head>
    <title>Matkajad 1 kaupa</title>
    <link rel="stylesheet" href="matkalehtStyle.css">
</head>
<body>
<header>
    <h1>Matkajad</h1>
</header>
<main>
    <div id="matkajad">
        <table>
            <?php
            //tabeli sisu kuvamine
            global $yhendus;
            $paring=$yhendus->prepare("SELECT id, nimi, telefon, pilt, synniaeg FROM osalejad");
            $paring->bind_result($id, $nimi, $telefon, $pilt, $synniaeg);
            $paring->execute();
            echo "<tr>";
            while($paring->fetch()){
                echo "<td><a href='?kasutaja_id=$id'> <img src='$pilt' alt='kasutaja' width='100' height='100'></a></td>";
            }
            echo "</tr>";
            ?>
        </table>
        <br>
        <?php
        echo "<a href='?lisamine=jah'class='link-button'>Lisa matkaja</a>";
        ?>
    </div>
    <div id="info">
        <?php
        //kui klik looma nimele, siis näitame looma info
        if(isset($_REQUEST["kasutaja_id"])) {
            $paring = $yhendus->prepare("SELECT id, nimi, telefon, pilt, synniaeg From osalejad WHERE id = ?");
            $paring->bind_result($id, $nimi, $telefon, $pilt, $synniaeg);
            $paring->bind_param("i", $_REQUEST["kasutaja_id"]);
            $paring->execute();
            //näitame ühe kaupa
            if ($paring->fetch()) {
                echo "<br>Nimi: ".$nimi;
                echo "<br>Telefon: ".$telefon;
                echo "<br><img src='$pilt' width='100px' alt='pilt'>";
                echo "<br>Sünniaeg: ".$synniaeg;
                echo "<br><br><a href='?kustuta=$id'class='link-button'>Kustuta matkaja</a>";
            }
        }
        ?>
    </div>
    <br>
    <?php
    //lisamisvorm, mis avatakse kui vajutatud lisa...
    if(isset($_REQUEST["lisamine"])){
        ?>
        <!--tabeli lisamisVorm-->
        <form action="?" method="post">
            <label for="nimi">Nimi</label>
            <input type="text" id="nimi" name="nimi">
            <br>
            <label for="telefon">Telefon</label>
            <input type="text" id="telefon" name="telefon">
            <br>
            <label for="pilt">Pilt</label>
            <textarea id="pilt" name="pilt" cols="30" rows="10">Pildi link..</textarea>
            <br>
            <label for="synniaeg">Sünniaeg</label>
            <input type="date" id="synniaeg" name="synniaeg">
            <input type="submit" value="OK">
        </form>
        <?php
    }
    ?>
</main>
</body>
</html>
<?php
$yhendus->close();
?>
<footer>
    <?php
    echo "Valeria Allik &copy;";
    echo date('Y');
    ?>
</footer>