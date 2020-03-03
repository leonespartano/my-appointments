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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::middleware(['auth', 'admin'])->namespace('Admin')->group(function () {
    //Specialty
    Route::get('/specialties', 'SpecialtyController@index');
    Route::get('/specialties/create', 'Admin\SpecialtyController@create'); //se visita la pagina de registro
    Route::get('/specialties/{specialty}/edit', 'Admin\SpecialtyController@edit');

    Route::post('/specialties', 'SpecialtyController@store'); //envio de formulario de registro para crear
    Route::put('/specialties/{specialty}', 'SpecialtyController@update'); //envio de registro actualizado
    Route::delete('/specialties/{specialty}', 'SpecialtyController@destroy'); //envio de registro actualizado

    // Doctors
    Route::resource('doctors', 'DoctorController');


    //patients
    Route::resource('patients', 'PatientController');
});

Route::middleware(['auth', 'doctor'])->namespace('Doctor')->group(function () {
    Route::get('/schedule','ScheduleController@edit');
    Route::post('/schedule','ScheduleController@store');
});
