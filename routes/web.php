<?php

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('index', [\App\Http\Controllers\QRCodeController::class, 'index']);
Route::get('qrcode/{file_name}', [\App\Http\Controllers\QRCodeController::class, 'qrcode'])->name('get_qrcode');
Route::post('generate_qrcode', [\App\Http\Controllers\QRCodeController::class, 'generateQrcode'])->name('generate_qrcode');
Route::get('download/{qrcode_name}', [\App\Http\Controllers\QRCodeController::class, 'download'])->name('download_qrcode');
