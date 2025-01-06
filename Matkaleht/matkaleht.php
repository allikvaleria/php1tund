<?php
require ('matkalehtConf.php');
global $yhendus;

// Добавление нового участника
if(!empty($_REQUEST["uusOsalejaNimi"]) && !empty($_REQUEST["uusOsalejaPilt"]) && !empty($_REQUEST["uusOsalejaInfo"])){
    $paring = $yhendus->prepare("INSERT INTO osalejad (nimi, pilt, info) VALUES (?, ?, ?)");
    $paring->bind_param("sss", $_REQUEST["uusOsalejaNimi"], $_REQUEST["uusOsalejaPilt"], $_REQUEST["uusOsalejaInfo"]);
    $paring->execute();
    header("Location:$_SERVER[PHP_SELF]");
}

// Удаление участника
if(isset($_REQUEST["kustuta_osaleja"])){
    $kask = $yhendus->prepare("DELETE FROM osalejad WHERE id=?");
    $kask->bind_param("i", $_REQUEST["kustuta_osaleja"]);
    $kask->execute();
}

// Обновление таблицы (установка пустых комментариев)
if(isset($_REQUEST["kustuta_komment"])){
    $paring = $yhendus->prepare("UPDATE konkurss SET kommentaarid='' WHERE id=?");
    $paring->bind_param("i", $_REQUEST["kustuta_komment"]);
    $paring->execute();
}
?>

<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Matka Osalejad</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h1>Osalejad</h1>

<!-- Форма для добавления нового участника -->
<br>
<form action="?" method="GET">
    <label for="uusOsalejaNimi">Osaleja nimi</label>
    <input type="text" name="uusOsalejaNimi" id="uusOsalejaNimi" required>
    <br><br>
    <label for="uusOsalejaPilt">Pilt (URL)</label>
    <input type="text" name="uusOsalejaPilt" id="uusOsalejaPilt" required>
    <br><br>
    <label for="uusOsalejaInfo">Info</label>
    <textarea name="uusOsalejaInfo" id="uusOsalejaInfo" required></textarea>
    <br><br>
    <input type="submit" value="Lisa Osaleja">
</form>

<h2>Osalejate Pildid</h2>
<div>
    <?php
    // Получение всех участников
    $paring = $yhendus->prepare("SELECT id, nimi, pilt FROM osalejad");
    $paring->bind_result($id, $nimi, $pilt);
    $paring->execute();
    while($paring->fetch()){
        echo "<div class='osaleja' onclick='showInfo($id)'>";
        echo "<img src='" . $pilt . "' alt='" . $nimi . "'>";
        echo "<p>" . htmlspecialchars($nimi) . "</p>";
        echo "</div>";
    }
    ?>
</div>

<h2>Osaleja Info</h2>
<div id="osalejaInfo"></div>

<script>
    // Показать информацию об участнике по клику на изображение
    function showInfo(id) {
        fetch('get_osaleja_info.php?id=' + id)
            .then(response => response.json())
            .then(data => {
                let infoDiv = document.getElementById('osalejaInfo');
                infoDiv.innerHTML = `
                    <h3>${data.nimi}</h3>
                    <img src="${data.pilt}" alt="${data.nimi}" style="width: 150px; height: 150px;">
                    <p>${data.info}</p>
                    <form action="?" method="GET">
                        <input type="hidden" name="kustuta_osaleja" value="${data.id}">
                        <input type="submit" value="Kustuta osaleja">
                    </form>
                `;
            });
    }
</script>


<table border="1">
    <tr>
        <th>Nimi</th>
        <th>Pilt</th>
        <th>Info</th>
        <th>Haldus</th>
    </tr>
    <?php
    // Отображение всех участников с возможностью удаления
    $paring = $yhendus->prepare("SELECT id, nimi, pilt, info FROM osalejad");
    $paring->bind_result($id, $nimi, $pilt, $info);
    $paring->execute();
    while($paring->fetch()){
        echo "<tr>";
        echo "<td>" . htmlspecialchars($nimi) . "</td>";
        echo "<td><img src='" . htmlspecialchars($pilt) . "' width='50' height='50'></td>";
        echo "<td>" . nl2br(htmlspecialchars($info)) . "</td>";
        echo "<td><a href='?kustuta_osaleja=$id' class='link-button'>Kustuta osaleja</a></td>";
        echo "</tr>";
    }
    ?>
</table>
</body>
</html>

<?php
$yhendus->close();
?>
