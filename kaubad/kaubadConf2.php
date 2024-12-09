<?php
$kasutaja="d132026_valeria";
$parool="justsmiling2020";
$andmebaas="d132026_valeria";
$serverinimi="d132026.mysql.zonevs.eu";

$yhendus=new mysqli($serverinimi,$kasutaja,$parool,$andmebaas);
$yhendus->set_charset("utf8");
