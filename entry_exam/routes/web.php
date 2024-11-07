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

/** admin screen */
Route::get('/admin', [AdminTopController::class, 'index'])->name('adminTop');

Route::get('/admin/hotel/search', [AdminHotelController::class, 'showSearch'])->name('adminHotelSearchPage');

Route::get('/admin/hotel/edit', [AdminHotelController::class, 'showEdit'])->name('adminHotelEditPage');

Route::get('/admin/hotel/create', [AdminHotelController::class, 'showCreate'])->name('adminHotelCreatePage');

Route::get('admin/hotel/cancel', [AdminHotelController::class, 'cancelEdit'])->name('adminHotelCancelProcess');

Route::get('admin/booking/search', [BookingController::class, 'showSearch'])->name('adminBookingSearchPage');

Route::post('/admin/hotel/search/result', [AdminHotelController::class, 'searchResult'])->name('adminHotelSearchResult');

Route::post('/admin/booking/search/result', [BookingController::class, 'searchResult'])->name('adminBookingSearchResult');

Route::post('/admin/hotel/edit', [AdminHotelController::class, 'edit'])->name('adminHotelEditProcess');

Route::post('/admin/hotel/create', [AdminHotelController::class, 'create'])->name('adminHotelCreateProcess');

Route::post('/admin/hotel/delete', [AdminHotelController::class, 'delete'])->name('adminHotelDeleteProcess');

Route::post('admin/hotel/confirm', [AdminHotelController::class, 'confirm'])->name('adminHotelConfirmProcess');