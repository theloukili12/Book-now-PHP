<?php
require "classes/chambre.php";
require "functions.php";

if(isset($_POST['hid'])){
$c = new chambre;
$c->supprimerChambre($_POST['hid']);
}


?>