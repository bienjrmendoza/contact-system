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

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/thank-you', function () {
        return view('thank-you');
    })->name('thank-you');

    Route::get('dashboard', 'App\Http\Controllers\ContactsController@index')->name('dashboard');
    Route::get('contact/search', 'App\Http\Controllers\ContactsController@search')->name('contact.search');
    Route::resource('contact', 'App\Http\Controllers\ContactsController');
});

require __DIR__.'/auth.php';
