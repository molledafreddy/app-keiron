<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('login', 'AuthController@login');
Route::post('register', 'API\UserController@register');



Route::group(
    ['middleware' => 'auth:api', 'cors'],
    function () {
        Route::get('users','UserController@gindex');
        Route::get('list/tickets','TicketController@getTickets');
        Route::put('solicit/tickets/{ticket}', 'TicketController@solicitTicket');

        Route::get('tickets', 'TicketController@index');
        Route::get('tickets/{ticket}', 'TicketController@show');
        Route::post('tickets', 'TicketController@store');
        Route::put('tickets/{ticket}', 'TicketController@update');
        Route::delete('tickets/{ticket}', 'TicketController@destroy');
        Route::post('logout', 'AuthController@logout');
    }
);