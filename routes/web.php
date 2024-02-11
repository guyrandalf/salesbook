<?php

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RepController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('authenticate');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'store'])->name('register.store');
Route::get('/forgot-password', [AuthController::class, 'forgot'])->name('password');
Route::post('/forgot-password', [AuthController::class, 'forgotPass'])->name('password.reset');

Route::middleware(['auth'])->group(function () {
    Route::get('/sales-rep', [RepController::class, 'index'])->name('rep.dashboard');
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');

    // Products Route Starts
    Route::get('/admin/products', [AdminController::class, 'products'])->name('admin.products');
    Route::post('/admin/product/store', [AdminController::class, 'storeProduct'])->name('product.store');
    Route::post('/admin/product/stock', [AdminController::class, 'productStock'])->name('product.stock');
    Route::delete('/admin/product/{id}', [AdminController::class, 'deleteProduct'])->name('product.delete');
    // Products Route Ends

    // Stock Route Starts
    Route::get('/admin/stock', [AdminController::class, 'stock'])->name('admin.stock');
    Route::delete('/admin/stock/{id}', [AdminController::class, 'deleteStock'])->name('stock.delete');
    // Stock Route Ends

    // Change Sale Status
    Route::post('/admin/complete-sale/{transactionId}', [AdminController::class, 'completeSale'])->name('complete.sale');

    //Get Quantity for sale
    Route::get('/get-stock-quantity/{productId}', [RepController::class, 'getStockQuantity']);


    // Sales Reps Starts
    Route::get('/admin/rep', [AdminController::class, 'rep'])->name('admin.rep');
    Route::delete('/admin/rep/{id}', [AdminController::class, 'deleterep'])->name('rep.delete');
    // Sales Reps Ends



    /**
     * REPS ACTIONS ROUTES
     */
    Route::post('/sales-rep', [RepController::class, 'store'])->name('sale.store');

    // Stock Route Starts
    Route::get('/sales-rep/stock', [RepController::class, 'stock'])->name('rep.stock');
    // Stock Route Ends

    // All Users Settings
    Route::get('/user/setting', [UserController::class, 'index'])->name('user.setting');
    Route::post('/user/setting/edit', [UserController::class, 'update'])->name('user.update');

    Route::get('/logout', [Controller::class, 'logout'])->name('logout');
});
