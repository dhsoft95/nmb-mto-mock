<?php

use App\Http\Controllers\Mto\AccountLookupController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('mto.auth')->group(function () {
    Route::post('/chungwa/v1.0/customer-lookup', [AccountLookupController::class, 'lookup']);
});
