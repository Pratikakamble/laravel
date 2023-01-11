<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
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

Route::get('/', [StudentController::class, 'index'])->name('students');


Route::post('/save-students/', [StudentController::class, 'saveStudents'])->name('savestudents');
Route::get('/edit-student/{id}', [StudentController::class, 'editStudent'])->name('editstudent');
Route::post('/update-student/{id}', [StudentController::class, 'updateStudent'])->name('updatestudent');
Route::get('/delete-student/{id}', [StudentController::class, 'deleteStudent'])->name('deletestudent');
