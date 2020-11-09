<?php
require "../functions.php";
require "../classes/user.php";
if (isset($_POST['uid']))
    $u = new user;
$u->supprimerUser($_POST['uid']);

if ($u)
    echo "true";
else
    echo "false";
die;
