<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
    return view('auth.login');
});

Auth::routes();

// Public routes files
Route::group(['middleware' => ['web','activity']], function () {

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

});

// admin routes
Route::group(['middleware' => ['web','activity','role:admin']], function () {

    Route::resource('departments', 'App\Http\Controllers\DepartmentsController');

    Route::resource('jobtitles', 'App\Http\Controllers\JobtitlesController');

    Route::resource('usertypes', 'App\Http\Controllers\UsertypesController');

    Route::resource('users', 'App\Http\Controllers\UsersManagementController');

    Route::resource('allocations', 'App\Http\Controllers\AllocationsController');
    Route::get('bulk-allocation','App\Http\Controllers\AllocationsController@bulkAllocationForm');
    Route::post('bulk-allocate-send','App\Http\Controllers\AllocationsController@bulkAllocationInsert');

    Route::resource('jobcards', 'App\Http\Controllers\JobcardsController');

    Route::resource('fdistributions', 'App\Http\Controllers\FoodDistributionsController');

    Route::resource('mdistributions', 'App\Http\Controllers\MeetDistributionsController');

    Route::get('/getname/{paynumber}','App\Http\Controllers\AllocationsController@getName');
    Route::get('/getTitles/{department}','App\Http\Controllers\JobtitlesController@getTitles');
    Route::get('/getdepartment/{paynumber}','App\Http\Controllers\FoodDistributionsController@getDepartment');
    Route::get('/getusername/{paynumber}','App\Http\Controllers\FoodDistributionsController@getUsername');
});

Route::group(['prefix' => 'activity', 'namespace' => 'jeremykenedy\LaravelLogger\App\Http\Controllers', 'middleware' => ['web', 'auth', 'activity','role:admin']], function () {

    // Dashboards
    Route::get('/', 'LaravelLoggerController@showAccessLog')->name('activity');
    Route::get('/cleared', ['uses' => 'LaravelLoggerController@showClearedActivityLog'])->name('cleared');

    // Drill Downs
    Route::get('/log/{id}', 'LaravelLoggerController@showAccessLogEntry');
    Route::get('/cleared/log/{id}', 'LaravelLoggerController@showClearedAccessLogEntry');

    // Forms
    Route::delete('/clear-activity', ['uses' => 'LaravelLoggerController@clearActivityLog'])->name('clear-activity');
    Route::delete('/destroy-activity', ['uses' => 'LaravelLoggerController@destroyActivityLog'])->name('destroy-activity');
    Route::post('/restore-log', ['uses' => 'LaravelLoggerController@restoreClearedActivityLog'])->name('restore-activity');
});