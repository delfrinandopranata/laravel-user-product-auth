<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Projects\ProjectController;
use App\Http\Controllers\Timesheets\TimesheetController;
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
Route::group([
    'middleware' => 'api'
], function ($router) {
    
    /**
     * Authentication Module
     */
    Route::group(['prefix' => 'auth'], function() {
        Route::post('register', [AuthController::class, 'register']);
        Route::post('login', [AuthController::class, 'login']);
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::get('me', [AuthController::class, 'me']);
    });

    /**
     * Projects Module
     */
    Route::group(['middleware' => 'auth:api'], function() {
        Route::resource('projects', ProjectController::class);
        Route::get('projects/{project}/users', [ProjectController::class, 'getUsers']);
    });

    /**
     * Timesheets Module
     */
    Route::group(['middleware' => 'auth:api'], function() {
        Route::resource('timesheets', TimesheetController::class);
        
        // Additional timesheet-related routes (if necessary)
        // You can define custom routes here
    });
});
