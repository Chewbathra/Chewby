<?php

use Chewbathra\Chewby\Facades\Chewby;
use Chewbathra\Chewby\Tests\Datasets\Models\Flight;
use Chewbathra\Chewby\Tests\Datasets\Models\Post;
use Illuminate\Support\Facades\Route;

test('generateUrls() should generate index, show and delete URLs for each tracked models', function () {
    Chewby::generateUrls();
    $routes = Route::getRoutes();
    foreach (['posts', 'flights'] as $modelUrlPath) {
        $this->assertTrue($routes->hasNamedRoute('test.'.$modelUrlPath.'.index'));
        $this->assertTrue($routes->hasNamedRoute('test.'.$modelUrlPath.'.show'));
        $this->assertTrue($routes->hasNamedRoute('test.'.$modelUrlPath.'.delete'));
        $this->assertTrue($routes->hasNamedRoute('test.'.$modelUrlPath.'.create'));
    }
});

test('routeNameForModel() should return correct route name for given model and action', function () {
    foreach ([
        'posts' => new Post(),
        'flights' => new Flight(),
    ] as $key => $model) {
        foreach (['show', 'index', 'update', 'delete'] as $action) {
            expect(Chewby::routeNameForModel($model, $action))->toBe("test.$key.$action");
        }
    }
});
