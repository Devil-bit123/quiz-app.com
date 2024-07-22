<?php

use App\Http\Controllers\CourseUserController;
use App\Http\Controllers\PlanificationController;
use App\Models\Course;
use App\Models\Planification;
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

Route::get('/', function () {
    return view('welcome');
});


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();

    /**
     * Matriculacion
     */
    Route::get('/index-matriculation', [CourseUserController::class, 'Index'])
    ->name('courses-user.index');

    Route::post('/create-matriculation/{course}', [CourseUserController::class, 'Matriculation'])
    ->name('courses-user.matriculation');

    Route::get('/course-details/{course}', [CourseUserController::class, 'details'])
    ->name('courses.details');

    //------------------------------------------------------------------------

        /**
     * Planificación
     */
    Route::get('/index-planification', [PlanificationController::class, 'index'])
    ->name('planification.index');

    Route::post('/create-planification', [PlanificationController::class, 'store'])
    ->name('planification.create');

    Route::get('/show-planification/{course}', [PlanificationController::class, 'details'])
    ->name('planification.details');



    //------------------------------------------------------------------------


});
