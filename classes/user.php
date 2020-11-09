<?php

checkDBclasss();
class user
{

    public $email;
    public $password;
    public $f_name;
    public $l_name;
    public $date_birth;
    public $gender;
    public $phone;
    public $address;
    public $country;
    public $picture;
    public $role;
    public $status;
    public $date_register;
    public $activation_code;
    public $db;

    function __construct()
    {
        $this->db = new Database;
    }

    function edituserPassword()
    {

        $query = "UPDATE `users` SET password = '" . $this->password . "' WHERE user_id = " . $this->user_id;
        $this->con->query($query);
    }

    function edituser()
    {

        $query = "UPDATE `users` SET `first_name`='" . $this->f_name . "',`last_name`='" . $this->l_name . "',`date_birth`='" . $this->date_birth . "',`gender`='" . $this->gender . "',`phone`='" . $this->phone . "',`address`='" . $this->address . "',`country`='" . $this->country . "',`picture`='" . $this->picture . "' WHERE user_id = " . $this->user_id;
        $this->db->ExecuteQuery($query);
    }

    function getUserinfos($user_id)
    {

        $query = "select * from users where user_id = " . $user_id;
        $result = $this->db->ExecuteQuery_results($query);
        if ($result->num_rows > 0)
            while ($row = mysqli_fetch_assoc($result)) {
                $this->email = $row['email'];

                $this->password = $row['password'];
                $this->f_name = $row['first_name'];
                $this->l_name = $row['last_name'];
                $this->date_birth = $row['date_birth'];
                $this->gender = $row['gender'];
                $this->phone = $row['phone'];
                $this->address = $row['address'];
                $this->country = $row['country'];
                $this->picture = $row['picture'];
                $this->role = $row['role'];
                $this->status = $row['status'];
                $this->date_register = $row['date_register'];
            }
    }

    function getroles()
    {
        $query = "select * from roles ";
        return $this->db->ExecuteQuery_results($query);
    }

    function editRole($user_id, $demande_type)
    {
        $demande = new demandes;

        $demande->newdemande($user_id, $demande_type, 'null');
    }

    function user_login($email, $password)
    {
        $this->email = $email;
        $this->password = $password;

        $query = "select * from users where email = '" . $this->email . "' and password = '" . $this->password . "'";

        $result = $this->db->ExecuteQuery_results($query);
        if ($result->num_rows > 0)
            while ($row = mysqli_fetch_assoc($result)) {
                return $row["user_id"] . "-" . $row["role"];
            } else
            return "";
    }

    function new_user($email, $l_name, $f_name, $password, $date_register)
    {

        $this->email = $email;
        $this->l_name = $l_name;
        $this->f_name = $f_name;
        $this->password = $password;
        $this->activation_code = md5(rand());
        $this->date_register = $date_register;
        if ($this->checkEmailExist() == true) {
            return false;
        } else {
            $qry = "INSERT INTO `users`(`email`, `password`, `first_name`, `last_name`, `role`, `Status`, `activation_code`,`date_register`) VALUES ('$this->email','$this->password','$this->f_name','$this->l_name',1,0,'$this->activation_code','$this->date_register')";
            $this->db->ExecuteQuery($qry);
            return true;
        }
    }

    function checkEmailExist(): bool
    {
        $qry = "select * from users where email = '" . $this->email . "'";
        $result = $this->db->ExecuteQuery_results($qry);
        if ($result->num_rows > 0)
            return true;
        else
            return false;
    }

    function sendmailConfirmation()
    {
        $base_url = Full_URL;
        $mail_body = "<p>Hi " . $this->l_name . " " . $this->f_name . " </p>
        <p>Merci pour l'inscription. Votre mot de passe est : <strong> " . $this->password . " </strong>, Ce mot de passe ne fonctionnera qu'après vérification de votre adresse électronique.</p>
        <p>Veuillez ouvrir ce lien pour vérifier votre adresse électronique - " . $base_url . "/email_verification.php?activation_code=" . $this->activation_code . "
        <p>Meilleures salutations.</p>";
        
        $subject = "Confirmation Mail " . App_Name;
        $email = $this->email;
        $header = 'From: BookNow@' . App_Name . '.com' . "\r\n" .
            'MIME-Version: 1.0' . "\r\n" .
            'Content-type: text/html; charset=utf-8';
        if (mail($email, $subject, $mail_body, $header))
            return true;
        else
            return false;
    }

    
    function getAllUsers()
    {
        $query = "select user_id as `ID`, CONCAT(last_name , ' ' , first_name) as `Nom`, email as `Email`," .
            " phone as `Téléphone`, r.role_name as `Role`,date_register as `Date d'inscription` from users u inner join roles r on r.role_id = u.role";
        return $this->db->ExecuteQuery_results($query);
    }

    function supprimerUser($uid)
    {
        $query = "delete from users where user_id = " . $uid;
        $this->db->ExecuteQuery($query);
    }
}
