<?php

use App\Http\Controllers\Api\v1\Client\auth\LoginController;
use App\Http\Controllers\Api\v1\Client\company\CompanyController;
use App\Http\Controllers\Api\v1\Client\employee\EmployeeController;
use App\Http\Controllers\Api\v1\Client\project\ProjectController;
use App\Http\Controllers\Api\v1\Client\tasks\TasksController;
use Illuminate\Support\Facades\Route;



Route::post('/auth/login',LoginController::class);


Route::middleware('auth:sanctum')->group(function(){
    
Route::apiResource('/companies',CompanyController::class);
Route::apiResource('/projects',ProjectController::class);
Route::apiResource('/tasks', TasksController::class)->names([
    'index' => 'task.index',
    'store' => 'task.store',
    'show' => 'task.show',
    'update' => 'task.update',
    'destroy' => 'task.destroy',
]);

Route::apiResource('/employees',EmployeeController::class);

});