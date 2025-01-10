<?php
$kasutaja="valeriaallik";
$parool="12345";
$andmebaas="valeriaallik";
$serverinimi="localhost";

$yhendus=new mysqli($serverinimi,$kasutaja,$parool,$andmebaas);
$yhendus->set_charset("utf8");