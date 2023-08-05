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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/checkBuckets', '\App\Http\Controllers\BucketController@index');
Route::get('/getBalls', '\App\Http\Controllers\BucketController@getBalls');
Route::get('/getBuckets', '\App\Http\Controllers\BucketController@getBuckets');
Route::post('/deleteBall', '\App\Http\Controllers\BucketController@deleteBall');
Route::post('/deleteBucket', '\App\Http\Controllers\BucketController@deleteBucket');
Route::post('/saveBall', '\App\Http\Controllers\BucketController@saveBall');
Route::post('/saveBucket', '\App\Http\Controllers\BucketController@saveBucket');



