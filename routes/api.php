<?php

use App\Http\Controllers\Api\V1\BookController;
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

Route::prefix('v1/books')->as('v1.book')->group(function () {
    Route::get('', [BookController::class, 'index'])->name('.all');
    Route::post('',  [BookController::class, 'store'])->name('.store');
    Route::get('{book}',  [BookController::class, 'show'])->name('.get');
    Route::put('{book}',  [BookController::class, 'update'])->name('.update');
    Route::delete('{book}',  [BookController::class, 'destroy'])->name('.destroy');
});

Route::prefix('v2/books')->as('v2.book')->group(function () {

});
