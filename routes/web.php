<?php

use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\ProfileController;
use App\Mail\CompanyWelcome;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth', 'verified'])->group(
    function () {
        Route::get('/dashboard', function () {
            return Inertia::render('Dashboard');
        })->name('dashboard');

        Route::get('/company/create', function () {
            return Inertia::render('Companies/CompanyCreate');
        })->name('companyCreate');

        Route::get('/company', function () {
            return Inertia::render('Companies/CompanyIndex');
        })->name('companyIndex');

        Route::get('/company/edit/{id}', [CompanyController::class, 'edit'])->name('companyEdit');

        Route::get('/employee/create', function () {
            return Inertia::render('Employees/EmployeeCreate');
        })->name('employeeCreate');

        Route::get('/employee', function () {
            return Inertia::render('Employees/EmployeeIndex');
        })->name('employeeIndex');

        Route::get('/employee/edit/{id}', [EmployeeController::class, 'edit'])->name('employeeEdit');
    }
);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__ . '/auth.php';
