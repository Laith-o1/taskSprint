<?php

use App\Http\Controllers\admin\auth\AuthController;
use App\Http\Controllers\admin\employee\CRUDController;
use App\Http\Controllers\employee\auth\AuthController as AuthAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
// admin routes
Route::group(['prefix' => 'admin/'], function() {
    Route::post('login', [AuthController::class, 'login'])->name('login');
});
Route::group(['middleware'=>['auth:admin-api'], 'prefix' => 'admin/'], function() {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('employee/create', [CRUDController::class, 'create'])->name('employee.create');
});
// employee routes
Route::group(['prefix' => 'employee/'], function() {
    Route::post('login', [AuthAuthController::class, 'login'])->name('login');
});
Route::group(['middleware'=>['auth:employee-api'], 'prefix' => 'employee/'], function() {
    Route::post('logout', [AuthAuthController::class, 'logout'])->name('logout');
});