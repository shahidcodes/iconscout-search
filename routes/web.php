<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\IconController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TeamMemberController;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
    $user = User::firstOrCreate(['email' =>  "temp_user@shahid.codes"], [
        "name" => "Temp api user",
        "password" => Hash::make(rand())
    ]);

    // revoke all tokens 
    $user->tokens()->delete();

    $tokenResult = $user->createToken("temp_token");

    return view('welcome', [
        "token" => $tokenResult->plainTextToken
    ]);
});


Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::resource('icon', IconController::class);
Route::resource('team', TeamController::class);
Route::resource('member', TeamMemberController::class);

Auth::routes();
