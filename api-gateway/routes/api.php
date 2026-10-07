<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

$routeUserService = env('USER_SERVICE_URL', 'http://127.0.0.1:8001');
$routeProductService = env('PRODUCT_SERVICE_URL', 'http://127.0.0.1:8002');

Route::get('/users', function () use ($routeUserService) {
    $response = Http::get("{$routeUserService}/api/users");
    return response()->json($response->json(), $response->status());
});

Route::post('/users', function (Request $request) use ($routeUserService) {
    $response = Http::post("{$routeUserService}/api/users", $request->all());
    return response()->json($response->json(), $response->status());
});

Route::get('/users/{id}', function ($id) use ($routeUserService) {
    $response = Http::get("{$routeUserService}/api/users/{$id}");
    return response()->json($response->json(), $response->status());
});

Route::get('/products', function () use ($routeProductService) {
    $response = Http::get("{$routeProductService}/api/products");
    return response()->json($response->json(), $response->status());
});

Route::get('/products/{id}', function ($id) use ($routeProductService) {
    $response = Http::get("{$routeProductService}/api/products/{$id}");
    return response()->json($response->json(), $response->status());
});
