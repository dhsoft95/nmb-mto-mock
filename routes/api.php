<?php

use App\Http\Controllers\Mto\AccountLookupController;
use App\Http\Controllers\Mto\NidaVerificationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('mto.auth')->group(function () {
    Route::post('/chungwa/v1.0/customer-lookup', [AccountLookupController::class, 'lookup']);
    Route::post('/chungwa/v1.0/nida/initiate', [NidaVerificationController::class, 'initiate']);
    Route::post('/chungwa/v1.0/nida/verify', [NidaVerificationController::class, 'verify']);
});
