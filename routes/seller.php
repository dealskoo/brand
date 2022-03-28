<?php

use Illuminate\Support\Facades\Route;
use Dealskoo\Brand\Http\Controllers\Seller\BrandController;

Route::middleware(['web', 'seller_locale'])->prefix(config('seller.route.prefix'))->name('seller.')->group(function () {

    Route::middleware(['guest:seller'])->group(function () {

    });

    Route::middleware(['auth:seller', 'verified:seller.verification.notice', 'seller_active'])->group(function () {

        Route::resource('brands', BrandController::class)->except(['show']);

        Route::middleware(['password.confirm:seller.password.confirm'])->group(function () {

        });
    });
});
