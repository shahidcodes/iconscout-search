<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\IconController;
use App\Http\Controllers\Api\SearchController;
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

Route::get('/', function (Request $request) {
    return 'Hello world';
});

Route::get('/login', function (Request $req) {
    return [
        "type" => "error",
        "message" => "Please login"
    ];
});

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register']);



Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::get('/search', [SearchController::class, 'search']);
    Route::post('/icon', [IconController::class, 'store']);
});
