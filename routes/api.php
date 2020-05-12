<?php


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', 'AuthController@Login');
Route::post('/register', 'AuthController@register');


 //Recursos publicos
    Route::get('/specialties', 'SpecialtyController@index');
    Route::get('/specialties/{specialty}/doctors', 'SpecialtyController@doctors');
    Route::get('/schedule/hours', 'ScheduleController@hours');

Route::middleware('auth:api')->group(function () {
    Route::get('/user', 'UserController@show');
    Route::post('/logout','AuthController@logOut');

    //post appointment. Para registrar una cita
    Route::post('/appointments', 'AppointmentController@store');

    //Appointments. Obtención de las citas
    Route::get('/appointments', 'AppointmentController@index');
});
