<?php
return [
    'auth' => \Src\Auth\Auth::class,
    'identity' => \Model\User::class,
    'routeMiddleware' => [
        'auth' => \Middlewares\AuthMiddleware::class,
        'admin' => \Middlewares\AdminMiddleware::class,
        'sysadmin' => \Middlewares\SysAdminMiddleware::class,
        'bearer' => \Middlewares\BearerMiddleware::class,
    ],
    'validators' => [
        'required' => \Validators\RequireValidator::class,
        'unique' => \Validators\UniqueValidator::class
    ],
    'routeAppMiddleware' => [
        'csrf' => \Middlewares\CSRFMiddleware::class,
        'specialChars' => \Middlewares\SpecialCharsMiddleware::class,
        'trim' => \Middlewares\TrimMiddleware::class,
        'json' => \Middlewares\JSONMiddleware::class,
    ],
    'providers' => [
        'kernel' => \Providers\KernelProvider::class,
        'route'  => \Providers\RouteProvider::class,
        'db'     => \Providers\DBProvider::class,
        'auth'   => \Providers\AuthProvider::class,
    ],
];