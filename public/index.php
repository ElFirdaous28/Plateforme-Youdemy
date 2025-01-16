<?php
session_start();

require_once ('../core/BaseController.php');
require_once '../core/Router.php';
require_once '../core/Route.php';

require_once '../app/controllers/AuthController.php';
require_once '../app/controllers/StudentController.php';
require_once '../app/controllers/AdminController.php';
require_once '../app/controllers/TeacherController.php';


$router = new Router();
Route::setRouter($router);



// Define routes

// auth routes 
Route::get('/', [BaseController::class, 'index']);

Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/handleRegister', [AuthController::class, 'handleRegister']);
Route::get('/login', [AuthController::class, 'showleLogin']);
Route::post('/handleLogin', [AuthController::class, 'handleLogin']);


// student routes
Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);
Route::get('/teacher/dashboard', [TeacherController::class, 'dashboard']);
Route::get('/student/dashboard', [StudentController::class, 'dashboard']);

// Dispatch the request
$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);



