<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\ClientController;
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

    });

    Route::prefix('branch')->group(function () {
        Route::get('/', [BranchController::class, 'index'])->name('branches.index');
        Route::post('/create', [BranchController::class, 'store'])->name('branches.store');
    });

    Route::prefix('client')->group(function () {
        Route::get('/', [ClientController::class, 'index'])->name('users.index');
        Route::get('/{client}', [ClientController::class, 'show'])->name('clients.show');

        Route::put('/update-account/{client}', [ClientController::class, 'update'])->name('clients.update');
        Route::put('/update-profile/{client}', [ClientController::class, 'updateProfile'])->name('clients.updateProfile');

        Route::post('/create', [ClientController::class, 'store'])->name('clients.store');

    });
});
