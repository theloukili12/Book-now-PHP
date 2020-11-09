<?php
require_once "../functions.php";
loadClasses();
$user = new user();
$result = [];

$chm = new chambre;
$types = $chm->getChambretypes();
$array = mysqli_fetch_array($types);
$rows = array();
while($r = mysqli_fetch_assoc($types)) {
    $rows[] = $r;
}

print json_encode($rows);


?>