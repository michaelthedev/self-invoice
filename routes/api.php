<?php

use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\InvoiceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

/** Clients */
Route::group(['prefix' => '/clients'], function() {
    Route::get('/', [ClientController::class, 'index']);
    Route::get('/{uid}', [ClientController::class, 'show']);

    Route::post('/', [ClientController::class, 'store']);
    Route::put('/{uid}', [ClientController::class, 'update']);
    Route::delete('/{uid}', [ClientController::class, 'destroy']);
});

/** Projects */
Route::group(['prefix' => '/projects'], function() {
    Route::get('/', []);
    Route::get('/{uid}', []);

    Route::post('/', []);
    Route::put('/{uid}', []);
    Route::delete('/{uid}', []);
});

/** Invoices */
Route::group(['prefix' => '/invoices'], function() {
   Route::get('/', [InvoiceController::class, 'index']);
   Route::get('/{uid}', [InvoiceController::class, 'show']);

    Route::post('/', [InvoiceController::class, 'store']);
    Route::put('/{uid}', [InvoiceController::class, 'update']);
    Route::delete('/{uid}', [InvoiceController::class, 'destroy']);

    Route::get('/{uid}/download', [InvoiceController::class, 'download']);
    Route::patch('/{uid}/status', [InvoiceController::class, 'updateStatus']);
});

/** Statistics */
Route::get('/statistics', function() {
    Route::get('/', []);
});
