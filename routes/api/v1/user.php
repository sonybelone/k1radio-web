<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\User\ProfileController;
use App\Http\Controllers\Api\V1\User\DashboardController;

    Route::controller(DashboardController::class)->group(function(){
        Route::get('dashboard','index');
        Route::get('notification','notification');
        Route::post('logout','logout');
    });

    Route::controller(ProfileController::class)->group(function(){
        Route::get('user/profile','index');
        Route::post('password/update','passwordUpdate')->name('password.update')->middleware(['app.mode']);
        Route::post('update','update')->middleware(['app.mode']);
        Route::post('delete-account','deleteProfile')->middleware('app.mode');
    });
