<?php

use App\Http\Controllers\API\CommentController;
use App\Http\Controllers\API\CompanyController;
use App\Http\Controllers\API\UserController;
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


Route::apiResources([
    'users' => UserController::class,
    'comments' => CommentController::class,
    'companies' => CompanyController::class
]);

Route::get('/companies/{company}/comments', [CompanyController::class, 'comments']);
Route::get('/companies/{company}/grade', [CompanyController::class, 'grade']);
Route::get('/rating', [CompanyController::class, 'rating']);
