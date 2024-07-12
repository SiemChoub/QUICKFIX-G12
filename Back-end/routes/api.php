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

Route::get('/post/list', [PostController::class, 'index'])->middleware('auth:sanctum');
Route::put('/profile/update/{id}', [AuthController::class, 'update'])->middleware('auth:sanctum');

Route::get('/service/list', [ServiceController::class, 'index']);
Route::get('/category/list', [CategoryController::class, 'index']);
Route::resource('/booking',BookingController::class)->middleware('auth:sanctum');

Route::post('/bookin_immediatly', [Bookin_memediatelyController::class, 'store']);
Route::get('/bookin_immediatly/{id}', [Bookin_memediatelyController::class, 'show'])->middleware('auth:sanctum');
Route::put('/bookin_immediatly/{id}', [Bookin_memediatelyController::class, 'update'])->middleware('auth:sanctum');
Route::delete('/bookin_immediatly/{id}', [Bookin_memediatelyController::class, 'destroy'])->middleware('auth:sanctum');

Route::resource('/bookin_deadline',Bookin_deadlineController::class)->middleware('auth:sanctum');
Route::resource('/fixing_progressing',FixingProgressController::class)->middleware('auth:sanctum');

Route::get('/service',[AuthController::class, 'index'])->name('service');
Route::get('/discount',[PromotionService::class, 'index'])->name('service');

Route::get('/promotion',[PromotionService::class, 'index'])->name('promotion');
// Route::get('/promotion',[PromotionService::class, 'index'])->name('promotion');
Route::post('/promotion/create', [PromotionService::class, 'store'])->name('promotion.create');
Route::get('/promotion/show/{id}', [PromotionService::class, 'show'])->name('promotion.show');
Route::put('/promotion/update/{id}', [PromotionService::class, 'update'])->name('promotion.update');
Route::delete('/promotion/delete/{id}', [PromotionService::class, 'destroy'])->name('promotion.delete');


// --------------------- chat --------------------
Route::get('/booking', [BookingController::class, 'index']);

// Chat routes
Route::get('/chat/list', [ChatController::class, 'index']);
Route::post('/chat/create', [ChatController::class, 'store']);
Route::get('/chat/show/{id}', [ChatController::class, "show"]);
Route::put('/chat/update/{id}', [ChatController::class, "update"]);
Route::delete('/chat/delete/{id}', [ChatController::class, "destroy"]);


// --------------- fixer in progress -------------//
Route::post('/fixer/accept', [FixingProgressController::class, 'store']);
Route::get('/fixer/accepted/{id}', [FixingProgressController::class, 'show']);
Route::delete('/fixer/cancel/{id}', [FixingProgressController::class, 'cancelAccept']);
Route::post('/fixer/start/{id}', [FixingProgressController::class, 'startFixer']);

Route::get('/chats/{sender_id}/{receiver_id}', [ChatController::class, 'getChatsBySenderAndReceiver']);
