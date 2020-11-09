<?php
try {
    require "functions.php";
    require "classes/reservation.php";
    $raw_post_data = file_get_contents('php://input');
    $raw_post_array = explode('&', $raw_post_data);
    $myPost = array();
    foreach ($raw_post_array as $keyval) {
        $keyval = explode('=', $keyval);
        if (count($keyval) == 2)
            $myPost[$keyval[0]] = urldecode($keyval[1]);
    }
    // read the post from PayPal system and add 'cmd'
    $req = 'cmd=_notify-validate';
    if (function_exists('get_magic_quotes_gpc')) {
        $get_magic_quotes_exists = true;
    }
    foreach ($myPost as $key => $value) {
        if ($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
            $value = urlencode(stripslashes($value));
        } else {
            $value = urlencode($value);
        }
        $req .= "&$key=$value";
    }


    // STEP 2: Post IPN data back to paypal to validate

    $ch = curl_init('https://ipnpb.paypal.com/cgi-bin/webscr');
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
    curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));

    // In wamp like environments that do not come bundled with root authority certificates,
    // please download 'cacert.pem' from "http://curl.haxx.se/docs/caextract.html" and set the directory path 
    // of the certificate as shown below.
    // curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__) . '/cacert.pem');
    if (!($res = curl_exec($ch))) {
        // error_log("Got " . curl_error($ch) . " when processing IPN data");
        curl_close($ch);
        exit;
    }
    curl_close($ch);
    // STEP 3: Inspect IPN validation result and act accordingly

    if (strcmp($res, "VERIFIED") == 0) {
        $item_name = $_POST['item_name'];
        $item_number = $_POST['item_number'];
        $payment_status = $_POST['payment_status'];
        $payment_amount = $_POST['mc_gross'];
        $payment_currency = $_POST['mc_currency'];
        $txn_id = $_POST['txn_id'];
        $receiver_email = $_POST['receiver_email'];
        $payer_email = $_POST['payer_email'];
        $payer_id = $_POST['payer_id'];
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $payment_date = $_POST['payment_date'];
        $reserv = new reservation;
        writeLog("1");
        $details_id = $reserv->ajouterPaiement_details($payer_email, $payer_id, $first_name, $last_name, $payment_date, $payment_status, $payment_amount);
        writeLog("2 ".$details_id);
        $reserv->updateReservation($item_name, $details_id);
        $reserv->updateReservationQTE($item_name);
        writeLog("3");
    } else if (strcmp($res, "INVALID") == 0) {
        writeLog('tentative de hack');
    }
} catch (Exception $ex) {
    writeLog("Exception --> ".$ex->getMessage());
}

?>













// writeLog("1");
// header('HTTP/1.1 200 OK');
// //

// $resp = 'cmd=_notify-validate';
// foreach ($_POST as $parm => $var) {
// $var = urlencode(stripslashes($var));
// $resp .= "&$parm=$var";
// }

// $item_name = $_POST['item_name'];
// $item_number = $_POST['item_number'];
// $payment_status = $_POST['payment_status'];
// $payment_amount = $_POST['mc_gross'];
// $payment_currency = $_POST['mc_currency'];
// $txn_id = $_POST['txn_id'];
// $receiver_email = $_POST['receiver_email'];
// $payer_email = $_POST['payer_email'];
// $record_id = $_POST['custom'];
// $payer_id = $_POST['payer_id'];
// $first_name = $_POST['first_name'];
// $last_name = $_POST['last_name'];
// $payment_date = $_POST['payment_date'];
// writeLog($item_name);
// writeLog($payment_status);
// writeLog($payment_amount);
// writeLog($receiver_email);
// writeLog($payer_email);
// $httphead = "POST /cgi-bin/webscr HTTP/1.0\r\n";
// $httphead .= "Content-Type: application/x-www-form-urlencoded\r\n";
// $httphead .= "Content-Length: " . strlen($resp) . "\r\n\r\n";


// $errno = '';
// $errstr = '';

// $fh = fsockopen('ssl://www.sandbox.paypal.com', 443, $errno, $errstr, 30);

// if (!$fh) {

// writeLog("!fh");
// } else {
// fputs($fh, $httphead . $resp);
// while (!feof($fh)) {
// $readresp = fgets($fh, 1024);
// writeLog($readresp);
// if (strcmp($readresp, "VERIFIED") == 0) {
// writeLog("Verified");
// } else if (strcmp($readresp, "INVALID") == 0) {

// writeLog("INVALID");

// }
// }
// fclose($fh);
// }
//
//
// STEP 6 - Pour yourself a cold one.
//
//