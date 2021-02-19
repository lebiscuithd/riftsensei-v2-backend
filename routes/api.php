<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LaneController;
use App\Http\Controllers\RankController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ContactsController;
use App\Http\Controllers\ReceiptController;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Cartalyst\Stripe\Exception\CardErrorException;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

## Routes Auth
## -------
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
});

## Routes Stripe
## -------

Route::post('/checkout', function(Request $request) {
    try {
        Stripe::setApiKey(config('services.stripe.secret'));

        $charge = Stripe::charges()->create([
            'amount' => $request->amount,
            'currency' => 'eur',
            'source' => $request->stripeToken,
            'description' => $request->description,
            'receipt_email' => 'test@gmail.com',
            'metadata' => [
                'data1' => 'metadata 1',
                'data2' => 'metadata 2',
                'data3' => 'metadata 3',
            ],
        ]);

        // save this info to your database

        // SUCCESSFUL
        $wallet = auth()->user()->wallet;
        $newWallet = ($wallet + $request->quantity);
            auth()->user()->update([
            'wallet' => $newWallet
        ]);


        return response()->json(['message' => 'Thank you! Your payment has been accepted.', 'newWallet' => $newWallet], 200);
    } catch (CardErrorException $error) {
        // save info to database for failed
        return response()->json($error,500);
    }
});

## Routes User
## -------
Route::apiResource('users', 'App\Http\Controllers\UserController');


## Routes Ads
## -------
Route::apiResource('ads', 'App\Http\Controllers\AdController');
Route::get('ads/{orderBy}/{type}', 'App\Http\Controllers\AdController@orderBy');
Route::put('ads/book/{user}/{ad}', [AdController::class, 'bookAd']);
Route::put('ads/finished/{coach}/{ad}', [AdController::class, 'validateAd']);
Route::put('ads/rating/{ad}', [AdController::class, 'rateAd']);
Route::get('adsbystatus/{status}', [AdController::class,'getAdsByStatus']);

## Routes Products/Receipts
## -------

Route::get('/products', [ProductController::class, 'index']);
Route::apiResource('receipts','App\Http\Controllers\ReceiptController');

## Routes Ranks
## -------
Route::get('/ranks', [RankController::class, 'index']);

## Routes Lanes
## -------
Route::post('/addLane/{user}/{lane}', [UserController::class, 'addLane']);
Route::post('/addLanes/{user}', [UserController::class, 'addLanes']);
Route::delete('/deleteUserLane/{user}/{lane}', [UserController::class, 'deleteUserLane']);
Route::get('/lanes', [LaneController::class, 'index']);


## Routes Messages
## -------
Route::get('/contacts', [ContactsController::class, 'getContacts']);
Route::get('/conversation/{id}', [ContactsController::class, 'getMessagesFor']);
Route::post('/conversation/send', [ContactsController::class, 'sendMessage']);

