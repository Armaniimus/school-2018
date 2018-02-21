<?php
require_once('medewerkerClass.php');

$medewerker = new medewerker;
$marketeer = new marketeer;
$icter = new icter;
$administratiefMedewerker = new administratiefMedewerker;

echo $medewerker->showInfoMain() . "<br />";

echo $marketeer->showInfo();
echo $icter->showInfo();
echo $administratiefMedewerker->showInfo();


?>
