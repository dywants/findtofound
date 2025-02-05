<?php

use App\Http\Controllers\Api\StatsController;
use App\Http\Controllers\EnumController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/stats', [StatsController::class, 'index']);
Route::get('/enums/piece-conditions', [EnumController::class, 'pieceConditions']);
