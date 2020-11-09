<?php
checkDBclasss();
class demandes
{

    public $db;

    function __construct()
    {
        $this->db = new DataBase;
    }

    function gethotels_Demandes()
    {
        $query = "SELECT h.hotel_id,d.demande_type,d.demande_id as `Demande ID`,CONCAT(first_name, ' ', last_name) AS
        `Nom d'utilisateur`,h.hotel_name as  `Nom d'hôtel`,h.Telephone as `Numero de télephone`,d.date as 
        `Date demande` from demandes d inner JOIN hotels h on h.hotel_id=d.hotel_id inner JOIN users u on 
        u.user_id=h.manager_id WHERE d.status = 0 and demande_type in (1)";
        return $this->db->ExecuteQuery_results($query);
    }

    function getusers_demandes()
    {
        $query = "SELECT d.user_id,d.demande_type,d.demande_id as `Demande ID`,CONCAT(first_name, ' ', last_name) AS
        `Nom d'utilisateur`,d.date as `Date demande`, r.role_name as `Rôle Demandé` from demandes d
         inner JOIN users u on u.user_id=d.user_id inner JOIN roles r on r.role_id=d.demande_type
          WHERE d.status = 0 and demande_type in (2,3)";
        return $this->db->ExecuteQuery_results($query);
    }

    function demandeAction($type, $id, $decision)
    {
        $query = $this->getdemandeQuery($type);
        $query = str_replace("{id}", $id, $query);
        $this->db->ExecuteQuery($query);
    }

    function finishDemande($demande_id)
    {
        $query = ' UPDATE `demandes` SET status=1 WHERE `demande_id` = ' . $demande_id;
        $this->db->ExecuteQuery($query);
    }

    function getdemandeQuery($type)
    {
        $query = "select Query from demande_type where id= $type";
        return $this->db->ExecuteQuery_returnValue($query);
    }

    function newdemande($user_id, $demande_type, $hotel)
    {
        $query = "INSERT INTO `demandes`(`user_id`, `demande_type`, `date`, `status`,`hotel_id`)"
            . "VALUES ($user_id,$demande_type,'" . date("Y-m-d H:i:s") . "',0,$hotel)";
        $this->db->ExecuteQuery($query);
    }
}
