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

    // departments
    Route::resource('departments', 'App\Http\Controllers\DepartmentsController');

    // job titles
    Route::resource('jobtitles', 'App\Http\Controllers\JobtitlesController');

    // usertypes
    Route::resource('usertypes', 'App\Http\Controllers\UsertypesController');

    // users
    Route::resource('users', 'App\Http\Controllers\UsersManagementController');
    Route::resource('deleted-users', 'App\Http\Controllers\SoftDeleteUsersController');

    // allocations
    Route::resource('allocations', 'App\Http\Controllers\AllocationsController');
    Route::get('import-allocation','App\Http\Controllers\AllocationsController@allocationImportForm');
    Route::get('bulk-allocation','App\Http\Controllers\AllocationsController@bulkAllocationForm');
    Route::post('bulk-allocate-send','App\Http\Controllers\AllocationsController@bulkAllocationInsert');
    Route::post('bulk-allocation-post','App\Http\Controllers\AllocationsController@bulkAllocationPost');
    Route::post('allocation-import-send','App\Http\Controllers\AllocationsController@allocationImportSend');
    Route::get('all-alloctions','App\Http\Controllers\AllocationsController@allAllocations');
    Route::get('/department-users/{department}','App\Http\Controllers\AllocationsController@getDepartmentalUsers');
    Route::resource('deleted-allocations', 'App\Http\Controllers\SoftDeleteAllocations');

    // jobcards
    Route::resource('jobcards', 'App\Http\Controllers\JobcardsController');

    //distributions
    Route::resource('fdistributions', 'App\Http\Controllers\FoodDistributionsController');
    Route::get('bulk-food-form','App\Http\Controllers\FoodDistributionsController@bulkFoodDistribution');
    Route::post('bulk-food-upload','App\Http\Controllers\FoodDistributionsController@bulkFoodUpload');
    Route::get('food-import','App\Http\Controllers\FoodDistributionsController@getDisttibutionImport');
    Route::post('food-import-send','App\Http\Controllers\FoodDistributionsController@fdistributionImportSend');
    Route::get('/get-allocation/{paynumber}','App\Http\Controllers\FoodDistributionsController@getAllocation');
    Route::get('add-collection/{id}','App\Http\Controllers\FoodDistributionsController@addCollection')->name('add-collection');
    Route::get('multi-insert','App\Http\Controllers\FoodDistributionsController@multiInsert');
    Route::post('multi-insert-post','App\Http\Controllers\FoodDistributionsController@multiInsertPost');
    Route::get('searchallocation', 'App\Http\Controllers\FoodDistributionsController@searchResponse');

    Route::resource('mdistributions', 'App\Http\Controllers\MeetDistributionsController');

    // collections
    Route::resource('fcollection', 'App\Http\Controllers\FoodCollectionController');
    Route::get('get-fdistribution/{paynumber}','App\Http\Controllers\FoodCollectionController@getFdistribution');

    Route::get('/getname/{paynumber}','App\Http\Controllers\AllocationsController@getName');
    Route::get('/getTitles/{department}','App\Http\Controllers\JobtitlesController@getTitles');
    Route::get('/getdepartment/{paynumber}','App\Http\Controllers\FoodDistributionsController@getDepartment');
    Route::get('/getusername/{paynumber}','App\Http\Controllers\FoodDistributionsController@getUsername');

    // Reports
    Route::get('jobcard-report','App\Http\Controllers\ReportsController@jobcardReport');
    Route::post('jobcard-report-post','App\Http\Controllers\ReportsController@jobcardReportPost');
    Route::get('month-report','App\Http\Controllers\ReportsController@getMonthlyReport');
    Route::post('month-report-post','App\Http\Controllers\ReportsController@getMonthlyReportPost');
    Route::get('user-report','App\Http\Controllers\ReportsController@getUserReport');
    Route::post('user-report-post','App\Http\Controllers\ReportsController@getUserReportPost');
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
