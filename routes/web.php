<?php

use App\Http\Controllers\Apps\Master\FormController;
use App\Http\Controllers\Apps\Master\ReportController;
use Illuminate\Support\Facades\App;
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

//route home
Route::get('/', function () {
    return \Inertia\Inertia::render('Auth/Login');
})->middleware('guest');

//prefix "apps"
Route::prefix('apps')->group(function() {

    //middleware "auth"
    Route::group(['middleware' => ['auth']], function () {

        //route dashboard
        Route::get('dashboard', \App\Http\Controllers\Apps\DashboardController::class)->name('apps.dashboard');

        Route::resource('/roles', \App\Http\Controllers\Apps\RoleController::class, ['as' => 'apps']);
            // ->middleware('permission:roles.index|roles.create|roles.show|roles.edit|roles.delete');
        
        Route::resource('/users', \App\Http\Controllers\Apps\UserController::class, ['as' => 'apps'])
            ->middleware('permission:users.index|users.create|users.edit|roles.delete');

        Route::get('/master/forms', [FormController::class, 'index'])->name('apps.master.forms.index');

        Route::get('/master/forms/create', [FormController::class, 'create'])->name('apps.master.forms.create');

        Route::post('/master/forms/new_form', [FormController::class, 'create_form'])->name('apps.master.forms.new_form');

        Route::get('/master/forms/{form:slug}/show', [FormController::class, 'show'])->name('apps.master.forms.show');

        Route::post('/master/forms/new_data', [FormController::class, 'create_data'])->name('apps.master.forms.new_data');

        Route::post('/master/forms/update_data', [FormController::class, 'update_data'])->name('apps.master.forms.update_data');

        Route::delete('/master/forms/{form:slug}/delete_data/{id}', [FormController::class, 'delete_data']);
        
        Route::post('/master/forms/add_column', [FormController::class, 'add_column'])->name('apps.master.forms.add_column');

        Route::get('/master/reports ', [ReportController::class, 'index'])->name('apps.master.reports.index');

        Route::get('/master/reports/{form:slug}/show', [ReportController::class, 'show'])->name('apps.master.reports.show');

        Route::get('/master/reports/{form:slug}/filter', [ReportController::class, 'generate_report'])->name('apps.master.reports.filter');

        Route::get('/master/reports/{form:slug}/export', [ReportController::class, 'export'])->name('apps.master.reports.export');
    });
});