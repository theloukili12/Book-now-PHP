<?php

define('ClassesPath', $_SERVER['DOCUMENT_ROOT'] .'/classes/');
function loadClasses()
{
    spl_autoload_register('myAutoloader');
}

function writeLog($message)
{
    $date = date("Y-m-d H:i:s");
    $error_message = "\n[$date] " . $message;
    // path of the log file where errors need to be logged 
    $log_file = $_SERVER['DOCUMENT_ROOT']."/log/logger.log";
    // logging error message to given log file 
    error_log($error_message, 3, $log_file);
}

function Redirect($lien){
    echo '?>
    <script type="text/javascript">
    window.location.href = "'.$lien.'";
    </script>
    <?php';
}


function myAutoloader($className)
{
    $path = ClassesPath;
    include $path . $className . '.php';
}

function checkDBclasss()
{
    if (!@include_once($_SERVER['DOCUMENT_ROOT'].'/classes/Database.php')) {
        require "Database.php";
    }
}

function getOriginURL()
{
    $origin = '';
    if (array_key_exists('HTTP_REFERER', $_SERVER)) {
        $origin = $_SERVER['HTTP_REFERER'];
    } else {
        $origin = $_SERVER['REMOTE_ADDR'];
    }

    return $origin;
}

function getOriginhost()
{
    $origin = '';
    if (array_key_exists('HTTP_REFERER', $_SERVER)) {
        $origin = $_SERVER['HTTP_REFERER'];
    } else {
        $origin = $_SERVER['REMOTE_ADDR'];
    }
    $parse = parse_url($origin);

    return $parse['host'];
}

function phpAlert($msg)
{
    echo '<script type="text/javascript">alert("' . $msg . '")</script>';
}

function phpAlert_array($msg)
{
    echo '<script type="text/javascript">alert("' . json_encode($msg) . '")</script>';
}


function getRandomString($length = 8)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $string = '';

    for ($i = 0; $i < $length; $i++) {
        $string .= $characters[mt_rand(0, strlen($characters) - 1)];
    }

    return $string;
}

function getReservation_form($rows)
{
    require "elements/reservation-form.php";
}

function dateDiff($date1, $date2) 
	{
	  $date1_ts = strtotime($date1);
	  $date2_ts = strtotime($date2);
	  $diff = $date2_ts - $date1_ts;
	  return round($diff / 86400);
	}

// function echoHotelInfos($h, $count)
// {
//     require "elements/hotel_infos.php";
// }

// function echoHotelInfosss($h)
// {
//     echo '

// <div class="col-6 col-12-mobile col-12-mobilep hotel-item">

//     <div class="row gtr-uniform gtr-50 list-form">
//         <div class="col-12">
//             <h3 style="text-align:center">' . $h['hotel_name'] . '</h3>
//         </div>
//         <div class="col-6">
//             <img src="' . $h['hotel_pictures'] . '" class="hotel-img" style="width:100%;height:200px;">
//         </div>
//         <div class="col-6">
//             <p><span class="hlabel">Adresse : </span>' . $h['hotel_address'] . '</p>
//             <p><span class="hlabel">Description : </span>' . $h['hotel_desc'] . '.</p>
//             <p><span class="hlabel">Télephone : </span>' . $h['hotel_phone'] . '</p>
//             <p><span class="hlabel">Date d\'ajout : </span>' . $h['hotel_add'] . '</p>
//         </div>
//         ';
//     if ($h['hotel_status'] == 1) 
//     echo ' <div class="col-12 align-right">
//             <a href="hotel_chambres.php?hid=' . $h['hotel_id'] . '" class="button special small">Chambres</a>
//             </div>';
//     echo '</div>

// </div>

// ';
// }

function showReservation_table($reservations, $columns)
{
    if (count( $reservations )> 0)
        require "elements/reservation_table.php";
    else
        echo "<h4>Pas encore d'historique :</h4>";
}

function showHotel_Demandes($Hotels_demandes, $columns)
{
    require "elements/demandes_table.php";
}


function echoHotelInfozzs($h, $count)
{

    $pics = array_filter(explode(',', $h['hotel_pictures']));

    $pic = 0;
    echo '

<div class="col-6 col-12-mobile col-12-mobilep hotel-item">

    <div class="row gtr-uniform gtr-50 list-form">
        <div class="col-12">
            <h3 style="text-align:center">' . $h['hotel_name'] . '</h3>
        </div>
        <div class="col-6">
            <div class="slideshow-container">';
    for ($i = 0; $i < count($pics); $i++) {
        echo '<div class="mySlides' . ($count + 1) . '">
                    <img src="' . $pics[$i] . '" class="hotel-img" style="width:100%;height:200px;">
                </div>';
    }
    echo '<a class="prev" onclick="plusSlides(-1, ' . $count . ')">&#10094;</a>
                <a class="next" onclick="plusSlides(1, ' . $count . ')">&#10095;</a>
            </div>
        </div>
        <div class="col-6">
            <p><span class="hlabel">Adresse : </span>' . $h['hotel_address'] . '</p>
            <p><span class="hlabel">Description : </span>' . $h['hotel_desc'] . '.</p>
            <p><span class="hlabel">Télephone : </span>' . $h['hotel_phone'] . '</p>
            <p><span class="hlabel">Date d\'ajout : </span>' . $h['hotel_add'] . '</p>  
        </div>
    </div>

</div>

';
}


function distance($lat1, $lon1, $lat2, $lon2)
{

    $theta = $lon1 - $lon2;
    $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
    $dist = acos($dist);
    $dist = rad2deg($dist);
    $miles = $dist * 60 * 1.1515;
    return ($miles * 1.609344);
}
