<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuizController;

Route::get('/', function () {
    return redirect()->route('quizzes.index');
});

Route::resource('quizzes', QuizController::class); 

use App\Http\Controllers\QuestionController;

Route::get('/quizzes/{quiz}/questions/create', [QuestionController::class, 'create'])
    ->name('questions.create');

Route::post('/quizzes/{quiz}/questions', [QuestionController::class, 'store'])
    ->name('questions.store');