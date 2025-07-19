<?php

use App\Http\Controllers\PollController;
use App\Http\Controllers\QuestionController;
use Illuminate\Support\Facades\Route;


Route::resource('/',\App\Http\Controllers\QuestionController::class);
Route::get('question/{uuid}',[QuestionController::class,'show'])->name('question.show');


Route::get('/poll/{uuid}',[PollController::class,'polling']);
Route::post('/poll/{uuid}',[PollController::class,'store'])->name('poll.store');
Route::get('/result-poll/{uuid}',[PollController::class,'resultPoll'])->name('result-poll');

Route::get('/ajax/result-poll/{uuid}',[PollController::class,'apiResultPoll'])->name('api-result-poll');
