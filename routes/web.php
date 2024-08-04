<?php

use App\Models\Course;
use App\Models\Planification;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\BanksController;
use App\Http\Controllers\CourseUserController;
use App\Http\Controllers\PlanificationController;

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
    Route::get('/matriculation', [CourseUserController::class, 'Index'])
    ->name('courses-user.index');

    Route::post('/create-matriculation/{course}', [CourseUserController::class, 'Matriculation'])
    ->name('courses-user.matriculation');

    Route::get('/course-details/{course}', [CourseUserController::class, 'details'])
    ->name('courses.details');

    //------------------------------------------------------------------------

        /**
     * Planificación
     */
    Route::get('/planification', [PlanificationController::class, 'index'])
    ->name('planification.index');

    Route::post('/create-planification', [PlanificationController::class, 'store'])
    ->name('planification.create');

    Route::get('/show-planification/{course}', [PlanificationController::class, 'details'])
    ->name('planification.details');

    Route::get('/planification/{id}/edit', [PlanificationController::class, 'edit'])
    ->name('planification.edit');

    Route::post('/planification/{id}/update', [PlanificationController::class, 'update'])
    ->name('planification.update');

    Route::get('/configurate-planification/{planification}', [PlanificationController::class, 'configurate'])
    ->name('planification.configurate');

    Route::get('/plans', [PlanificationController::class, 'getPlansByCourse']);

    Route::delete('/delete-planification/{planification}', [PlanificationController::class, 'destroy'])
    ->name('planification.delete');

    //------------------------------------------------------------------------

    /**
     * Banks
     */
    Route::get('/add-bank/', [BanksController::class, 'create'])->name('bank.add');
    Route::post('/store-bank', [BanksController::class, 'store'])->name('bank.store');
    Route::get('/partials/{type}', [BanksController::class, 'loadPartialView']);
    Route::post('/receive-json', [BanksController::class, 'receiveJson'])->name('receive-json');

    // web.php (para peticiones a través de un navegador)
    Route::get('/edit-bank/{banks}', [BanksController::class, 'edit'])->name('bank.edit');
    Route::post('/save-bank', [BanksController::class, 'update'])->name('bank.update');
    Route::delete('/delete-bank/{banks}', [BanksController::class, 'destroy'])->name('bank.delete');

    /**
     * Test
     */
    Route::post('save-test', [TestController::class, 'store'])->name('store.test');
});
