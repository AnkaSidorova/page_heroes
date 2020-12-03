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

//Route form displaying our form
Route::get('/', 'ImageController@dropzoneform');

//Rout for submitting the form datat
Route::post('/storedata', 'ImageController@storeData')->name('form.data');

//Route for submitting dropzone data
Route::post('/storeimgae', 'ImageController@storeImage');


