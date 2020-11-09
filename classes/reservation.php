<?php
checkDBclasss();
class reservation
{

    public $db;
    function __construct()
    {
        $this->db = new DataBase;
    }

    function ajouterReservation($date_arriver, $date_depart, $chambre_id, $user_id, $type_paiement, $paiement_status, $cc)
    {
        $query = "INSERT INTO `reservations`(`date_arriver`, `date_depart`, `chambre_id`, `user_id`, `type_paiement`, `paiement_status` ,`confirmation_code`,`date`, `status`)"
            . " VALUES ('$date_arriver','$date_depart',$chambre_id,$user_id,$type_paiement,$paiement_status,'$cc','" . date("Y-m-d H:i:s") . "', " . ($type_paiement == 1 ? "0" : "1") . " )";
            writeLog($query);
        $res = $this->db->ExecuteQuery($query);
        return $res;
    }

    function ajouterPaiement_details($payer_email, $payer_id, $firstn, $lastn, $paiement_date, $paiement_status, $montant)
    {
        $query = "INSERT INTO `paiement_details`(`payer_email`, `payer_id`, `first_name`, `last_name`, `payment_date`, `payment_status`, `montant`)"
            . "VALUES ('$payer_email','$payer_id','$firstn','$lastn','$paiement_date','$paiement_status','$montant')";
        writeLog($query);
        $this->db->ExecuteQuery($query);
        $qry = "SELECT LAST_INSERT_ID();";
        return $this->db->ExecuteQuery_returnValue($qry);
    }

    function updateReservation($confirmation_code, $PD_id)
    {
        $query = "UPDATE `reservations` SET `paiement_details`= $PD_id , `paiement_status` = 1, `status` = 1 where `confirmation_code`= '$confirmation_code' ";
        writeLog($query);
        $this->db->ExecuteQuery($query);
    }

    function updateReservationQTE($confirmation_code)
    {
        $query = "select `chambre_id` from reservations where `confirmation_code` = '$confirmation_code' ";
        $cid = $this->db->ExecuteQuery_returnValue($query);
        $query = "UPDATE `chambres` SET `qte_total`=`qte_total` - 1,`qte_reserver`= `qte_reserver` + 1 WHERE  `chambre_id` = $cid";
        $this->db->ExecuteQuery($query);
    }

    function getHotels_Reservations($uid)
    {
        $query = "SELECT r.res_id as `rid`,h.hotel_name  as `Nom d'hôtel`,CONCAT(u.first_name, ' ', u.last_name) AS`Nom de client`,u.phone as `Téléphone du client`, r.date_arriver as `Date d'arriver`, r.date_depart as `Date départ`,r.type_paiement as `Mode de paiement`,r.paiement_status as `Paiement status`" .
            "FROM hotels h INNER JOIN chambres c ON c.hotel_id = h.hotel_id INNER JOIN reservations r ON r.chambre_id = c.chambre_id" .
            " INNER JOIN users u on u.user_id = r.user_id  where h.manager_id = $uid";

        return $this->db->ExecuteQuery_results($query);
    }

    function getUser_historique($uid) 
    {
        $query = "SELECT r.res_id as `rid`,h.hotel_name  as `Nom d'hôtel`,CONCAT(u.first_name, ' ', u.last_name) AS`Nom de client`,u.phone as `Téléphone du client`, r.date_arriver as `Date d'arriver`, r.date_depart as `Date départ`,r.type_paiement as `Mode de paiement`,r.paiement_status as `Paiement status`" .
            "FROM hotels h INNER JOIN chambres c ON c.hotel_id = h.hotel_id INNER JOIN reservations r ON r.chambre_id = c.chambre_id" .
            " INNER JOIN users u on u.user_id = r.user_id  where r.user_id = $uid";

        return $this->db->ExecuteQuery_results($query);
    }

    function getReservationInfos($rid)
    {
        $query = "SELECT * from reservations where res_id = $rid";

        return $this->db->ExecuteQuery_results($query);
    }

    function getPaiementDetails($paiement_id){
        $query = "SELECT * from paiement_details where paiement_id = $paiement_id";

        return $this->db->ExecuteQuery_results($query);
    }
}
