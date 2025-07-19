<?php

use App\Http\Controllers\Api\ImageController;
use Illuminate\Support\Facades\Route;


Route::resource('/', ImageController::class);
