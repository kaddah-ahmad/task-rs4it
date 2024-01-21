<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CompetitionController;
use App\Http\Controllers\Api\UploadFileController;
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

Route::group(['prefix' => 'auth'], function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('confirm-account', [AuthController::class, 'confirmAccount']);
    Route::post('resend-code', [AuthController::class, 'resendConfirmationCode']);
    Route::post('reset-password', [AuthController::class, 'resetPassword']);
    Route::post('forget-password', [AuthController::class, 'forgetPassword']);
});

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('upload', [UploadFileController::class, 'uploadFile']);
    Route::get('competitions/{id}', [CompetitionController::class, 'getCompetitionById']);
    Route::get('competitions/', [CompetitionController::class, 'getCompetitions']);
    Route::post('competitions/', [CompetitionController::class, 'createCompetition']);
    Route::put('competitions/{id}', [CompetitionController::class, 'updateCompetition']);
    Route::delete('competitions/{id}', [CompetitionController::class, 'deleteCompetition']);
});
