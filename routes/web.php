<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\DeceasedController;
use App\Http\Controllers\BlockController;
use App\Http\Controllers\UserController;
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
Route::group(['middleware' => 'prevent-back-history'],function(){

	Auth::routes();

	// Route::get('/home', 'HomeController@index');
    Route::get('/', [LoginController::class, 'index']);
    Route::post('/login_user', [LoginController::class, 'login'])->name('user.login');

    Route::group(['middleware' => ['adminAccess']], function(){
        Route::get('/manager/dashboard', [DashboardController::class, 'manager_index'])->name('managers.dashboard');
        
        Route::get('api/users', [UserController::class, 'data']);
        Route::get('users', [UserController::class, 'index'])->name('users.index');
        Route::post('users/add', [UserController::class, 'store'])->name('users.store');
        Route::put('users/update/{id}', [UserController::class, 'update']);
        Route::get('users/activate/{id}', [UserController::class, 'activate']);
        Route::get('users/deactivate/{id}', [UserController::class, 'deactivate']);
        Route::get('users/show/{id}', [UserController::class, 'show']);

        Route::get('users/get/contactpeople', [UserController::class, 'get_allcontactpeople'])->name('users.contactpeople');
        //services
        Route::resource('services', ServicesController::class);
        Route::get('/services', [ServicesController::class, 'index'])->name('services');
        Route::get('/get/records', [ServicesController::class, 'get_allRecords'])->name('get_allServices');
        Route::get('/services/show/{id}', [ServicesController::class, 'show']);
        Route::get('/services/classified/{id}', [ServicesController::class, 'classified']);
        Route::get('/services/delete/{id}', [ServicesController::class, 'destroy']);

        //deceaseds
        Route::get('/deceased/printpage/{deceased_id}', [DeceasedController::class, 'printpage']);
        Route::get('/deceased/nearing/maturity', [DeceasedController::class, 'nearingmaturity'])->name('deceaseds.nearingmaturity');
        Route::get('/deceaseds/allmaturity', [DeceasedController::class, 'get_allMaturity'])->name('deceaseds.get_allMaturity');
        Route::get('/deceaseds/updateNofication', [DeceasedController::class, 'updatenotification'])->name('deceaseds.updateNotification');
        Route::get('deceaseds/forApproval', [DeceasedController::class, 'deceasedForApproval'])->name('deceaseds.forApproval');
        Route::resource('deceaseds', DeceasedController::class);
        Route::put('deceaseds/update/{id}', [DeceasedController::class, 'update_deceased']);
        Route::get('/deceaseds/show/{id}', [DeceasedController::class, 'show']);
        Route::get('/get/deceaseds/records', [DeceasedController::class, 'get_allData'])->name('deceaseds.get_allData');
        Route::get('/get/deceaseds/notificationCount', [DeceasedController::class, 'notificationCount'])->name('deceaseds.notificationCount');
        Route::get('/get/deceaseds/forApproval', [DeceasedController::class, 'forApproval'])->name('deceaseds.data_forApproval');
        Route::put('/deceaseds/assign_block/{id1}/{id2}', [DeceasedController::class, 'assign_block']);
        Route::put('/deceaseds/designation/{id1}/{id2}', [DeceasedController::class, 'designation']);
        Route::get('/deceased/approve/{id1}', [DeceasedController::class, 'approve']);
        Route::get('/deceased/disapprove/{id1}', [DeceasedController::class, 'disapprove']);
      
        //Space areas
        Route::resource('spaceareas', BlockController::class);
        Route::post('/spaceareas/updatewithimage', [BlockController::class, 'update_withImage']);
        Route::get('/spaceAreas/show/{id}', [BlockController::class, 'show']);
        Route::get('/spaceAreas/delete/{id}', [BlockController::class, 'destroy']);
        Route::get('/get/blocks', [BlockController::class, 'get_allBlocks'])->name('spaceareas.get_allBlocks');
        Route::get('/get/classifiedBlocks/{id1}', [BlockController::class, 'get_classifiedBlocks']);

   
        
        Route::get('/logout', [LoginController::class, 'logout'])->name('system.logout');
    });

    Route::group(['middleware' => ['staffAccess']], function(){
        Route::get('/staff/dashboard', [DashboardController::class, 'staff_index'])->name('staff.dashboard');
    });

});


