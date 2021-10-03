<?php

use App\Http\Controllers\Admin\LoginController;
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

Route::get('/', function () {
    return view('welcome');
});

///admin-login
Route::get('/admin/login',[LoginController::class,'login'])->name("admin.login");
Route::post('/admin/login',[LoginController::class,'storeLogin'])->name("admin.login");
Route::post('/admin/logout',[LoginController::class,'logout'])->name("admin.logout");



Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
