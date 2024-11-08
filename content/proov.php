
    <?php
    echo "Tere hommikust!";
    echo "<br>";
    $muutuja='PHP on skriptikeel';
    echo "<strong>";
    echo $muutuja;
    echo "</strong>";
    echo "<br>";
    // Tekstifunktsioonid
    echo "<h2>Tekstifunktsioonid</h2>";
    $tekst='Esmaspaev on 4. november';
    echo $tekst;
    // kõik tähed on suured
    echo "<br>";
    echo strtoupper($tekst); // mb_strtoupper($tekst); - tunneb ä täht, strtoupper($tekst);- ei tunne ä täht
    // kõik tähed on väiksed
    echo "<br>";
    echo strtolower($tekst);
    // iga sõna algab suure tähega
    echo "<br>";
    echo ucwords($tekst);
    // teksti pikkus
    echo "<br>";
    echo "Teksti pikkus - ".strlen($tekst);
    // eraldame esimesed 5 tähte
    echo "<br>";
    echo "Esimesed viis tähte - ".substr($tekst, 0, 5);
    // leiame on positsiooni
    echo "<br>";
    $otsing='on';
    echo "On asukoht lauses on ".strpos($tekst, $otsing);
    // eralda esimene sõna kuni $otsing
    echo "<br>";
    echo substr($tekst, 0, strpos($tekst, $otsing));
    echo "<br>";
    // eralda peale esimest sõna, alates 'on'
    echo substr($tekst, strpos($tekst, $otsing));
    echo "<br>";
    echo "<h2>Kasutame veebis kasutavaid näidised</h2>";
    // sõnade arv lauses
    echo "Sõnade arv lauses on - ".str_word_count($tekst);
    // Iseseisvalt - teksti kärpimine
    echo "<br>";
    $tekst2 = 'Pohitoetus voitakse ara 11.11 kui volgnevused ei ole parandatud';
    echo trim($tekst2, "P, p, a..d, o");
    // Iseseisvalt - Tekst kui massiiv
    echo "<br>";
    $massivitekst='Taiendav info opilase kohta';
    echo $massivitekst;
    echo "<br>";
    // massiv algab nullist
    echo "1.täht - ".$massivitekst[0]; 				//T
    echo '<br>';
    echo "4.täht - ".$massivitekst[4];                //n
    // kolmas sõna
    echo '<br>';
    $sona=str_word_count($massivitekst,1);
    print_r($sona);
    echo "<br>";
    echo "Kolmas sõna - ".$sona[2];
?>

