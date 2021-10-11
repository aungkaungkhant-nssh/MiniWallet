<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PagesController;
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
Route::post('/login',[AuthController::class,"login"]);
Route::post("/register",[AuthController::class,"register"]);

Route::middleware("auth:api")->group(function(){
    Route::post("/logout",[AuthController::class,"logout"]);
    Route::get("/profile",[PagesController::class,"profile"]);
    Route::get('/transcations',[PagesController::class,"transcations"]);
    Route::get("/transcations/{trx_id}",[PagesController::class,"transcationsDetails"]);
    Route::get('/notifications',[PagesController::class,"notifications"]);
    Route::get('/notifications-details/{id}',[PagesController::class,"notificationsDetails"]);
    Route::get("/phone-check",[PagesController::class,"phoneCheck"]);
    Route::get("/transfer-confirm",[PagesController::class,"transferConfirm"]);
    Route::post("/transfer-complete",[PagesController::class,"transferComplete"]);
    Route::get('/scan-and-pay-form',[PagesController::class,"scanAndPayForm"])->name("scanAndPayForm");
    Route::get("/scan-and-pay-confirm",[PagesController::class,"scanAndPayConfirm"]);
    Route::post("/scan-and-pay-complete",[PagesController::class,"scanAndPayComplete"]);
});
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
