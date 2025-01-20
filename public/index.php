<?php
session_start();
require_once __DIR__ . '/../vendor/autoload.php';

require_once ('../core/BaseController.php');
require_once '../core/Router.php';
require_once '../core/Route.php';

require_once '../app/controllers/AuthController.php';
require_once '../app/controllers/StudentController.php';
require_once '../app/controllers/AdminController.php';
require_once '../app/controllers/TeacherController.php';


$router = new Router();
Route::setRouter($router);
$baseController= new BaseController();
$baseController->checkRole();

// m1
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Define routes

Route::get('/', [BaseController::class, 'index']);
Route::get('/unauthorized', [BaseController::class, 'unauthorized']);

// auth routes
// =========================================================================================================================================== 
Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/handleRegister', [AuthController::class, 'handleRegister']);
Route::get('/login', [AuthController::class, 'showleLogin']);
Route::post('/handleLogin', [AuthController::class, 'handleLogin']);
Route::get('/logout', [AuthController::class, 'logout']);


// admin routes
// =========================================================================================================================================== 
Route::get('/admin/dashboard', [BaseController::class, 'dashboard']);
// users managmet routes
Route::get('/admin/users', [AdminController::class, 'users']);
Route::post('/admin/deleteUser/{user_id}', [AdminController::class, 'deleteUser']);
Route::post('/admin/changeUserStatus/{user_id}', [AdminController::class, 'changeUserStatus']);

// inactive teachers managemt routes
Route::get('/admin/inactiveTeachers', [AdminController::class, 'inactiveTeachers']);
Route::post('/admin/activateTeacher/{user_id}', [AdminController::class, 'activateTeacher']);

// categories managmet routes
Route::get('/admin/categories', [AdminController::class, 'categories']);
Route::post('/admin/addCategory', [AdminController::class, 'addCategory']);
Route::post('/admin/editCategory/{categoryId}', [AdminController::class, 'editCategory']);
Route::post('/admin/deleteCategory/{user_id}', [AdminController::class, 'deleteCategory']);

// tags managment routes
Route::get('/admin/tags', [AdminController::class, 'tags']);
Route::post('/admin/addTag', [AdminController::class, 'addTag']);
Route::post('/admin/editTag/{tagId}', [AdminController::class, 'editTag']);
Route::post('/admin/deleteTag/{tag_id}', [AdminController::class, 'deleteTag']);

// couese managment
Route::get('/admin/courses', [AdminController::class, 'AllCourses']);
Route::post('/admin/deletCourse/{course_id}', [AdminController::class, 'deletCourse']);



// teacher routes
// =========================================================================================================================================== 
Route::get('/teacher/dashboard', [BaseController::class, 'dashboard']);
Route::get('/teacher/addCourse', [TeacherController::class, 'addCourseView']);
Route::post('/teacher/SubmitAddCourse', [TeacherController::class, 'SubmitAddCourse']);
Route::get('/teacher/myCourses', [TeacherController::class, 'teacherCourses']);
Route::post('/teacher/deletCourse/{course_id}', [TeacherController::class, 'deletCourse']);
Route::get('/teacher/editeCourse/{course_id}', [TeacherController::class, 'editeCourse']);
Route::post('/teacher/SubmitEditCourse/{course_id}', [TeacherController::class, 'SubmitEditCourse']);
Route::get('/teacher/enrollments/{course_id}', [TeacherController::class, 'classEnrollments']);
Route::post('/teacher/acceptEnrollment/{enrollment_id}', [TeacherController::class,'acceptEnrollment']);





// student routes
// =========================================================================================================================================== 
Route::get('/student/dashboard', [BaseController::class, 'dashboard']);
Route::get('/student/courses', [StudentController::class, 'courses']);
Route::post('/student/enroll/{course_id}', [StudentController::class, 'enroll']);

// Dispatch the request
$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);



