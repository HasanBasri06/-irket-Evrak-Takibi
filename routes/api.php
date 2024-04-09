<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use L5Swagger\Http\Controllers\SwaggerController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/documantation', [SwaggerController::class, 'api']);

Route::controller(UserController::class)->group(function () {
    Route::group(['prefix' => 'auth'], function () {
        Route::post('/login', 'login');
        Route::post('/register', 'register');
    });

    Route::get('/users', 'getAllUsers');
    Route::get('/users/{user}', 'getSingleUser');
});

Route::controller(CompanyController::class)->group(function () {
    Route::prefix('company')->group(function () {
        Route::middleware('auth:sanctum')->group(function () {
            Route::post('/my-companies', 'myCompanies');
            Route::post('/add-company-worker', 'addCompanyWorker');
            Route::post('company_user_request', 'sendRequestCompany');
        });
        Route::post('/register', 'register')->middleware('hasCompany');
    });
});

