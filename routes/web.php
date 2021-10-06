<?php

use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Frontend\PagesController;
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
Route::middleware(["auth"])->group(function(){
    Route::get('/',[PagesController::class,"home"])->name("home");
    Route::get('/profile',[PagesController::class,"profile"])->name("profile");

    //password handle
    Route::get('/password-update',[PagesController::class,"passwordUpdate"])->name("password.upate");
    Route::post('/password-update-store',[PagesController::class,"passwordUpdateStore"])->name("password.update.store");
    //wallet
    Route::get("/wallets",[PagesController::class,"wallets"])->name("wallets");
    //transfer
    Route::get('/transfer',[PagesController::class,'transfer'])->name("transfer");
    Route::get("/transfer-confirm",[PagesController::class,"transferConfirm"])->name("transferConfirm");
    Route::post("/transfer-complete",[PagesController::class,"transferComplete"])->name("transferComplete");
    Route::get("/transfer-hash",[PagesController::class,"transferHash"]);

    //phone check
    Route::get("/phone-check",[PagesController::class,'phoneCheck']);
    //password check
    Route::get("/transfer/confirm/password-check",[PagesController::class,'passwordCheck']);
});


///admin-login
Route::get('/admin/login',[LoginController::class,'login'])->name("admin.login");
Route::post('/admin/login',[LoginController::class,'storeLogin'])->name("admin.login");
Route::post('/admin/logout',[LoginController::class,'logout'])->name("admin.logout");



Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
