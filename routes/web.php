<?php

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
Route::get('users','UserController@index');


Route::get('list/tickets','TicketController@getTickets');
Route::put('solicit/tickets/{ticket}', 'TicketController@solicitTicket');

Route::get('tickets', 'TicketController@index');
Route::get('tickets/{ticket}', 'TicketController@show');
Route::post('tickets', 'TicketController@store');
Route::put('tickets/{ticket}', 'TicketController@update');
Route::delete('tickets/{ticket}', 'TicketController@destroy');

Route::get('/', function () {
    return view('welcome');
});
