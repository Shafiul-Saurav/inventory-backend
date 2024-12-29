<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\StaffController;
use App\Http\Controllers\Api\SalaryController;
use App\Http\Controllers\Api\ExpenseController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\SupplierController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\SystemSettingController;
use App\Http\Controllers\Api\ExpenseCategoryController;
use App\Http\Controllers\Api\OrderController;

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

    //Dashboard Info
    Route::get('/dashboard', [DashboardController::class, 'index']);

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

    // Customer Route
    Route::get('/allCustomers', [CustomerController::class, 'allCustomers']);
    Route::get('/customerStatus/{id}', [CustomerController::class, 'status']);
    Route::apiResource('/customers', CustomerController::class);

    // Staff Route
    Route::get('/allStaffs', [StaffController::class, 'allStaffs']);
    Route::get('/staffStatus/{id}', [StaffController::class, 'status']);
    Route::apiResource('/staffs', StaffController::class);

    // Product Route
    Route::get('/allProducts', [ProductController::class, 'allProducts']);
    Route::get('/productStatus/{id}', [ProductController::class, 'status']);
    Route::apiResource('/products', ProductController::class);

    //Expense Category Route
    Route::get('/allExpenseCategories', [ExpenseCategoryController::class, 'allExpenseCategories']);
    Route::get('/expenseCategoryStatus/{id}', [ExpenseCategoryController::class, 'status']);
    Route::apiResource('/expenseCategories', ExpenseCategoryController::class);

    //Expense Route
    Route::get('/allExpenses', [ExpenseController::class, 'allExpenses']);
    Route::get('/expenseStatus/{id}', [ExpenseController::class, 'status']);
    Route::apiResource('/expenses', ExpenseController::class);

    //Salary Route
    Route::get('/allSalaries', [SalaryController::class, 'allSalaries']);
    Route::apiResource('/salaries', SalaryController::class);

    //Cart Route
    Route::get('/allCartItems', [CartController::class, 'allCartItems']);
    Route::post('/addToCart', [CartController::class, 'addToCart']);
    Route::get('/removeFromCart/{id}', [CartController::class, 'removeFromCart']);
    Route::get('/increaseItemQty/{id}', [CartController::class, 'increaseItemQty']);
    Route::get('/decreaseItemQty/{id}', [CartController::class, 'decreaseItemQty']);

    //Order Route
    Route::get('/allOrders', [OrderController::class, 'allOrders']);
    Route::apiResource('/orders', OrderController::class)->only(['index', 'store', 'show']);
});
