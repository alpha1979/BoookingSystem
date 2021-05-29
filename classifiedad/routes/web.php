<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;
use App\Mail\ReservationMail;
use Illuminate\Support\Facades\Mail;

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/test',function(){return 'GoodBye';});

Route::get('/rooms/{roomType?}',App\Http\Controllers\ShowRoomsController::class);

Route::resource('bookings',App\Http\Controllers\BookingController::class);
Route::resource('room_types',App\Http\Controllers\RoomTypeController::class);
Route::get('/email',function(){
    // Mail::to('atitmsingh1979@gmail.com')->send(new ReservationMail());
    return new ReservationMail();
});