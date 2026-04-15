<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Mto\ApiDocumentationController;


Route::get('/', [ApiDocumentationController::class, 'index']);
