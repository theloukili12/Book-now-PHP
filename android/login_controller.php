<?php
require_once "../functions.php";
loadClasses();
$user = new user();
$result = [];

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(isset($_POST["pwd"]) && isset($_POST["email"])){
        
        $email = $_POST["email"];
        $pwd = $_POST["pwd"];
        $user = new user();
        $user_infos = $user->user_login($email,$pwd);   
        if ($user_infos == "") {
            $result["sucess"] = "0";
            $result["message"] = "Email ou mot de passe incorrect";
            echo json_encode($result);
            
        } else
        {
            $result["sucess"] = "1";
            $result["id"] = explode("-",$user_infos)[0];
            $result["role"] = explode("-",$user_infos)[1];
            echo json_encode($result);
        }

      
    }
    else{
        $result["sucess"] = "0";
        echo json_encode($result);
    }
}
else
echo "wrong prob";


?>