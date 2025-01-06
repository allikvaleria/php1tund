<?php if(isset($_GET['code'])){die(highlight_file(FILE, 1));} ?>

<?php
$opilased = simplexml_load_file("TARpv23ruhmaleht.xml");

// Добавление нового ученика
if (isset($_POST['submit'])) {
    $valjad = ['nimi', 'perekonnanimi', 'kodulehed', 'juuksevarv'];
    $kontroll = true;
    // Проверка каждого поля формы
    foreach ($valjad as $valjad_1) {
        if (empty(trim($_POST[$valjad_1]))) {
            $kontroll = false;
            break;
        }
    }

    if ($kontroll) {
        // Загрузка XML для изменений
        $xmlDoc = new DOMDocument("1.0", "UTF-8");
        $xmlDoc->preserveWhiteSpace = false;
        // Загрузка существующей структуры XML
        $xmlDoc->load("TARpv23ruhmaleht.xml");
        $xmlDoc->formatOutput = true;

        // Получаем корневой элемент
        $xml_root = $xmlDoc->documentElement;

        // Создаем новый элемент для нового ученика
        $xml_opilane = $xmlDoc->createElement("opilane");
        $xml_root->appendChild($xml_opilane);

        // Добавляем данные ученика в новый элемент
        foreach ($_POST as $key => $value) {
            if ($key !== 'submit') {
                $element = $xmlDoc->createElement($key, htmlspecialchars($value));
                $xml_opilane->appendChild($element);
            }
        }

        // Сохраняем изменения в XML файл
        $xmlDoc->save("TARpv23ruhmaleht.xml");

        // Обновляем список учеников
        $opilased = simplexml_load_file("TARpv23ruhmaleht.xml");
    }
}

// Функция для поиска по фамилии
function otsingPerekonnanimiJargi($paring) {
    global $opilased;
    $paringVastus = array();
    foreach ($opilased->opilane as $opilane) {
        if (substr(strtolower($opilane->perekonnanimi), 0, strlen($paring)) == strtolower($paring)) {
            array_push($paringVastus, $opilane);
        }
    }
    return $paringVastus;
}
?>
<!DOCTYPE html>
<html lang="et">
<head>
    <title>Õpilaste andmed XML failist</title>
    <link rel="stylesheet" href="styleXML.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Функция для изменения фона ячейки на синий при наведении
        $(document).ready(function() {
            // При наведении на ячейки столбца "Koduleht"
            $('td:nth-child(3)').hover(
                function() { // mouseenter
                    $(this).css('background-color', 'lightblue');
                },
                function() { // mouseleave
                    $(this).css('background-color', '');
                }
            );

            // Также, можно добавить поведение для других столбцов
            $('td').hover(
                function() { // mouseenter
                    $(this).css('background-color', 'lightblue');
                },
                function() { // mouseleave
                    $(this).css('background-color', '');
                }
            );
        });
    </script>
</head>
<body>
<h2>Õpilaste andmed XML failist</h2>

<!-- Форма для добавления нового ученика -->
<h3>Lisa uus õpilane</h3>
<form method="post" action="?">
    <label for="nimi">Nimi:</label>
    <input type="text" id="nimi" name="nimi" required>
    <br><br>
    <label for="perekonnanimi">Perekonnanimi:</label>
    <input type="text" id="perekonnanimi" name="perekonnanimi" required>
    <br><br>
    <label for="kodulehed">Koduleht:</label>
    <input type="email" id="kodulehed" name="kodulehed" required>
    <br><br>
    <label for="juuksevarv">Juuksevärv:</label>
    <input type="text" id="juuksevarv" name="juuksevarv" required>
    <br><br>
    <input type="submit" name="submit" value="Lisa õpilane">
    <br><br>
</form>

<div id="opilased">
    Esimene õpilane andmed:
    <?php
    echo $opilased->opilane[0]->nimi;
    echo ", ";
    echo $opilased->opilane[0]->perekonnanimi;
    echo ", ";
    echo $opilased->opilane[0]->kodulehed;
    echo ", ";
    echo $opilased->opilane[0]->juuksevarv;
    ?>
    <!-- Окно поиска -->
    <br><br>
    <form method="post" action="?">
        <label for="otsing">Otsing:</label>
        <input type="text" id="otsing" name="otsing" placeholder="perekonnanimi">
        <input type="submit" value="OK">
    </form>
</div>
<br>

<?php
if(!empty($_POST['otsing'])) {
    $paringVastus = otsingPerekonnanimiJargi($_POST['otsing']);
    echo "<table border='1'>";
    echo "<tr>";
    echo "<th>Nimi</th>";
    echo "<th>Perekonnanimi</th>";
    echo "<th>Koduleht</th>";
    echo "<th>Juuksevärv</th>";
    echo "</tr>";

    foreach($paringVastus as $opilane) {
        echo "<tr>";
        echo "<td>".$opilane->nimi."</td>";
        echo "<td>".$opilane->perekonnanimi."</td>";

        // Выводим ссылку с цветом волос в столбце "Koduleht"
        $kodulehed = "https://" . $opilane->kodulehed;
        $juuksevarv = strtolower(trim($opilane->juuksevarv));
        echo "<td><a href='$kodulehed' target='_blank' data-haircolor='$juuksevarv'>Koduleht</a></td>";

        echo "<td>".$opilane->juuksevarv."</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    ?>
    <table id="t1" border="3">
        <tr>
            <th>Nimi</th>
            <th>Perekonnanimi</th>
            <th>Koduleht</th>
            <th>Juuksevärv</th>
        </tr>
        <?php
        foreach($opilased as $opilane) {
            echo "<tr>";
            echo "<td>".$opilane->nimi."</td>";
            echo "<td>".$opilane->perekonnanimi."</td>";

            $kodulehed = "https://" . $opilane->kodulehed;
            $juuksevarv = strtolower(trim($opilane->juuksevarv));
            echo "<td><a href='$kodulehed' target='_blank' data-haircolor='$juuksevarv'>Koduleht</a></td>";

            echo "<td>".$opilane->juuksevarv."</td>";
            echo "</tr>";
        }
        ?>
    </table>
    <?php
}
?>
</body>
</html>
