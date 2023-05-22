<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [LoginController::class, 'index']);
Route::post('/login_user', [LoginController::class, 'login'])->name('user.login');

Route::group(['middleware' => ['adminAccess']], function(){
    Route::get('/manager/dashboard', [DashboardController::class, 'manager_index'])->name('managers.dashboard');
});

Route::group(['middleware' => ['staffAccess']], function(){
    Route::get('/staff/dashboard', [DashboardController::class, 'staff_index'])->name('staff.dashboard');
});

