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
$baseController= new BaseController();
$baseController->checkRole();



// Define routes

// auth routes 
Route::get('/', [BaseController::class, 'index']);
Route::get('/unauthorized', [BaseController::class, 'unauthorized']);

Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/handleRegister', [AuthController::class, 'handleRegister']);
Route::get('/login', [AuthController::class, 'showleLogin']);
Route::post('/handleLogin', [AuthController::class, 'handleLogin']);
Route::get('/logout', [AuthController::class, 'logout']);


// dashboard routes
Route::get('/admin/dashboard', [BaseController::class, 'dashboard']);
Route::get('/teacher/dashboard', [BaseController::class, 'dashboard']);
Route::get('/student/dashboard', [BaseController::class, 'dashboard']);

// Dispatch the request
$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);



