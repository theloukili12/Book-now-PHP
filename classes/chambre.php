<?php
checkDBclasss();
class chambre
{
    public $db;
    public $chambre_id;
    public $hotel_id;
    public $type;
    public $qte_total;
    public $qte_reserver;
    public $description;
    public $pictures;

    function __construct()
    {
        $this->db = new DataBase;
    }

    function ajouterChambre( $hotel_id,  $type, $qte_total, $qte_reserver, $description, $pictures,$prix)
    {
        $this->hotel_id = $hotel_id;
        $this->type = $type;
        $this->qte_total = $qte_total;
        $this->qte_reserver = $qte_reserver;
        $this->description = $description;
        $this->pictures = $pictures;
        $query = "INSERT INTO `chambres`(`hotel_id`, `type`, `qte_total`, `qte_reserver`, `description`, `images`,`prix_unitaire`)".
         "VALUES ($hotel_id,$type,$qte_total,$qte_reserver,'$description','$pictures',$prix)";
         
        $this->db->ExecuteQuery($query);
    }
    function modifierChambre($id, $type, $qte_total, $qte_reserver, $description, $pictures,$prix)
    {
        // $this->type = $type;
        // $this->qte_total = $qte_total;
        // $this->qte_reserver = $qte_reserver;
        // $this->description = $description;
        // $this->pictures = $pictures;
        $query = "UPDATE `chambres` SET `type`=$type,`qte_total`=$qte_total,`description`=\"$description\""
        .($pictures == "" ? "" : ",`images`='$pictures'").",`prix_unitaire`=$prix WHERE `chambre_id`=$id";
        phpAlert($query);
        $this->db->ExecuteQuery($query);
    }

    function GetChambres($hotel_id){
        $query = "SELECT chambre_id,ct.nom,c.qte_total,c.qte_reserver,c.description,images,prix_unitaire FROM chambres c inner join chambre_types ct on ct.id=c.type where hotel_id = ".$hotel_id;
        return $this->db->ExecuteQuery_results($query);
    }

    function GetChambres_types($hotel_id,$chambre_type){
        $query = "select chambre_id, ct.nom, c.qte_total, c.qte_reserver, c.description, images,prix_unitaire FROM chambres c inner join chambre_types ct on ct.id=c.type where  hotel_id = ".$hotel_id.($chambre_type == "tous" ? "": " and type= ".$chambre_type);
        
        return $this->db->ExecuteQuery_results($query);
    }

    function getChambreinfos2($chambre_id){
        $query = "SELECT c.hotel_id,chambre_id,ct.nom,c.qte_total,c.qte_reserver,c.description,images,prix_unitaire FROM chambres c inner join chambre_types ct on ct.id=c.type where chambre_id = ".$chambre_id;
        return $this->db->ExecuteQuery_results($query);
    }

    function getChambreInfos($chambre_id){
        $query = "select * from chambres where chambre_id = " . $chambre_id;

        return $this->db->ExecuteQuery_results($query);
    }


    function supprimerChambre($chambre_id){
        $query = "Delete from chambres where chambre_id = " . $chambre_id;
        writeLog($query);
        $this->db->ExecuteQuery($query);
    }
    function getHotelname($hotel_id){
        $qry = "select hotel_name from hotels where hotel_id = ".$hotel_id;
        return $this->db->ExecuteQuery_returnValue($qry);
    }

    function getChambretypes(){
        $query = "select * from chambre_types";
        return $this->db->ExecuteQuery_results($query);
    }
}
