<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\Product\ProductCategoryController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Service\ServiceCategoryController;
use App\Http\Controllers\Service\ServiceController;
use App\Http\Controllers\UserController;
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

Route::get('/ping', function (Request $request) {
    $data = array("test" => "testResponse");
    return response()->json($data, 200);
});

Route::prefix('auth')->group(function () {
    Route::post('/signup', [AuthController::class, 'signup'])->name('auth.signup');
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');

});


Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('user')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('users.index');
        Route::get('/{user}', [UserController::class, 'show'])->name('users.show');

        Route::put('/update-account/{user}', [UserController::class, 'update'])->name('users.update');
        Route::put('/update-profile/{user}', [UserController::class, 'updateProfile'])->name('users.updateProfile');


        Route::post('/create', [UserController::class, 'store'])->name('users.store');
        Route::post('/upload-profile-image', [UserController::class, 'uploadProfileImage'])->name('users.uploadProfileImage');

    });

    Route::prefix('branch')->group(function () {
        Route::get('/', [BranchController::class, 'index'])->name('branches.index');
        Route::post('/create', [BranchController::class, 'store'])->name('branches.store');
        Route::post('/upload-profile-image', [BranchController::class, 'uploadProfileImage'])->name('branches.uploadProfileImage');

    });

    Route::prefix('client')->group(function () {
        Route::get('/', [ClientController::class, 'index'])->name('users.index');
        Route::get('/{client}', [ClientController::class, 'show'])->name('clients.show');

        Route::put('/update-account/{client}', [ClientController::class, 'update'])->name('clients.update');
        Route::put('/update-profile/{client}', [ClientController::class, 'updateProfile'])->name('clients.updateProfile');

        Route::post('/create', [ClientController::class, 'store'])->name('clients.store');

    });

    Route::prefix('product')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('product.index');

        Route::post('/create', [ProductController::class, 'store'])->name('product.store');
        Route::post('/create-category', [ProductCategoryController::class, 'store'])->name('productCategory.store');

    });

    Route::prefix('service')->group(function () {

        Route::get('/', [ServiceController::class, 'index'])->name('service.index');


        Route::post('/create', [ServiceController::class, 'store'])->name('service.store');
        Route::post('/create-category', [ServiceCategoryController::class, 'store'])->name('serviceCategory.store');

    });
});
