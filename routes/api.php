<?php

use App\Http\Controllers\admin\auth\AuthController;
use App\Http\Controllers\admin\employee\CRUDController;
use App\Http\Controllers\admin\profile\CrudController as ProfileCrudController;
use App\Http\Controllers\admin\task\CRUDController as TaskCRUDController;
use App\Http\Controllers\admin\task\FilterController;
use App\Http\Controllers\employee\auth\AuthController as AuthAuthController;
use App\Http\Controllers\employee\profile\CrudController as EmployeeProfileCrudController;
use App\Http\Controllers\employee\task\CrudController as EmployeeTaskCrudController;
use App\Http\Controllers\employee\task\FilterController as TaskFilterController;
use App\Http\Controllers\example\exampleController;
use App\Http\Controllers\shared\listsController;
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
    Route::get('employees', [CRUDController::class, 'index'])->name('employee.index');
    Route::post('employee/create', [CRUDController::class, 'create'])->name('employee.create');
    Route::patch('employee/update/{id}', [CRUDController::class, 'update'])->name('employee.update');
    Route::delete('employee/delete/{id}', [CRUDController::class, 'delete'])->name('employee.delete');
    Route::get('tasks', [TaskCRUDController::class, 'index'])->name('task.index');
    Route::post('task/create', [TaskCRUDController::class, 'create'])->name('task.create');
    Route::patch('task/update/{id}', [TaskCRUDController::class, 'update'])->name('task.update');
    Route::delete('task/delete/{id}', [TaskCRUDController::class, 'delete'])->name('task.delete');
    Route::get('task/priority/{id}', [FilterController::class, 'findByPriorityId'])->name('task.priority');
    Route::get('task/employee/{id}', [FilterController::class, 'findByEmployeeId'])->name('task.employee');
    Route::get('task/status/{status}', [FilterController::class, 'findByStatus'])->name('task.status');
    // update profile
    Route::patch('profile/update', [ProfileCrudController::class, 'update'])->name('profile.update');
    // update profile avatar
    Route::patch('profile/update/avatar', [ProfileCrudController::class, 'updateAvatar'])->name('profile.update.avatar');


});
// employee routes
Route::group(['prefix' => 'employee/'], function() {
    Route::post('login', [AuthAuthController::class, 'login'])->name('login');
});
Route::group(['middleware'=>['auth:employee-api'], 'prefix' => 'employee/'], function() {
    Route::post('logout', [AuthAuthController::class, 'logout'])->name('logout');
    Route::get('tasks', [EmployeeTaskCrudController::class, 'index'])->name('task.index');
    Route::post('task/update/{id}', [EmployeeTaskCrudController::class, 'update'])->name('task.update');
    // fitler tasks
    Route::get('task/priority/{id}', [TaskFilterController::class, 'findByPriorityId'])->name('task.priority');
    Route::get('task/status/{status}', [TaskFilterController::class, 'findByStatus'])->name('task.status');
    // update profile
    Route::post('profile/update', [EmployeeProfileCrudController::class, 'update'])->name('profile.update');
    // update profile avatar
    Route::post('profile/update/avatar', [EmployeeProfileCrudController::class, 'updateAvatar'])->name('profile.update.avatar');

});
// shared routes
Route::group(['prefix' => 'shared/'], function() {
    Route::get('priorities', [listsController::class, 'Priorities'])->name('priorities');
    Route::get('statues', [listsController::class, 'Statues'])->name('statues');
    Route::get('students',[exampleController::class,'mock'])->name('Showstudents');
});