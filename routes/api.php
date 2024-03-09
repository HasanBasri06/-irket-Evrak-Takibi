<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ComponyController;
use App\Http\Controllers\UserController;
use App\Models\Company;
use Illuminate\Support\Facades\Request;
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
    Route::prefix('auth')->group(function () {
        Route::post('/login', 'login');
        Route::post('/register', 'register');
    });

    Route::get('/users', 'getAllUsers');
    Route::get('/users/{user}', 'getSingleUser');
});

Route::controller(CompanyController::class)->group(function () {
    Route::prefix('company')->group(function () {
        Route::get('/', 'index');
        Route::post('/register', 'register')->middleware('hasCompany');
    });
});

Route::get('test', function () {
    $company = Company::with('owner')->get();

    dd($company );
});