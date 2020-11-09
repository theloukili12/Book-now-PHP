<?php
require_once "../functions.php";
loadClasses();
$user = new user();
$result = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST["pwd"]) && isset($_POST["email"]) && isset($_POST["nom"]) && isset($_POST["prenom"])) {

        $email = $_POST["email"];
        $pwd = $_POST["pwd"];
        $nom = $_POST["nom"];
        $prenom = $_POST["prenom"];
        $user = new user();
        if ($user->new_user($email, $nom, $prenom, $pwd, date("d/m/Y"))) {
            if ($user->sendmailConfirmation()) {
                $result['sucess'] = "1";
                $result["message"] = "Email de confirmation a été envoyer a votre boite, Merci de vérifier";
                echo json_encode($result);
            } else {
                $result['sucess'] = "0";
                $result["message"] = "Error d'envoi d'email de confirmation";
                echo json_encode($result);
            }
        } else {
            $result['sucess'] = "0";
            $result["message"] = "Ce email est deja existe dans la base dde données!!";
            echo json_encode($result);
        }
    } else {
        $result["sucess"] = "0";
        $result["message"] = "Les Parametres entrées ne sont pas suffisants";
        echo json_encode($result);
    }
}
