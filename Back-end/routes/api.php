<?php

use App\Http\Controllers\Admin\DiscountController;
use App\Http\Controllers\Admin\MailSettingController;
use App\Http\Controllers\API\NotificationController;
use App\Http\Controllers\API\PostController;
use App\Http\Controllers\API\ServiceController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\BookingController;
use App\Http\Controllers\API\Bookin_memediatelyController;
use App\Http\Controllers\API\Bookin_deadlineController;
use App\Http\Controllers\Api\PromotionService;
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

Route::get('/service',[ServiceController::class, 'index'])->name('service');
Route::get('/discount',[PromotionService::class, 'index'])->name('service');

Route::get('/promotion',[PromotionService::class, 'index'])->name('promotion');
// Route::get('/promotion',[PromotionService::class, 'index'])->name('promotion');
Route::post('/promotion/create', [PromotionService::class, 'store'])->name('promotion.create');
Route::get('/promotion/show/{id}', [PromotionService::class, 'show'])->name('promotion.show');
Route::put('/promotion/update/{id}', [PromotionService::class, 'update'])->name('promotion.update');
Route::delete('/promotion/delete/{id}', [PromotionService::class, 'destroy'])->name('promotion.delete');

// Notifications

Route::get('/notification',[NotificationController::class,'index'])->name('notification');
Route::get('/notification/show/{id}',[NotificationController::class, 'show']);
Route::post('/notification/create', [NotificationController::class,'store'])->name('notification.create');
Route::put('/notification/update/{id}', [NotificationController::class,'update']);
Route::delete('/notification/delete/{id}', [NotificationController::class,'destroy']);

Route::get('/mail',[MailSettingController::class,'index'])->name('mail.index');


// Route::get('/notification', [NotificationController::class, 'index'])->name('admin.notification.index')->middleware('can:Notification access');


// Route::get('/discounts', [DiscountController::class, 'showDiscounts'])->name('discounts');
