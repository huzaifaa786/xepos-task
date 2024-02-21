<?php

use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\EmployeeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:sanctum')->group(function () {
Route::post('/company/store', [CompanyController::class, 'store']);
Route::get('/company', [CompanyController::class, 'index']);
Route::get('/company/all', [CompanyController::class, 'getAllCompanies']);
Route::get('/company/destroy/{id}', [CompanyController::class, 'destroy']);
Route::post('/company/update/{id}', [CompanyController::class, 'update']);
Route::post('/employee/store', [EmployeeController::class, 'store']);
Route::get('/employee', [EmployeeController::class, 'index']);
Route::get('/employee/destroy/{id}', [EmployeeController::class, 'destroy']);
Route::post('/employee/update/{id}', [EmployeeController::class, 'update']);
// });

