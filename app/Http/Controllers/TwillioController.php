<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use Twilio\TwiML\VoiceResponse;
use Twilio\Rest\Client;
use Twilio\Twiml;

class TwillioController extends Controller
{
    public function call()
    {  
        dump('Starting call....');

        $client = new Client(env('TWILIO_SID'), env('TWILIO_TOKEN'));
        $client->account->calls->create(  
            "+251 94 712 1539",
            "+17078966036",
            ["url" => "https://f9ec98bfebc5.ngrok.io/take-response"]
        );

        dump('Calling....');
    }


    public function takeResponse()
    { 
        $response = new VoiceResponse();
        if (array_key_exists('Digits', $_POST)) {
            switch ($_POST['Digits']) {
            case 1:
                $response->say('You selected sales. Good for you!');
                break;
            case 2:
                $response->say('You need support. We will help!');
                break;
            default:
                $response->say('Sorry, I don\'t understand that choice.');
            }
        } else {
            // If no input was sent, use the <Gather> verb to collect user input
            $gather = $response->gather(array('numDigits' => 1));
            // use the <Say> verb to request input from the user
            $gather->say('For sales, press 1. For support, press 2.');

            // If the user doesn't enter input, loop
            $response->redirect('/take-response');
        }

        // Render the response as XML in reply to the webhook request
        header('Content-Type: text/xml');
        echo $response;
    }
    public function response(Request $request)
    {
        

        $id = 45;
        $flame = 1;
        $smoke = 1;
        $obstacle = 6;
        return view('response')->with([
            'id' => $id,
            'flame' =>  $flame,
            'smoke' => $smoke,
            'obstacle' => $obstacle,
        ]);
    }
}
