<?php
require ('conf.php');
//require ('conf2zone.php');
global $yhendus;
//kustutamine
if(isset($_REQUEST["kustuta"])){
    $kask=$yhendus->prepare("DELETE FROM anekdoot WHERE id=?");
    $kask->bind_param("i",$_REQUEST["kustuta"]);
    $kask->execute();
}

//tabeli andmete lisamine
if(isset($_REQUEST["nimetus"]) && !empty($_REQUEST["nimetus"])){

    $paring=$yhendus->prepare("INSERT INTO anekdoot(nimetus, kuupaev, kirjeldus)
VALUES (?, ?, ?)");
    //i- integer, s- string
    $paring->bind_param("ssss", $_REQUEST["loomanimi"], $_REQUEST["varv"],
        $_REQUEST["omanik"], $_REQUEST["pilt"]);
    $paring->execute();
}


//tabeli sisu kuvamine

$paring=$yhendus->prepare("SELECT id, nimetus, kuupaev, kirjeldus FROM anekdoot");
$paring->bind_result($id, $nimetus, $kuupaev, $kirjeldus);
$paring->execute();
?>
    <!doctype html>
    <html lang="et">
    <head>
        <title>Anekdoot andmebaasist</title>
    </head>
    <body>
    <h1>Anekdoot andmebaasist</h1>
    <table>
        <tr>
            <th></th>
            <th>id</th>
            <th>nimetus</th>
            <th>kuupaev</th>
            <th>kirjeldus</th>
        </tr>
        <?php
        while($paring->fetch()){
            echo "<tr>";
            echo "<td><a href='?kustuta=$id'>Kustuta</a></td>";
            echo "<td>".$id."</td>";
            echo "<td>".htmlspecialchars($nimetus)."</td>";
            //htmlspecialchars - ei käivita sisestatud koodi <>
            echo "<td>".htmlspecialchars($kuupaev)."</td>";
            echo "<td>".htmlspecialchars($kirjeldus)."</td>";
            echo "</tr>";
        }
        ?>
    </table>
    <!--tabeli lisamisVorm-->
    <h2>Uue anekdood lisamine</h2>
    <form action="?" method="post">
        <label for="nimetus">Nimetus</label>
        <input type="text" id="nimetus" name="nimetus">
        <br>
        <label for="kuupaev">Kuupaev</label>
        <input type="text" id="kuupaev" name="kuupaev">
        <br>
        <label for="kirjeldus">Kirjeldus</label>
        <input type="text" id="kirjeldus" name="kirjeldus">
        sisesta pildi link
    </textarea>
        <input type="submit" value="OK">
    </form>
    <footer>
        <?php
        include('footer.php');
        ?>
        <br>
        <a href="https://valeriaallik23.thkit.ee/wp/blog/2024/11/29/mobiilimalli-jargi-veebilehestik/">Konspekt wordpress'is</a>
    </footer>


    </body>
    </html>
<?php
$yhendus->close();
