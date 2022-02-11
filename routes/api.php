<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\UserController;

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

// Auth API

Route::post('/actionLogin', [LoginController::class, 'login'])->name('actionLogin');
Route::post('/actionLogout ', [LoginController::class, 'logout'])->name('logout');
// Route::post('/actionRegister', [RegisterController::class, 'create'])->name('actionRegister');
Route::get('/getCSRFToken', [PageController::class, 'getCSRFToken'])->name('getCSRFToken');
Route::get('/getPageLogin', [LoginController::class, 'showLoginForm'])->name('getPageLogin');
Route::get('/getPageRegister', [PageController::class, 'showRegisterForm'])->name('getPageRegister');


// User API

Route::get('/getAuthUser', [UserController::class, 'getAuthUser'])->name('getAuthUser');
Route::middleware('auth:sanctum')->post('/actionAddUser', [UserController::class, 'actionAddUser'])->name('actionAddUser');
Route::middleware('auth:sanctum')->post('/actionEditUser', [UserController::class, 'actionEditUser'])->name('actionEditUser');
Route::middleware('auth:sanctum')->post('/actionDeleteUser', [UserController::class, 'actionDeleteUser'])->name('actionDeleteUser');
Route::middleware('auth:sanctum')->get('/getAllUsers', [UserController::class, 'getAllUsers'])->name('getAllUsers');
Route::middleware('auth:sanctum')->get('/getUser/{user}', [UserController::class, 'getUser'])->name('getUser');
Route::middleware('auth:sanctum')->get('/getPageEditUser', [PageController::class, 'getPageEditUser'])->name('getPageEditUser');


// Company API

Route::middleware('auth:sanctum')->post('/actionAddCompany', [CompanyController::class, 'actionAddCompany'])->name('actionAddCompany');
Route::middleware('auth:sanctum')->post('/actionEditCompany', [CompanyController::class, 'actionEditCompany'])->name('actionEditCompany');
Route::middleware('auth:sanctum')->post('/actionDeleteCompany', [CompanyController::class, 'actionDeleteCompany'])->name('actionDeleteCompany');
Route::middleware('auth:sanctum')->get('/getAllCompanies', [CompanyController::class, 'getAllCompanies'])->name('getAllCompanies');
Route::middleware('auth:sanctum')->get('/getCompany/{company}', [CompanyController::class, 'getCompany'])->name('getCompany');


// Invoice API

Route::middleware('auth:sanctum')->post('/actionAddInvoice', [InvoiceController::class, 'actionAddInvoice'])->name('actionAddInvoice');
Route::middleware('auth:sanctum')->post('/actionEditInvoice', [InvoiceController::class, 'actionEditInvoice'])->name('actionEditInvoice');
Route::middleware('auth:sanctum')->post('/actionDeleteInvoice', [InvoiceController::class, 'actionDeleteInvoice'])->name('actionDeleteInvoice');
Route::middleware('auth:sanctum')->post('/actionPublicInvoice', [InvoiceController::class, 'actionPublicInvoice'])->name('actionPublicInvoice');
Route::middleware('auth:sanctum')->post('/actionEditStatus', [InvoiceController::class, 'actionEditStatus'])->name('actionEditStatus');
Route::middleware('auth:sanctum')->match(['get', 'post'], '/getAllInvoices', [InvoiceController::class, 'getAllInvoices'])->name('getAllInvoices');
Route::middleware('auth:sanctum')->get('/getInvoice/{invoice}', [InvoiceController::class, 'getInvoice'])->name('getInvoice');
Route::middleware('auth:sanctum')->post('/arrangeFormData', [InvoiceController::class, 'arrangeFormData'])->name('arrangeFormData');




// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
