<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'success' => false,
        'message' => 'This is an API-only application. No web access allowed.'
    ], 403);
});
