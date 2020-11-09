<?php
require "functions.php";
loadClasses();
$email = $_POST['email'];
$password = $_POST['pwd'];

$user = new user;
$user_infos = $user->user_login($email, $password);

if ($user_infos == "") {
    $txtemail = $email;
    $message = 'Email ou mot de passe incorrect. si vous avez oublié votre mot de passe';
    echo "false";
    die;
} else {
    session_start();
    $_SESSION['user_id'] = explode("-", $user_infos)[0];
    $_SESSION['user_role'] = explode("-", $user_infos)[1];
    echo $message = "true";
    $die;
}
?>