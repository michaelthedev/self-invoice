<?php

use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\InvoiceController;
use App\Http\Controllers\Api\ProjectController;
use Illuminate\Support\Facades\Route;

/** Clients */
Route::apiResource('clients', ClientController::class);

/** Projects */
Route::apiResource('projects', ProjectController::class);

/** Invoices */
Route::group(['prefix' => '/invoices'], function() {
    Route::get('/', [InvoiceController::class, 'index']);
    Route::post('/', [InvoiceController::class, 'store']);

    Route::get('/{uid}', [InvoiceController::class, 'show']);
    Route::patch('/{uid}', [InvoiceController::class, 'update']);
    Route::delete('/{uid}', [InvoiceController::class, 'destroy']);

    Route::get('/{uid}/download', [InvoiceController::class, 'download']);
    Route::patch('/{uid}/status', [InvoiceController::class, 'updateStatus']);
});

/** Statistics */
Route::get('/statistics', function() {
    Route::get('/', []);
});
