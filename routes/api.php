<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\V1\AuthController;
use App\Http\Controllers\V1\GigController;
use App\Http\Controllers\V1\CompanyController;
use App\Http\Controllers\V1\UserProfileController;

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

Route::get('hello', function () {
    return "HELLOWORLD";
})->name('companies');
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {

    Route::post('register', [AuthController::class, 'store']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'destroy'])->name('logout');

    Route::middleware('auth:sanctum')->post('get-user-info', [UserProfileController::class, 'show']);
    Route::middleware('auth:sanctum')->put('update-user-info/{user}', [UserProfileController::class, 'update']);

    Route::middleware('auth:sanctum')->resource('companies', CompanyController::class);
    Route::middleware('auth:sanctum')->resource('gigs', GigController::class);
});
