<?php
echo "<h2>Ajafunktsioonid</h2>";
echo "<div id='kuupaev'>";
echo "Täna on ".date("d.m.Y")."<br>";
date_default_timezone_set("Europe/Tallinn"); //mm-dd-yyyy h:mm
echo "<strong>";
echo "Tänane Tallinna kuupäev ja kellaaeg on ".date("d.m.Y G:i", time())."<br>";
echo "</strong>";
echo "date('d.m.Y G:i', time())";
echo "<br>";
echo "d - kuupäev 1-31";
echo "<br>";
echo "m - kuu numbrina 1-12";
echo "<br>";
echo "Y - aasta neljakohane";
echo "<br>";
echo "G - tunniformaat 0-24";
echo "<br>";
echo "i - minutid 0-59";
echo "</div>";
?>
<h2>Väljasta vastavalt hooajale pilt (kevad/suvi/sügis/talv)</h2>
<div id="hooaeg">

    <?php
    $today = new DateTime();
    echo "Täna on ".$today->format('d-m-Y ');
    //hooaja punktid - сезон
    $spring = new DateTime('March 20');
    $summer = new DateTime('June 21');
    $fall = new DateTime('September 22');
    $winter = new DateTime('December 22');

    switch (true){
        //kevad
        case $today>=$spring && $today<=$summer:
            echo "Kevad";
            $pildi_aadress='content/img/kevad.jpg';
            break;
            //suvi
        case $today>=$summer && $today<=$fall:
            echo "Suvi";
            $pildi_aadress='content/img/suvi.jpg';
            break;
            //sügis
        case $today>=$fall && $today<=$winter:
            echo "Sügis";
            $pildi_aadress='content/img/sugis.jpg';
            break;
            //talv
        case $today>=$winter && $today<=$spring:
            echo "Talv";
            $pildi_aadress='content/img/talv.jpg';
            break;
    }
    ?>
    <img src="<?=$pildi_aadress?>" alt=' hooaja pilt'>
</div>
<h2>Mitu päeva on koolivaheajani 23.12.2024</h2>
<div id="koolivaheaeg">
    <?php
    $kdate=date_create_from_format('d.m.Y', '23.12.2024');
    $date=date_create();
    $diff=date_diff($kdate,$date);
    echo "Jääb ".$diff->format("%a")." päeva";
    echo "<br>";
    echo "Jääb ".$diff->days." päeva";
    ?>
</div>
<h2>Mitu päeva on minu sünnipäevani 25.04.2025</h2>
<div id="minusunnipaev">
    <?php
    $ddate=date_create_from_format('d.m.Y', '25.04.2025');
    $_date=date_create();
    $_diff=date_diff($ddate,$_date);
    echo "Jääb ".$_diff->days." päeva";
    ?>
</div>
<h2>Kasutaja vanuse leidmine</h2>
<div id="vanus">
    <form method="post" action="">
        Sisesta oma sünnikuupäev
        <input type="date" name="synd" placeholder="dd.mm.yyyy">
        <input type="submit" value="OK">
    </form>
    <?php
    if (isset($_REQUEST["synd"])){
        if(empty($_REQUEST["synd"])){
            echo "Sisesta oma sünnipäev kuupäev";
        }
        else{
            $sdate =date_create($_REQUEST["synd"]);
            $date=date_create();
            $interval=date_diff($sdate,$date);
            echo "Sa oled ".$interval->format("%y")." aastat vana";
        }
    }
    ?>
</div>
<h2>Massivi abil näidata kuu nimega tänases kuupäevas</h2>
<div id="samatoo">

    <?php
    $kuud=array(1=>'jaanuar', 'veebruar', 'march','april','may','juni','juli', 'august', 'september', 'oktoober', 'november', 'december');
    $paev=date('d');
    $year=date('Y');
    $kuu=$kuud[date('n')];
    echo $paev.' '.$kuu.' '.$year;
    ?>
</div>
