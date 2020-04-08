<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/','MainController@home');
Route::post('/menu','MainController@menu');
Route::post('/collect_client_device_data','MainController@collect_client_device_data');
Route::post('/ring_the_bell','MainController@ring_the_bell');
Route::get('/get_data_to_display','MainController@get_data_to_display');

Route::get('/admin','AdminController@migrate_client');
Route::get('/get_client_data','AdminController@send_client_data');
Route::get('/get_visit_data_by_fingerprint','AdminController@send_visit_data_by_fingerprint');
