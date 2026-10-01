<?php

use Illuminate\Support\Facades\Route;

// Catch-all route for Vue SPA (Frontend + Sneat Admin Panel)
Route::get('/{any}', function () {
    return view('app');
})->where('any', '^(?!api).*$');
