<?php

use Chewbathra\Chewby\Facades\Chewby;
use Chewbathra\Chewby\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;

// Dont generate URLs when running "php artisan vendor:publish" because config file may be not created
// It can generate errors that prevent publishing
// if (! App::runningInConsole() || ($_SERVER['argv'][0] === "artisan" && $_SERVER['argv'][1] !== "vendor:publish")) {
Chewby::generateUrls();
// }

Route::get('/admin/dashboard', [DashboardController::class, 'dashboard'])
    ->name('admin.dashboard');
