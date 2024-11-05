<?php

use App\Http\Controllers\Admin\ApplicationController;
use App\Http\Controllers\Admin\Auth\AuthController;
use App\Http\Controllers\Admin\Auth\ProfileController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SectionController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->name('admin.auth.')->group(function () {
    Route::match(['get', 'post'], '/login', [AuthController::class, 'login'])->middleware('guest')->name('login');
    Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');
});

Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/', function () {
        return redirect()->route('admin.section.view', 'home');
    })->name('home');

    Route::prefix('section')->name('section.')->group(function () {
        Route::get('{page}', [SectionController::class, 'index'])->name('view');
        Route::post('{page}', [SectionController::class, 'update'])->name('update');
    });

    Route::prefix('application')->name('application.')->group(function () {
        Route::get('application', [ApplicationController::class, 'application'])->name('application');
        Route::get('order', [ApplicationController::class, 'order'])->name('order');
        Route::delete('/{application}', [ApplicationController::class, 'delete'])->name('delete');
    });

    Route::prefix('category')->name('category.')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('index');
        Route::match(['get', 'post'], '/create', [CategoryController::class, 'create'])->name('create');
        Route::match(['get', 'post'], '/update/{category}', [CategoryController::class, 'update'])->name('update');
        Route::delete('/delete/{category}', [CategoryController::class, 'delete'])->name('delete');
    });

    Route::prefix('product')->name('product.')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('index');
        Route::match(['get', 'post'], '/create', [ProductController::class, 'create'])->name('create');
        Route::match(['get', 'post'], '/update/{product}', [ProductController::class, 'update'])->name('update');
        Route::delete('/delete/{product}', [ProductController::class, 'delete'])->name('delete');
    });

    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('index');
        Route::post('/', [ProfileController::class, 'index'])->name('update');
    });
});
