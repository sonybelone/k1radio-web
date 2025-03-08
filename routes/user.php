<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\SupportTicketController;

Route::prefix("user")->name("user.")->group(function(){
    Route::controller(DashboardController::class)->group(function(){
        Route::get('/','index')->name('dashboard');
        Route::post('logout','logout')->name('logout');
    });

    Route::controller(ProfileController::class)->prefix("profile")->name("profile.")->group(function(){
        Route::get('/','index')->name('index');
        Route::put('password/update','passwordUpdate')->name('password.update')->middleware(['app.mode']);
        Route::post('update','update')->name('update')->middleware(['app.mode']);
        Route::post('delete-account/{id}','deleteAccount')->name('delete')->middleware(['app.mode']);
    });

    Route::controller(SupportTicketController::class)->prefix("prefix")->name("support.ticket.")->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('create', 'create')->name('create');
        Route::post('store', 'store')->name('store');
        Route::get('conversation/{encrypt_id}','conversation')->name('conversation');
        Route::post('message/send','messageSend')->name('messaage.send');
    });

});
