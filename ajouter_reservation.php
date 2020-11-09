<?php

require "functions.php";

require "classes/reservation.php";

writeLog("1 good");
$lat = $_POST['lat'];
$lng = $_POST['lng'];
$type_payment = $_POST['tp'];
$adresse = $_POST['adresse'];
$chambre_id = $_POST['cid'];
$user_id = $_POST['uid'];
$date_arriver = $_POST['da'];
$date_depart = $_POST['dt'];
$cc = $_POST['cc'];


$res = new reservation;
$uy = $res->ajouterReservation($date_arriver, $date_depart, $chambre_id, $user_id, $type_payment, 0, $cc);
if ($uy)
    echo "true";
else
    echo "false";
die;
