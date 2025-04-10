<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', function () {
    return response()->json([
        'message' => 'Laravel est opérationnel !',
        'routes' => Route::getRoutes()->getRoutesByName()
    ]);
});
