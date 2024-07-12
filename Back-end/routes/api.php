<?php

use App\Http\Controllers\Admin\API\UserController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\API\PostController;
use App\Http\Controllers\API\ServiceController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\BookingController;
use App\Http\Controllers\API\Bookin_memediatelyController;
use App\Http\Controllers\API\Bookin_deadlineController;
use App\Http\Controllers\Api\PromotionService;
use App\Http\Controllers\Api\FixingProgressController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\API\ChatController;
use App\Http\Controllers\API\FixerController;
use App\Http\Controllers\API\PromotionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
Route::put('/update/{id}', [AuthController::class, 'updateInformation'])-> middleware('auth:sanctum');
Route::post('/update/profile/{id}', [AuthController::class, 'updateProfile'])->middleware('auth:sanctum');

Route::get('/fixer/list', [FixerController::class, 'index']);

Route::get('/service/list', [ServiceController::class, 'index']);
Route::get('/category/list', [CategoryController::class, 'index']);
Route::resource('/booking',BookingController::class);
Route::resource('/bookin_immediatly',Bookin_memediatelyController::class);
Route::resource('/bookin_deadline',Bookin_deadlineController::class);
Route::resource('/fixing_progressing',FixingProgressController::class);

Route::get('/service',[AuthController::class, 'index'])->name('service');
Route::get('/discount',[PromotionController::class, 'index'])->name('service');

Route::get('/promotion',[PromotionController::class, 'index'])->name('promotion');
// Route::get('/promotion',[PromotionController::class, 'index'])->name('promotion');
Route::post('/promotion/create', [PromotionController::class, 'store'])->name('promotion.create');
Route::get('/promotion/show/{id}', [PromotionController::class, 'show'])->name('promotion.show');
Route::put('/promotion/update/{id}', [PromotionController::class, 'update'])->name('promotion.update');
Route::delete('/promotion/delete/{id}', [PromotionController::class, 'destroy'])->name('promotion.delete');

// --------------------------------- promotion API --------------------------------

Route::get('/promotion/list', [PromotionController::class, 'index']);


// Chat routes
Route::get('/chat/list', [ChatController::class, 'index']);
Route::post('/chat/create', [ChatController::class, 'store']);
Route::get('/chat/show/{id}', [ChatController::class, "show"]);
Route::put('/chat/update/{id}', [ChatController::class, "update"]);
Route::delete('/chat/delete/{id}', [ChatController::class, "destroy"]);