<?php

use App\Http\Controllers\AccountantController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\OpenCourseController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post("/login", [AdminController::class, "login"]);
Route::middleware('auth:sanctum')->group(function () {

    Route::post("/logout", [AdminController::class, "logout"]);

    Route::controller(AdminController::class)->prefix('/admin')->group(function () {
        Route::post('/add-user', 'createUser');
        Route::put('/edit-user/{id}', 'updateUser');
        Route::get('/view-user', 'viewUsers');

        Route::post('/add-course', 'createCourse');
        Route::get('/view-course', 'viewCourses');

        Route::post('/add-open-course', 'createOpenCourse');

    });
    Route::get('/view-open-course/{courseId}', [OpenCourseController::class, 'view']);


    Route::controller(EnrollmentController::class)
        ->prefix('/enrollment')->group(function () {

            Route::post('/create', 'create');
            Route::get('/paid-view', 'paidEnrollment');
            Route::get('/unpaid-view', 'unpaidEnrollment');
        });

    Route::controller(TeacherController::class)
        ->prefix('/teacher')->group(function () {

            Route::get('/', 'getOpenCoursesTeacher');
            Route::get('/get-lesson/{openCourseId}', 'getLesson');
            Route::post('/add-lesson', 'createLesson');
        });
    Route::controller(AccountantController::class)
        ->prefix('/accountant')->group(function () {

            Route::get('/students', 'getStudents');
            Route::post('/add-payment', 'addPayment');
        });

    Route::prefix('/receptionist')->group(function () {
        Route::get('/view/open-courses', [OpenCourseController::class, 'viewOpenCourses']);
        Route::controller(StudentController::class)->group(function (){
            Route::get('/view/student/{openCourseId}', 'view');
            Route::get('/search/student', 'search');
            Route::get('/add/student', 'add');
        });
    });

});
