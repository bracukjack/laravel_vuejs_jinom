<?php

use Illuminate\Http\Request;
use Illuminate\Routing\RouteGroup;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\LevelController;
use App\Http\Controllers\ProductController;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResources([
    'product' => ProductController::class,
]);
