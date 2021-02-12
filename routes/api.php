<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
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

Route::post('/checkout', function(Request $request) {
    try {
        Stripe::setApiKey(config('services.stripe.secret'));

        $charge = Stripe::charges()->create([
            'amount' => $request->amount,
            'currency' => $request->currency,
            'source' => $request->stripeToken,
            'description' => $request->description,
            'receipt_email' => $request->email,
            'metadata' => [
                'data1' => 'metadata 1',
                'data2' => 'metadata 2',
                'data3' => 'metadata 3',
            ],
        ]);

        // save this info to your database

        // SUCCESSFUL
        return response()->json('Thank you! Your payment has been accepted.', 200);
    } catch (CardErrorException $error) {
        // save info to database for failed
        return response()->json($error,500);
    }
});

Route::get('/getUserLanes', [UserController::class, 'getUserLanes']);
Route::post('/addLane/{user}/{lane}', [UserController::class, 'addLane']);

Route::post('/addLanes/{user}', [UserController::class, 'addLanes']);


Route::delete('/deleteUserLane/{user}/{lane}', [UserController::class, 'deleteUserLane']);
Route::apiResource('users', 'App\Http\Controllers\UserController');
//Route::apiResource('ads', 'App\Http\Controllers\AdController');
Route::post('/ads', [AdController::class, 'store']);

Route::get('/receipts',[ReceiptController::class, 'index']);
