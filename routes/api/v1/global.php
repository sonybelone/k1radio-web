<?php

use App\Http\Controllers\Api\V1\GlobalController;
use App\Http\Controllers\Api\V1\Settings\BasicSettingsController;
use Illuminate\Support\Facades\Route;

    Route::controller(BasicSettingsController::class)->group(function(){
        Route::get('basic-settings','basicSettings');
        Route::get("languages","getLanguages");
        Route::get('splash-screen','splashScreen');
        Route::get('onboard-screen','onboardScreen');
    });

    Route::controller(GlobalController::class)->group(function(){
        Route::get('team','team');
        Route::get('gallery','gallery');
        Route::get('show/schedules','showSchedule');
        Route::get('live/show','liveShow');
    });
?>
