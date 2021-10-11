<?php

use App\Http\Controllers\Backend\AdminUserController;
use App\Http\Controllers\Backend\PagesController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\WalletController;
use Illuminate\Support\Facades\Route;

Route::prefix("/admin")->middleware(["auth:admin_user"])->name("admin.")->group(function(){
    Route::get("/",[PagesController::class,"home"])->name("home");
    // adminuser
    Route::resource("admin_user",AdminUserController::class);
    Route::get('/admin_user/datable/ssd',[AdminUserController::class,"ssd"]);
    //user
    Route::resource('user',UserController::class);
    Route::get('/user/datable/ssd',[UserController::class,"ssd"]);
    //wallet
    Route::get("/wallet/index",[WalletController::class,"index"])->name("wallet.index");
    Route::get("/wallet/datable/ssd",[WalletController::class,"ssd"]);
    Route::get('/wallet/add/amount',[WalletController::class,"addAmount"]);
    Route::post('/wallet/add/amount',[WalletController::class,"addAmountStore"]);
    Route::get('/wallet/reduce/amount',[WalletController::class,"reduceAmount"]);
    Route::post('/wallet/reduce/amount',[WalletController::class,"reduceAmountStore"]);
});
