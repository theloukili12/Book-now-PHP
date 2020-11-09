<?php
if (session_status() == PHP_SESSION_NONE)
    session_start();
    
require_once $_SERVER['DOCUMENT_ROOT']."/Properties.php";

?>
<!DOCTYPE HTML>