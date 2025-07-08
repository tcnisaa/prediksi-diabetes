<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DiabetesController;

Route::get('/', [DiabetesController::class, 'index'])->name('diabetes.form');
Route::post('/predict', [DiabetesController::class, 'predict'])->name('diabetes.predict');
Route::get('/predict', fn() => redirect('/')); // atau arahkan balik ke form
Route::get('/test-koneksi', function () {
    $response = Http::get('https://www.google.com');
    return $response->status(); // 200 jika OK
});
