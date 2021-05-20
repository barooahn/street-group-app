<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImportCSVController;


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

Route::get('/', [ImportCSVController::class, 'getImport'])->name('import');
Route::post('import_parse', [ImportCSVController::class, 'parseImport'])->name('import_parse');
Route::get('import_process', [ImportCSVController::class, 'processImport'])->name('import_process');
