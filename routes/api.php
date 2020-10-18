<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group([], function () {
    Route::get('app', function (Request $request) {
        $menu = config('menu');
        return response()->json([
            'auth'          => $request->user(),
            'menu'          => $menu,
            'app_name'      => config('app.name')
        ]);
    });
});
