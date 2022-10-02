<?php

use Chewbathra\Chewby\Facades\Config;
use Chewbathra\Chewby\Tests\Datasets\Controllers\TestPost2Controller;
use Chewbathra\Chewby\Tests\Datasets\Controllers\TestPostController;
use Chewbathra\Chewby\Tests\Datasets\Models\TestPost;
use Chewbathra\Chewby\Tests\Datasets\Models\TestPost2;

test('getConfig() should return correct value', function () {
    $result = 'testBase';
    expect(Config::getConfig('base')->first())->toBe($result);
});

test('getTrackedModels() should return all tracked models', function () {
    $result = [
        TestPost::class,
        TestPost2::class,
    ];
    expect(Config::getTrackedModels()->all())->toBe($result);
});

test('getControllerForModel() should return correct controller for given model', function () {
    expect(Config::getControllerForModel(TestPost::class))->toEqual(new TestPostController());
    expect(Config::getControllerForModel(new TestPost()))->toEqual(new TestPostController());
    expect(Config::getControllerForModel(TestPost2::class))->toEqual(new TestPost2Controller());
    expect(Config::getControllerForModel(new TestPost2()))->toEqual(new TestPost2Controller());
});

test('getTrackedModelsWithPath() should return all tracked models with their correct path', function () {
    $result = [
        TestPost::class => 'testPosts',
        TestPost2::class => 'testPosts2',
    ];
    expect(Config::getTrackedModelsWithPath()->all())->toEqual($result);
});
