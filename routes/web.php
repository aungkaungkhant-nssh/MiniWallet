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
});


///admin-login
Route::get('/admin/login',[LoginController::class,'login'])->name("admin.login");
Route::post('/admin/login',[LoginController::class,'storeLogin'])->name("admin.login");
Route::post('/admin/logout',[LoginController::class,'logout'])->name("admin.logout");



Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
