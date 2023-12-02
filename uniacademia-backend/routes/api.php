<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\Knowledge_areaController;
use App\Http\Controllers\ProfessorController;
use App\Http\Controllers\StudentController;
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

Route::apiResource('courses', CourseController::class);
Route::apiResource('knowledge_areas', Knowledge_areaController::class);
Route::apiResource('students', StudentController::class);
Route::apiResource('professors', ProfessorController::class);