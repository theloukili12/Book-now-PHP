<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/Properties.php";
    class DataBase{
        public $cnx;

        function __construct(){
            $this->cnx = new mysqli(server,user,password,database);
        }

    
    
        function getColumnArray($rs)
        {
            $finfo = $rs->fetch_fields();
            foreach ($finfo as $val) {
                $columns[] = $val->name;
            }
            return $columns;
        }

        function ExecuteQuery($qry){
            return $this->cnx->query($qry);
        }
        function ExecuteQuery_results($qry){
            return $this->cnx->query($qry);

        }
        function ExecuteQuery_returnValue($qry){
            $result= $this->cnx->query($qry);
            if($result->num_rows >0){
                while ($row = mysqli_fetch_array($result)) {
                    return $row[0];
            }
            return "";
        }
    }
}



?>