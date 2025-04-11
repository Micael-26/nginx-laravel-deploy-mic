<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/health', function () {
    try {
        // Test de connexion à la base de données
        DB::connection()->getPdo();
        return response()->json([
            'status' => '✅ OK',
            'database' => DB::connection()->getDatabaseName(),
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => '❌ Échec connexion DB',
            'error' => $e->getMessage(),
        ], 500);
    }
});
