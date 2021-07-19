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
    
    //USERS
    Route::resource('users', UserController::class);
    Route::post('users/logout', [UserController::class,'logout']); 

    //PARTIES
    Route::post('parties/partygameid', [PartyController::class,'partygameid']);

    //MESSAGES
    Route::resource('messages', MessageController::class);
    Route::post('messages/allmessages', [MessageController::class, 'allmessages']);

    //GAMES
    Route::resource('games', GameController::class);
    Route::get('games', [GameController::class, 'show']);

    //PARTYUSERS
    Route::resource('partyusers', PartyUserController::class);
    Route::post('partyusers/join', [PartyUserController::class, 'join']);

});
