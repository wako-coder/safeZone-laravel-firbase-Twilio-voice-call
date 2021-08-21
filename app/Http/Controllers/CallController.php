<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio\TwiML\VoiceResponse;

class CallController extends Controller
{
    public function handleIncomingCall()
    {
        $response = new VoiceResponse();
        $gather = $response->gather(['numDigits' => 1, 'action' => secure_url('api/action')]);
        $gather->say('Welcome.');
        $gather->say('For support, press 1. For Inspirational message, press 2.');
        $response->redirect(secure_url('api/call'));
        return $response;

    }

    public function handleUserInput(Request $request)
    {
        $response = new VoiceResponse();
        $userInput = $request->input('Digits');
        if (isset($userInput)) {
            switch ($userInput) {
                case 1:
                    $response->say('You will now be transferred to an online  customer support. Please stay on the line!');
                    $response->dial('THIRD PARTY NUMBER'); //pass in phone number to dial
                    break;
                case 2:
                    $response->say(Inspiring::quote());
                    $response->say('Hope you have been inspired to keep pushing! Good bye.');
                    break;
                default:
                    $response->say('Invalid number entered!');
                    $response->redirect(secure_url('api/call'));
            }
        } else {
            $response->redirect(secure_url('api/call'));
        }

        return $response;
    }
}
