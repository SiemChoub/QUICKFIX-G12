<?php

use App\Http\Controllers\API\PostController;
use App\Http\Controllers\API\ServiceController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\BookingController;
use App\Http\Controllers\API\Bookin_memediatelyController;
use App\Http\Controllers\API\Bookin_deadlineController;
use App\Http\Controllers\AuthController;
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
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])-> middleware('auth:sanctum');
Route::get('/me', [AuthController::class, 'index'])->middleware('auth:sanctum');
Route::get('/post/list', [PostController::class, 'index'])->middleware('auth:sanctum');

Route::get('/service/list', [ServiceController::class, 'index']);
Route::get('/category/list', [CategoryController::class, 'index']);
Route::resource('/booking',BookingController::class);
Route::resource('/bookin_immediatly',Bookin_memediatelyController::class);
Route::resource('/bookin_deadline',Bookin_deadlineController::class);

