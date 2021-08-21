<?php
require_once './vendor/autoload.php';

use Twilio\Rest\Client;

// Your Account SID and Auth Token from twilio.com/console
$account_sid = 'ACd79ded80b9b22fd9f96c0d975c7a9dee';
$auth_token = '4ebacdad2e98b44108f6e00d51c3a424';
// In production, these should be environment variables. E.g.:
// $auth_token = $_ENV["TWILIO_ACCOUNT_SID"]

// A Twilio number you own with Voice capabilities
$twilio_number = "+17078966036";

// Where to make a voice call (your cell phone?)
$to_number = "+251919564169";

$client = new Client($account_sid, $auth_token);
$client->account->calls->create(  
     "+251 94 712 1539",
    "+17078966036",
    array(
     "url" => "http://c2ca7db49fb8.ngrok.io/takeResponse.php"
 )
);

