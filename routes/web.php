<?php
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
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

Route::get('/', 'Main\MainController@show')->name('main');

Auth::routes();

Route::group(['middleware' => ['auth']], function () {

    Route::get('conversations/{conversation}', 'Chat\ChatController@chat')->name('chatconv');
    Route::post('sendMessage/{conversation}', 'Chat\ChatController@sendMessage')->name('chatsend');
    Route::post('setMessagesSeen/{conversation}', 'Chat\ChatController@setMessagesSeen')->name('chatseen');

});