<?php
require "functions.php";
loadClasses();

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

phpAlert('1');
print_r($myPost);


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

phpAlert('2');

// STEP 3: Inspect IPN validation result and act accordingly

if (strcmp($res, "VERIFIED") == 0) {
    // check whether the payment_status is Completed
    if ($_POST['payment_status'] == "Completed") {
        // check that txn_id has not been previously processed
        // check that receiver_email is your Primary PayPal email
        // check that payment_amount/payment_currency are correct
        // process payment

        // assign posted variables to local variables

        phpAlert("azazz");
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

        $paypal_url = 'lat='.$lat.'&lng='.$lng.'&tp=1&adresse='.$adresse.'&cid='.$_POST["cid"].'&uid='.$_SESSION["user_id"].'&da='.$date_arriver.'&dt='.$date_arriver.'';
        $lat = $_GET['lat'];
        $lng = $_GET['lng'];
        $type_payment = $_GET['tp'];
        $adresse = $_GET['adresse'];
        $chambre_id = $_GET['cid'];
        $user_id = $_GET['cid'];
        $date_arriver = $_GET['da'];
        $date_depart = $_GET['dt'];

        $reservation = new Reservation;
        $details_id = $reservation->ajouterPaiement_details($payer_email,$payer_id,$first_name,$last_name,$payment_date,$payment_status,$payment_amount);

        $reservation->ajouterReservation($date_arriver,$date_depart,$chambre_id,$user_id,$type_payment,1,$details_id);

    }

    // <---- HERE you can do your INSERT to the database

} else if (strcmp($res, "INVALID") == 0) {
    // log for manual investigation
}
