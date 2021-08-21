<?php
use Kreait\Firebase;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Kreait\Firebase\Messaging\WebPushConfig;
use App\Http\Controllers\TwillioController;
use Twilio\TwiML\VoiceResponse;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::view('customers', 'customers');
Route::view('user', 'user');
Route::view('main', 'main');
Route::get('/update', [App\Http\Controllers\FirebaseController::class, 'update'] );

Route::get('/insert', function () {
   $stuRef = app('firebase.firestore')->database()->collection('Students')->newDocument();
   $stuRef->set([
       'firstname' => 'wak',
       'lastname' => 'kumsa',
       'age' => 23,

   ]);
});
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/save-token', [App\Http\Controllers\HomeController::class, 'saveToken'])->name('save-token');
Route::post('/send-notification', [App\Http\Controllers\HomeController::class, 'sendNotification'])->name('send.notification');

// twillio
Route::get('take-response', [TwillioController::class, 'takeResponse']);
Route::get('call', [TwillioController::class, 'call']);
Route::get('/response', [TwillioController::class, 'response']);