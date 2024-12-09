<?php
require("abifunktsioonid.php");
$sorttulp="nimetus";
$otsisona="";
if(isSet($_REQUEST["sort"])){
    $sorttulp=$_REQUEST["sort"];
}
if(isSet($_REQUEST["otsisona"])){
    $otsisona=$_REQUEST["otsisona"];
}
$kaubad=kysiKaupadeAndmed($sorttulp, $otsisona);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="et">
<head>
    <title>Kaupade leht</title>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />  </head>
<body>
<form action="kaubaotsing.php">
    Otsi: <input type="text" name="otsisona" />
    <table>
        <tr>
            <th><a href="kaubaotsing.php?sort=nimetus">Nimetus</a></th>  <th><a href="kaubaotsing.php?sort=grupinimi">Kaubagrupp</a></th>  <th><a href="kaubaotsing.php?sort=hind">Hind</a></th>
        </tr>
        <?php foreach($kaubad as $kaup): ?>
            <tr>
                <td><?=$kaup->nimetus ?></td>
                <td><?=$kaup->grupinimi ?></td>
                <td><?=$kaup->hind ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</form>

<form action="kaubahaldus.php">
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
    <input type="submit" name="kaubalisamine" value="Lisa kaup" />  <h2>Grupi lisamine</h2>
    <input type="text" name="uuegrupinimi" />
    <input type="submit" name="grupilisamine" value="Lisa grupp" />  </form>

<?php
function looRippMenyy($sqllause, $valikunimi, $valitudid=""){
    global $yhendus;
    $kask=$yhendus->prepare($sqllause);
    $kask->bind_result($id, $sisu);
    $kask->execute();
    $tulemus="<select name='$valikunimi'>";
    while($kask->fetch()){
        $lisand="";
        if($id==$valitudid){$lisand=" selected='selected'";}
        $tulemus.="<option value='$id' $lisand >$sisu</option>";
    }
    $tulemus.="</select>";
    return $tulemus;
}

function lisaGrupp($grupinimi){
    global $yhendus;
    $kask=$yhendus->prepare("INSERT INTO kaubagrupid (grupinimi)  VALUES (?)");
    $kask->bind_param("s", $grupinimi);
    $kask->execute();
}

function lisaKaup($nimetus, $kaubagrupi_id, $hind){
    global $yhendus;
    $kask=$yhendus->prepare("INSERT INTO  
kaubad (nimetus, kaubagrupi_id, hind) 
VALUES (?, ?, ?)");
    $kask->bind_param("sid", $nimetus, $kaubagrupi_id, $hind);
    $kask->execute();
}

if(isSet($_REQUEST["grupilisamine"])){
    lisaGrupp($_REQUEST["uuegrupinimi"]);
    header("Location: kaubahaldus.php");
    exit();
}
if(isSet($_REQUEST["kaubalisamine"])){
    lisaKaup($_REQUEST["nimetus"], $_REQUEST["kaubagrupi_id"], $_REQUEST["hind"]);  header("Location: kaubahaldus.php");
    exit();
}
?>

<td><a href="kaubahaldus.php?kustutusid=<?=$kaup->id ?>" onclick="return confirm('Kas ikka soovid kustutada?')">x</a>  </td>
<td><?=$kaup->nimetus ?></td>
<td><?=$kaup->grupinimi ?></td>
<td><?=$kaup->hind ?></td>

<?php
if(isSet($_REQUEST["kustutusid"])){
    kustutaKaup($_REQUEST["kustutusid"]);
}
?>

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
                <input type="submit" name="muutmine" value="Muuda" />
                <input type="submit" name="katkestus" value="Katkesta" />  <input type="hidden" name="muudetudid" value="<?=$kaup->id ?>" />  </td>
                <td><input type="text" name="nimetus" value="<?=$kaup->nimetus ?>" /></td>  <td><?php
                    echo looRippMenyy("SELECT id, grupinimi FROM kaubagrupid",  "kaubagrupi_id", $kaup->kaubagrupi_id);  ?></td>
                <td><input type="text" name="hind" value="<?=$kaup->hind ?>" /></td>  <?php else: ?>
                <td><a href="kaubahaldus.php?kustutusid=<?=$kaup->id ?>" onclick="return confirm('Kas ikka soovid kustutada?')">x</a>  <a href="kaubahaldus.php?muutmisid=<?=$kaup->id ?>">m</a>  </td>
                <td><?=$kaup->nimetus ?></td>
                <td><?=$kaup->grupinimi ?></td>
                <td><?=$kaup->hind ?></td>
            <?php endif ?>
        </tr>
    <?php endforeach; ?>
</table>

<?php
function kysiKaupadeAndmed($sorttulp="nimetus", $otsisona=""){
    global $yhendus;
    $lubatudtulbad=array("nimetus", "grupinimi", "hind");
    if(!in_array($sorttulp, $lubatudtulbad)){
        return "lubamatu tulp";
    }
    $otsisona=addslashes(stripslashes($otsisona));
    $kask=$yhendus->prepare("SELECT kaubad.id, nimetus, grupinimi, kaubagrupi_id, hind  FROM kaubad, kaubagrupid 
WHERE kaubad.kaubagrupi_id=kaubagrupid.id 
AND (nimetus LIKE '%$otsisona%' OR grupinimi LIKE '%$otsisona%')  ORDER BY $sorttulp");
    $kask->bind_result($id, $nimetus, $grupinimi, $kaubagrupi_id, $hind);  $kask->execute();
    $hoidla=array();
    while($kask->fetch()){
        $kaup=new stdClass();
        $kaup->id=$id;
        $kaup->nimetus=htmlspecialchars($nimetus);
        $kaup->grupinimi=htmlspecialchars($grupinimi);
        $kaup->kaubagrupi_id=$kaubagrupi_id;
        $kaup->hind=$hind;
        array_push($hoidla, $kaup);
    }
    return $hoidla;
}
?>

<input type="hidden" name="muudetudid" value="<?=$kaup->id ?>" />

<?php
function muudaKaup($kauba_id, $nimetus, $kaubagrupi_id, $hind){
    global $yhendus;
    $kask=$yhendus->prepare("UPDATE kaubad SET nimetus=?, kaubagrupi_id=?, hind=?  WHERE id=?");
    $kask->bind_param("sidi", $nimetus, $kaubagrupi_id, $hind, $kauba_id);  $kask->execute();
}
if(isSet($_REQUEST["muutmine"])){
    muudaKaup($_REQUEST["muudetudid"], $_REQUEST["nimetus"],
        $_REQUEST["kaubagrupi_id"], $_REQUEST["hind"]);  }
?>
</body>
</html>