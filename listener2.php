<?php
function writeLog($message) 
{ 
    $date = date("Y-m-d H:i:s");
    $error_message = "\n[$date] ".$message;
    // path of the log file where errors need to be logged 
    $log_file = "../public_html/log/logger.log";
    // logging error message to given log file 
    error_log($error_message, 3, $log_file);
}
writeLog("1");
header('HTTP/1.1 200 OK');
//

$resp = 'cmd=_notify-validate';
foreach ($_POST as $parm => $var) {
    $var = urlencode(stripslashes($var));
    $resp .= "&$parm=$var";
}

$item_name        = $_POST['item_name'];
$item_number      = $_POST['item_number'];
$payment_status   = $_POST['payment_status'];
$payment_amount   = $_POST['mc_gross'];
$payment_currency = $_POST['mc_currency'];
$txn_id           = $_POST['txn_id'];
$receiver_email   = $_POST['receiver_email'];
$payer_email      = $_POST['payer_email'];
$record_id         = $_POST['custom'];
$payer_id = $_POST['payer_id'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$payment_date = $_POST['payment_date'];
writeLog($item_name);
writeLog($payment_status);
writeLog($payment_amount);
writeLog($receiver_email);
writeLog($payer_email);
$httphead = "POST /cgi-bin/webscr HTTP/1.0\r\n";
$httphead .= "Content-Type: application/x-www-form-urlencoded\r\n";
$httphead .= "Content-Length: " . strlen($resp) . "\r\n\r\n";


$errno = '';
$errstr = '';

$fh = fsockopen('ssl://www.paypal.com', 443, $errno, $errstr, 30);

if (!$fh) {

    writeLog("!fh");
} else {
    fputs($fh, $httphead . $resp);
    while (!feof($fh)) {
        $readresp = fgets($fh, 1024);
        writeLog($readresp);
        if (strcmp($readresp, "VERIFIED") == 0) {
            writeLog("Verified");
        } else if (strcmp($readresp, "INVALID") == 0) {

            writeLog("INVALID");

        }
    }
    fclose($fh);
}
//
//
// STEP 6 - Pour yourself a cold one.
//
//
