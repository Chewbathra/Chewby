<?php

use Chewbathra\Chewby\Tests\Datasets\Controllers\FlightController;
use Chewbathra\Chewby\Tests\Datasets\Controllers\PostController;
use Chewbathra\Chewby\Tests\Datasets\Models\Flight;
use Chewbathra\Chewby\Tests\Datasets\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->postController = new PostController();
    $this->flightController = new FlightController();
    Post::factory()->count(10)->create();
    Flight::factory()->count(20)->create();
});

it('should return correct view for index action', function () {
    $result = view('chewby::models.index', [
        'resource' => Post::class,
    ]);
    $result2 = view('chewby::models.index', [
        'resource' => Flight::class,
    ]);
    expect($this->postController->index())->toEqual($result);
    expect($this->flightController->index())->toEqual($result2);
});

it('should return correct view for show action', function () {
    $result = view('chewby::models.show', [
        'model' => Post::find(1),
    ]);
    $result2 = view('chewby::models.show', [
        'model' => Flight::find(8),
    ]);
    expect($this->postController->show(1))->toEqual($result);
    expect($this->flightController->show(8))->toEqual($result2);
});

it('should correctly delete model for delete action', function () {
    $this->postController->destroy(4);
    $this->flightController->destroy(8);
    expect(Post::all()->count())->toEqual(9);
    expect(Post::find(4))->toEqual(null);
    expect(Flight::all()->count())->toEqual(19);
    expect(Flight::find(8))->toEqual(null);
});
