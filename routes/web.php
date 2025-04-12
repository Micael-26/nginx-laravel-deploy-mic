<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/asset-page', function () {
    return view('asset');
});

Route::get('/portfolio', function () {
    return view('portfolio');
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

Route::get('/env-info', function () {
    if (request('token') !== env('APP_DEBUG_TOKEN')) {
        abort(403, 'Unauthorized');
    }

    $url = env('DATABASE_URL');
    $parsed = parse_url($url);

    return response()->json([
        'host'     => $parsed['host'] ?? null,
        'port'     => $parsed['port'] ?? null,
        'database' => ltrim($parsed['path'] ?? '', '/'),
        'driver'   => config('database.default'),
        'sslmode'  => env('DB_SSLMODE', 'require'),
        'render_instance' => env('RENDER_INSTANCE_ID', 'N/A'),
        'app_env'  => env('APP_ENV'),
        'app_url'  => env('APP_URL'),
    ]);
});
