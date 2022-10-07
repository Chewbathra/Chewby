<?php

use Chewbathra\Chewby\Tests\Datasets\Controllers\TestPostController;
use Chewbathra\Chewby\Tests\Datasets\Models\TestPost;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->controller = new TestPostController();
    $this->model = new TestPost();
//    TestPost::factory()->create(10);
});

it('should return correct view for index', function () {
    $result = view('chewby::models.index', [
        'resource' => $this->model::class,
    ]
    );
    expect($this->controller->index())->toEqual($result);
});
