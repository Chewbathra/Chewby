<?php

use Chewbathra\Chewby\Facades\Config;
use Chewbathra\Chewby\Tests\Datasets\Controllers\FlightController;
use Chewbathra\Chewby\Tests\Datasets\Controllers\PostController;
use Chewbathra\Chewby\Tests\Datasets\Models\Flight;
use Chewbathra\Chewby\Tests\Datasets\Models\Post;

test('getConfig() should return correct value', function () {
    $result = 'test';
    expect(Config::getConfig('base')->first())->toBe($result);
});

test('getTrackedModels() should return all tracked models', function () {
    $result = [
        Post::class,
        Flight::class,
    ];
    expect(Config::getTrackedModels()->all())->toBe($result);
});

test('getTrackedModelsWithPath() should return all tracked models with their correct path', function () {
    $result = [
        Post::class => 'posts',
        Flight::class => 'flights',
    ];
    expect(Config::getTrackedModelsWithPath()->all())->toEqual($result);
});

test('getControllerForModel() should return correct controller for given model', function () {
    $post = new Post();
    $flight = new Flight();
    $postController = new PostController();
    $flightController = new FlightController();
    expect(Config::getControllerForModel($post::class))->toEqual($postController);
    expect(Config::getControllerForModel($post))->toEqual($postController);
    expect(Config::getControllerForModel($flight::class))->toEqual($flightController);
    expect(Config::getControllerForModel($flight))->toEqual($flightController);
});

test('getTrackedModelsWithControllers() should return all tracked models with their corresponding controllers', function () {
    $resultWithObject = [
        Post::class => new PostController(),
        Flight::class => new FlightController(),
    ];
    $resultWithClassName = [
        Post::class => PostController::class,
        Flight::class => FlightController::class,
    ];
    expect(Config::getTrackedModelsWithControllers(false)->all())->toEqual($resultWithObject);
    expect(Config::getTrackedModelsWithControllers(true)->all())->toEqual($resultWithClassName);
});
