<?php

use App\Http\Controllers\PDFController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/login', function() {
    return view('index');
})->name('login');

Route::middleware('auth:sanctum')->get('pdf/preview/{invoice}', [PDFController::class, 'preview'])->name('pdf.preview');
Route::middleware('auth:sanctum')->get('pdf/generate/{invoice}', [PDFController::class, 'generatePDF'])->name('pdf.generate');

Route::middleware('auth:sanctum')->get('/{any}', function() {
    return view('index');
})->where('any', '.*');
