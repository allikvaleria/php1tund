<?php
require("abifunktsioonid.php");

//insert kauba - Tühjad kaubad ja kaubagrupid ei tohi lisada.
if (isset($_REQUEST["kaubalisamine"])) {
    if (!empty($_REQUEST["nimetus"]) && !empty($_REQUEST["kaubagrupi_id"]) && !empty($_REQUEST["hind"])) {
        lisaKaup($_REQUEST["nimetus"], $_REQUEST["kaubagrupi_id"], $_REQUEST["hind"]);
        header("Location: index.php");
        exit();
    } else {
        echo "<p>Palun täitke kõik väljad!</p>";
    }
}

//insert kaubagrupi - Tühjad kaubad ja kaubagrupid ei tohi lisada.
if (isset($_REQUEST["grupilisamine"])) {
    if (!empty($_REQUEST["uuegrupinimi"])) {
        lisaGrupp($_REQUEST["uuegrupinimi"]);
        header("Location: kaubahaldus.php");
        exit();
    } else {
        echo "<p>Sisestage kaubagrupi nimi!</p>";
    }
}

// Funktsioon kontrollib, kas grupp juba eksisteerib
function kysiGrupp($grupinimi) {
    global $yhendus;
    $kask = $yhendus->prepare("SELECT id FROM kaubagrupid WHERE grupinimi = ?");
    $kask->bind_param("s", $grupinimi);
    $kask->execute();
    $tulemus = $kask->get_result();
    return $tulemus->num_rows > 0;
}

//delete kauba
if(isSet($_REQUEST["kustutusid"])){
    kustutaKaup($_REQUEST["kustutusid"]);
}

//update kauba
if(isSet($_REQUEST["muutmine"])){
    muudaKaup($_REQUEST["muudetudid"], $_REQUEST["nimetus"],
        $_REQUEST["kaubagrupi_id"], $_REQUEST["hind"]);  }
$kaubad=kysiKaupadeAndmed();

//kaupade sorteerimine
$sorttulp="nimetus";
$otsisona="";
if(isSet($_REQUEST["sort"])){
    $sorttulp=$_REQUEST["sort"];
}

//otsi sõna järgi
if(isSet($_REQUEST["otsisona"])){
    $otsisona=$_REQUEST["otsisona"];
}
$kaubad=kysiKaupadeAndmed($sorttulp, $otsisona);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="et">
<head>
    <title>Kaupade leht - CRUD operatsioonid</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="kaubadStyle.css">
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />  </head>
<body>

<?php
include('header.php');
?>

<div id="kl">
<form action="index.php">
    <h2>Kauba lisamine</h2>
    <dl>
        <dt>Nimetus:</dt>
        <dd><input type="text" name="nimetus" /></dd>
        <dt>Kaubagrupp:</dt>
        <dd><?php
            echo looRippMenyy("SELECT id, grupinimi FROM kaubagrupid",   "kaubagrupi_id");
            ?>
        </dd>
        <dt>Hind:</dt>
        <dd><input type="text" name="hind" /></dd>
    </dl>
    <input type="submit" name="kaubalisamine" id="kaubalisamine" value="Lisa kaup" />  <h2>Grupi lisamine</h2>
    <input type="text" name="uuegrupinimi" />
    <input type="submit" name="grupilisamine" id="grupilisamine" value="Lisa grupp" />
</form>
</div>

<form action="index.php">
    <br>
    Otsi: <input type="text" name="otsisona" />
    <br><br>
    <table>
        <tr>
            <th>Haldus</th>
            <th>Nimetus</th>
            <th>Kaubagrupp</th>
            <th>Hind</th>
        </tr>
        <?php foreach($kaubad as $kaup): ?>
            <tr>
                <?php if(isSet($_REQUEST["muutmisid"]) &&
                    intval($_REQUEST["muutmisid"])==$kaup->id): ?>  <td>
                    <input type="submit" name="muutmine" value="Muuda" />  <input type="submit" name="katkestus" value="Katkesta" />  <input type="hidden" name="muudetudid" value="<?=$kaup->id ?>" />  </td>
                    <td><input type="text" name="nimetus" value="<?=$kaup->nimetus ?>" /></td>  <td><?php
                        echo looRippMenyy("SELECT id, grupinimi FROM kaubagrupid",   "kaubagrupi_id", $kaup->kaubagrupi_id);  ?></td>
                    <td><input type="text" name="hind" value="<?=$kaup->hind ?>" /></td>  <?php else: ?>
                    <td><a href="index.php?kustutusid=<?=$kaup->id ?>" class='link-button' onclick="return confirm('Kas ikka soovid kustutada?')">Kustutada</a> <br> <br> <a href="index.php?muutmisid=<?=$kaup->id ?>" class='link-button'>Muuta</a>  </td>
                    <td><?=$kaup->nimetus ?></td>
                    <td><?=$kaup->grupinimi ?></td>
                    <td><?=$kaup->hind ?></td>
                <?php endif ?>
            </tr>
        <?php endforeach; ?>
    </table>
</form>

<?php
include('footer.php');
?>

</body>
</html>