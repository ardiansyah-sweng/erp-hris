<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/jobrole/edit', function () {
    $jobrole = (object)[
        'id' => 1,
        'name' => 'Admin',
        'description' => 'Mengelola sistem'
    ];

    return view('jobrole.edit', compact('jobrole'));
});
