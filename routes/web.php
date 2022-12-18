<?php

use Illuminate\Support\Facades\Route;
use App\Models\Url;

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
})->name('home');

Route::get("/{short}", function (string $short){
    $url = Url::where('gen_code','LIKE',$short)->firstOrFail();
    return redirect($url->org_url);
})->name('redirect');
