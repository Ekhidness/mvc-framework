<?php
use Src\Route;

Route::add('GET', '/', [Controller\Site::class, 'index'])->middleware('auth');

Route::add(['GET', 'POST'], '/login', [Controller\AuthController::class, 'login']);
Route::add('GET', '/logout', [Controller\LogoutController::class, 'logout']);
Route::add(['GET', 'POST'], '/signup', [Controller\RegistrationController::class, 'signup']);

Route::add('GET', '/hello', [Controller\Site::class, 'hello'])->middleware('auth');

Route::group('/admin', function () {
    Route::add('GET', '/users', [Controller\UserController::class, 'index'])->middleware('admin');
    Route::add(['GET', 'POST'], '/users/create', [Controller\UserController::class, 'create'])->middleware('admin');
});

Route::group('/sys', function () {
    Route::add('GET', '/departments', [Controller\DepartmentController::class, 'index'])->middleware('sysadmin');
    Route::add(['GET', 'POST'], '/departments/create', [Controller\DepartmentController::class, 'create'])->middleware('sysadmin');

    Route::add('GET', '/rooms', [Controller\RoomController::class, 'index'])->middleware('sysadmin');
    Route::add(['GET', 'POST'], '/rooms/create', [Controller\RoomController::class, 'create'])->middleware('sysadmin');

    Route::add('GET', '/subscribers', [Controller\SubscriberController::class, 'index'])->middleware('sysadmin');
    Route::add(['GET', 'POST'], '/subscribers/create', [Controller\SubscriberController::class, 'create'])->middleware('sysadmin');
    Route::add('GET', '/subscribers/phones', [Controller\SubscriberController::class, 'phones'])->middleware('sysadmin');

    Route::add('GET', '/phones', [Controller\PhoneController::class, 'index'])->middleware('sysadmin');
    Route::add(['GET', 'POST'], '/phones/create', [Controller\PhoneController::class, 'create'])->middleware('sysadmin');
    Route::add(['GET', 'POST'], '/phones/attach', [Controller\PhoneController::class, 'attach'])->middleware('sysadmin');
    Route::add('GET', '/phones/by-department', [Controller\PhoneController::class, 'byDepartment'])->middleware('sysadmin');
});