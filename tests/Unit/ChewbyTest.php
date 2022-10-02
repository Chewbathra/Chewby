<?php

use Chewbathra\Chewby\Facades\Chewby;
use Illuminate\Support\Facades\Route;

test('generateUrls() should generate index, show and delete URLs for each tracked models', function () {
    $routerMock = \Pest\Laravel\partialMock(\Illuminate\Routing\Route::class);
    Route::shouldReceive('get')
        ->times(4)
        ->andReturn($routerMock);
    Route::shouldReceive('delete')
        ->times(2)
        ->andReturn($routerMock);
    Chewby::generateUrls();
});
