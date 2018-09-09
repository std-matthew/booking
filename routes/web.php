<?php

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

Route::get('/', 'BookingController@index')->name('booking.index');
Route::post('book/check-date', 'BookingController@checkDate')->name('book.checkdate');
Route::post('book/fetch/events', 'BookingController@fetchEvents')->name('fetch.events');


Route::post('book/location', 'BookingLocationController@store')->name('book.location');
Route::post('booking/locations/fetch', 'BookingLocationFetchController@fetch')->name('fetch.locations');


Route::post('book/type', 'BookingTypeController@store')->name('book.type');
Route::post('booking/categories/fetch', 'BookingCategoryFetchController@fetch')->name('fetch.categories');


Route::post('book/time', 'BookingTimeController@store')->name('book.time');
Route::post('booking/times/fetch', 'BookingTimeFetchController@fetch')->name('fetch.times');


Route::post('invoice/store', 'InvoiceController@store')->name('invoice.store');
Route::post('invoice/fetch', 'InvoiceFetchController@fetch')->name('fetch.invoice');


Route::post('invoice-item/store', 'InvoiceItemController@store')->name('invoice_item.store');
Route::delete('invoice-item/{invoiceItem}/remove', 'InvoiceItemController@destroy')->name('invoice_item.destroy');




