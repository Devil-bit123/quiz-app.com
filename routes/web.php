<?php

use App\Http\Controllers\BanksController;
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

    // web.php (o el archivo de rutas correspondiente)
    Route::get('/planification/{id}/edit', [PlanificationController::class, 'edit'])
    ->name('planification.edit');
    Route::post('/planification/{id}/update', [PlanificationController::class, 'update'])
    ->name('planification.update');

    Route::post('/configurate-planification/{planification}', [PlanificationController::class, 'configurate'])
    ->name('planification.configurate');

    Route::get('/plans', [PlanificationController::class, 'getPlansByCourse']);

    //------------------------------------------------------------------------

    /**
     * Banks
     */
    Route::get('/add-bank/', [BanksController::class, 'create'])->name('bank.add');
    Route::post('/store-bank', [BanksController::class, 'store'])->name('bank.store');
    Route::get('/partials/{type}', [BanksController::class, 'loadPartialView']);
    Route::post('/receive-json', [BanksController::class, 'receiveJson'])->name('receive-json');

});
