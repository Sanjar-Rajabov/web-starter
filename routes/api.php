<?php

use App\Http\Controllers\Api\ApplicationController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\PageController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\SectionController;
use Illuminate\Support\Facades\Route;

Route::prefix('sections')->controller(SectionController::class)->group(function () {
    Route::get('{page}', [SectionController::class, 'getOne']);
});

Route::prefix('application')->controller(ApplicationController::class)->group(function () {
    Route::post('/application', 'application');
    Route::post('/order', 'order');
});

Route::prefix('category')->controller(CategoryController::class)->group(function () {
    Route::get('', 'getAll');
});

Route::prefix('product')->controller(ProductController::class)->group(function () {
    Route::get('', 'getAll');
    Route::get('{id}', 'getOne');
});

Route::prefix('pages')->controller(PageController::class)->group(function () {
    Route::get('/home', 'home');
});
