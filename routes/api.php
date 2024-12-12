<?php

use App\Http\Controllers\Api\BrandController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\SupplierController;
use App\Http\Controllers\Api\SystemSettingController;

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

Route::post('/login', [LoginController::class, 'login']);

Route::middleware('auth:sanctum')->group(function(){
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    //System Setting Route
    Route::apiResource('/system-setting', SystemSettingController::class)->only(['index', 'update']);

    // Category Route
    Route::get('/allCategories', [CategoryController::class, 'allCategories']);
    Route::get('/categoryStatus/{id}', [CategoryController::class, 'status']);
    Route::apiResource('/categories', CategoryController::class);

    // Brand Route
    Route::get('/allBrands', [BrandController::class, 'allBrands']);
    Route::get('/brandStatus/{id}', [BrandController::class, 'status']);
    Route::apiResource('/brands', BrandController::class);

    // Supplier Route
    Route::get('/allSuppliers', [SupplierController::class, 'allSuppliers']);
    Route::get('/supplierStatus/{id}', [SupplierController::class, 'status']);
    Route::apiResource('/suppliers', SupplierController::class);
});
