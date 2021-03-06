<?php

use App\Http\Controllers\AdvertCampaignController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\TokenController;
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

Route::post('/login', [LoginController::class, 'login']);
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/sanctum/token', TokenController::class);

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('advert-campaigns')->group(function () {
        Route::get('/', [AdvertCampaignController::class, 'index']);
        Route::post('/', [AdvertCampaignController::class, 'store']);

        Route::prefix('/{advertCampaign}')->group(function () {
            Route::get('/', [AdvertCampaignController::class, 'show']);
            Route::put('/', [AdvertCampaignController::class, 'update']);
            Route::delete('/', [AdvertCampaignController::class, 'destroy']);
        });
    });
});
