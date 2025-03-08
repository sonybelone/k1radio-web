<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::controller(HomeController::class)->name('frontend.')->group(function() {
    // home controller related all methods
    Route::get('/','index')->name('index')->middleware('check_page:home');
    Route::get('/about','aboutView')->name('about')->middleware('check_page:about');
    Route::get('/contact','contactView')->name('contact')->middleware('check_page:contact');
    Route::get('/gallery','galleryView')->name('gallery')->middleware('check_page:gallery');
    Route::get('/team','teamView')->name('team')->middleware('check_page:team');
    Route::get('/blog','blogView')->name('blog')->middleware('check_page:blog');
    Route::get('/blog-details/{id}/{slug}','blogDetailsView')->name('blog.details');
    Route::get('/blog-by-category/{id}/{slug}','blogByCategoryView')->name('blog.by.category');
    Route::get('/page/{slug}','usefulPage')->name('useful.link');
    Route::post('contact/message/store', 'contactMessageStore')->name('contact.message.store');
    Route::post('subscribers/store', 'subscribersStore')->name('subscribers.store');
    Route::post('/language/switch', 'languageSwitch')->name('language.switch');
});



//// php artisan migrate:fresh --seed
//q*X18i2t0  sony@k1media.co
