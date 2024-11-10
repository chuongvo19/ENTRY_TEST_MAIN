<?php

use App\Http\Controllers\Admin\BookingController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TopController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\Admin\TopController as AdminTopController;
use App\Http\Controllers\Admin\HotelController as AdminHotelController;

/** user screen */
Route::get('/', [TopController::class, 'index'])->name('top');
Route::get('/{prefecture_name_alpha}/hotellist', [HotelController::class, 'showList'])->name('hotelList');
Route::get('/hotel/{hotel_id}', [HotelController::class, 'showDetail'])->name('hotelDetail');

/** admin screen prefix */
Route::prefix('admin')->group(function() {
    /** admin screen */

    /** Controller AdminTopController */
    Route::controller(AdminTopController::class)->group(function() {
        Route::get('/', 'index')->name('adminTop');
    });

    /** Controller AdminHotelController */
    Route::prefix('hotel')->controller(AdminHotelController::class)->group(function() {
        Route::get('/search', 'showSearch')->name('adminHotelSearchPage');
        Route::get('/edit', 'showEdit')->name('adminHotelEditPage');
        Route::get('/create', 'showCreate')->name('adminHotelCreatePage');
        Route::get('/cancel', 'cancelEdit')->name('adminHotelCancelProcess');
        Route::post('/search/result', 'searchResult')->name('adminHotelSearchResult');
        Route::post('/edit', 'edit')->name('adminHotelEditProcess');
        Route::post('/create', 'create')->name('adminHotelCreateProcess');
        Route::post('/delete', 'delete')->name('adminHotelDeleteProcess');
        Route::post('/confirm', 'confirm')->name('adminHotelConfirmProcess');
    });
    
    /** Controller BookingController */
    Route::prefix('booking')->controller(BookingController::class)->group(function() {
        Route::get('/search', 'showSearch')->name('adminBookingSearchPage');
        Route::post('/search/result', 'searchResult')->name('adminBookingSearchResult');
    });
});