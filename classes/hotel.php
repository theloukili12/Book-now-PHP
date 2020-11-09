<?php
checkDBclasss();
require_once "demandes.php";
class hotel
{
    public $db;
    public $hotel_id;
    public $hotel_name;
    public $hotel_desc;
    public $hotel_stars;
    public $hotel_phone;
    public $hotel_address;
    public $hotel_lat;
    public $hotel_lon;
    public $hotel_pictures;
    public $hotel_manager;
    public $date_add;
    public $hotel_status;

    // $hotel_name, $hotel_desc, $hotel_stars, $hotel_phone, $hotel_address, $hotel_lat, $hotel_lon, $hotel_pictures, $hotel_manager

    function __construct()
    {
        $this->db = new Database;
    }



    function edithotel()
    {
        
        $query = "UPDATE `hotels` SET `first_name`='" . $this->f_name . "',`last_name`='" . $this->l_name . "',`date_birth`='" . $this->date_birth . "',`gender`='" . $this->gender . "',`phone`='" . $this->phone . "',`address`='" . $this->address . "',`country`='" . $this->country . "',`picture`='" . $this->picture . "' WHERE hotel_id = " . $this->hotel_id;
        $this->con->query($query);
    }

    function getHotelid_valide($hotel_manager)
    {
        
        $query = "select hotel_id from hotels where manager_id = " . $hotel_manager ." and hotel_status = 1";
        $result = $this->db->ExecuteQuery_results($query);
        $list = [];
        if ($result->num_rows > 0) {
            $i=0;
            while ($row = mysqli_fetch_assoc($result)) {
                $list[$i] = $row['hotel_id'];
                $i++;
            }
            return $list;
        }
        return [];
    }

    function getHotelid_invalide($hotel_manager)
    {
        
        $query = "select hotel_id from hotels where manager_id = " . $hotel_manager." and hotel_status = 0";
        $result = $this->db->ExecuteQuery_results($query);
        $list = [];
        if ($result->num_rows > 0) {
            $i=0;
            while ($row = mysqli_fetch_assoc($result)) {
                $list[$i] = $row['hotel_id'];
                $i++;
            }
            return $list;
        }
        return [];
    }
    function getHotelInfos($hotel_id)
    {
        $query = "select * from hotels where hotel_id = " . $hotel_id;
        $result = $this->db->ExecuteQuery_results($query);
        if ($result->num_rows > 0)
            while ($row = mysqli_fetch_assoc($result)) {
                $obj = [];
                $obj['hotel_id'] = $row['hotel_id'];
                $obj['hotel_name'] = $row['hotel_name'];
                $obj['hotel_desc'] = $row['hotel_description'];
                $obj['hotel_stars'] = $row['stars'];
                $obj['lat'] = $row['latitude'];
                $obj['lng'] = $row['longitude'];
                $obj['hotel_phone'] = $row['Telephone'];
                $obj['hotel_address'] = $row['Address'];
                $obj['hotel_pictures'] = $row['pictures'];
                $obj['hotel_add'] = $row['date_add'];
                $obj['hotel_status'] = $row['hotel_status'];
                return $obj;
            }
    }

    function new_hotel($hotel_name, $hotel_desc, $hotel_stars, $hotel_phone, $hotel_address, $hotel_lat, $hotel_lon, $hotel_pictures, $hotel_manager)
    {
        // $this->con = new mysqli("localhost", "root", "", "pfe_db");
        $this->hotel_name = $hotel_name;
        $this->hotel_desc = $hotel_desc;
        $this->hotel_stars = $hotel_stars;
        $this->hotel_phone = $hotel_phone;
        $this->hotel_address = $hotel_address;
        $this->hotel_lat = $hotel_lat;
        $this->hotel_lon = $hotel_lon;
        $this->hotel_pictures = $hotel_pictures;
        $this->hotel_manager = $hotel_manager;
        $this->date_add = date("d/m/Y");

        $qry = "INSERT INTO `hotels`(`hotel_name`, `hotel_description`, `Telephone`, `Address`, `stars`, `longitude`, `latitude`, `pictures`, `manager_id`, `date_add`, `hotel_status`)"
            . " VALUES ('$this->hotel_name','$this->hotel_desc','$this->hotel_phone','$this->hotel_address',$this->hotel_stars,"
            . "$this->hotel_lon,$this->hotel_lat,'$this->hotel_pictures',$this->hotel_manager,'$this->date_add',0);";
        $this->db->ExecuteQuery($qry);       
        $qry = "SELECT LAST_INSERT_ID();";
        $hotelid= $this->db->ExecuteQuery_returnValue($qry);
        
        $demande = new demandes;
        $demande->newdemande($this->hotel_manager,1,$hotelid);
        
    }

    function getHotelProches($lat,$lng,$type){
        $query = "select * from hotels h inner join chambres c on c.hotel_id=h.hotel_id ".($type == "tous" ? "": "where c.type = ".$type);
        
        $results = $this->db->ExecuteQuery_results($query);
        $array = array();
        while($hotel = mysqli_fetch_array($results,MYSQLI_BOTH)){
            $hlat = $hotel['latitude'];
            $hlng = $hotel['longitude'];
            
            $hid = $hotel['hotel_id'];
            $distance = number_format((float) distance($lat,$lng,$hlat,$hlng), 2, '.', '');;
            $array[$hid] = $distance;
        }
        return $array;
    }

    function getHotelChambresInfos($id,$type){
        $query = 'select h.hotel_name,h.Address,h.stars,c.description,prix_unitaire,images,h.Telephone from chambres c inner join hotels h on h.hotel_id = c.hotel_id
        where c.type = '.$type;
        return $this->db->ExecuteQuery_results($query);
    }
    
}
