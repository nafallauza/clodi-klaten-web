<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/api/frontend-data', [ApiController::class, 'index']);

Route::get('/setup-db', function () {
    try {
        $sqlPath = base_path('database/clodi.sql');
        if (!file_exists($sqlPath)) {
            return response()->json(['error' => 'SQL file not found at ' . $sqlPath]);
        }
        $sql = file_get_contents($sqlPath);
        \Illuminate\Support\Facades\DB::unprepared($sql);
        return response()->json(['success' => 'Database imported successfully!']);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Failed to import: ' . $e->getMessage()]);
    }
});
