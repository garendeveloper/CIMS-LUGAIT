<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\DeceasedController;
use App\Http\Controllers\BlockController;

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
    
    //services
    Route::resource('services', ServicesController::class);
    Route::get('/services', [ServicesController::class, 'index'])->name('services');
    Route::get('/get/records', [ServicesController::class, 'get_allRecords'])->name('get_allServices');
    Route::get('/services/show/{id}', [ServicesController::class, 'show']);
    Route::get('/services/delete/{id}', [ServicesController::class, 'destroy']);

    //deceaseds
    Route::resource('deceaseds', DeceasedController::class);

    //Space areas
    Route::resource('spaceareas', BlockController::class);
    Route::get('/spaceAreas/show/{id}', [BlockController::class, 'show']);
    Route::get('/spaceAreas/delete/{id}', [BlockController::class, 'destroy']);
    Route::get('/get/blocks', [BlockController::class, 'get_allBlocks'])->name('spaceareas.get_allBlocks');
});

Route::group(['middleware' => ['staffAccess']], function(){
    Route::get('/staff/dashboard', [DashboardController::class, 'staff_index'])->name('staff.dashboard');
});

