<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')->middleware('auth:api', 'throttle:120')->group(function () {
    Route::apiResource('links', 'API\LinkController', ['parameters' => [
        'links' => 'id'
    ]])->middleware('api.guard');

    Route::apiResource('domains', 'API\DomainController', ['parameters' => [
        'domains' => 'id'
    ]])->middleware('api.guard');

    Route::apiResource('spaces', 'API\SpaceController', ['parameters' => [
        'spaces' => 'id'
    ]])->middleware('api.guard');

    Route::apiResource('pixels', 'API\PixelController', ['parameters' => [
        'pixels' => 'id'
    ]])->middleware('api.guard');

    Route::apiResource('stats', 'API\StatController', ['parameters' => [
        'stats' => 'id'
    ]]);

    Route::apiResource('account', 'API\AccountController', ['only' => [
        'index'
    ]])->middleware('api.guard');

    Route::fallback(function () {
        return response()->json(['message' => 'Resource not found.', 'status' => 404], 404);
    });
});