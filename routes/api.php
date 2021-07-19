<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PassportAuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PartyController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\PartyUserController;



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
// POST is a necessary method for protecting data while the user is being created/register.
// In this case the New User will have to fill the next inputs ('name', 'username', 'email' and 'password')
Route::post('register', [PassportAuthController::class, 'register']);
Route::post('login', [PassportAuthController::class, 'login']);

Route::middleware('auth:api')->group(function() {

    //RESOURCE method enables to use the complete CRUD (7 methods).
    //In this case the user if he is loged in, can use any method in postman.
    Route::resource('users', UserController::class);

    //PARTIES
    Route::post('parties/partygameid', [PartyController::class,'partygameid']);


    Route::resource('messages', MessageController::class);
    Route::post('messages/allmessages', [MessageController::class, 'allmessages']);

    // Route::resource('parties', PartyController::class);

    Route::resource('games', GameController::class);

    Route::resource('partyusers', PartyUserController::class);
    Route::post('partyusers/join', [PartyUserController::class, 'join']);

});
