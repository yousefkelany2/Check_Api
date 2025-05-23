<?php

use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/dasbord', function () {
    return view("dashbord.layout.main");
});

Route::resource("user",UserController::class);

