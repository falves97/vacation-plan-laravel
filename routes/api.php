<?php

use App\Http\Controllers\AuthenticateController;
use App\Http\Middleware\EnforceJson;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/register', [AuthenticateController::class, 'register'])
    ->name('authenticate.register');

Route::post('/login', [AuthenticateController::class, 'login'])
    ->name('authenticate.login');

Route::middleware('auth:api')->group(function () {
    Route::get('/user/tokens', [AuthenticateController::class, 'userTokens'])
        ->name('user.tokens');
});
