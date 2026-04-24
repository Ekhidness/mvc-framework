<?php
use Src\Route;

Route::add('POST', '/login', [Controller\ApiController::class, 'login']);

Route::group('/api', function () {
    Route::add('GET', '/', [Controller\ApiController::class, 'index']);
    Route::add('GET', '/subscribers', [Controller\ApiController::class, 'subscribers'])->middleware('bearer');
    Route::add('GET', '/phones', [Controller\ApiController::class, 'phones'])->middleware('bearer');
    Route::add('GET', '/departments', [Controller\ApiController::class, 'departments'])->middleware('bearer');
});