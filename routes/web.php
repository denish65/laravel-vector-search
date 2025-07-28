<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SearchController;

Route::get('/', function () {
    return view('home');
});





Route::get('/search', [SearchController::class, 'index'])->name('search');
