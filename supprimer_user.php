<?php
require "../classes/user.php";
require "../functions.php";

if (isset($_POST['uid']))
    $u = new user;
$u->supprimerUser($_POST['uid']);

if ($uy)
    echo "true";
else
    echo "false";
die;
