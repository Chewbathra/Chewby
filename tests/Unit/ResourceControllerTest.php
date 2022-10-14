<?php

use Chewbathra\Chewby\Http\Controllers\Admin\ResourceController;
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
    $this->types = collect([
        // Needed columns
        'id' => 'bigInteger',
        'title' => 'string',
        'online' => 'boolean',
        'online_from' => 'dateTime',
        'online_until' => 'dateTime',
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
        // Soft delete (not mandatory)
        'deleted_at' => 'timestamp',
        // Added columns
        'description' => 'wysiwyg',
        'editor' => 'editor',
    ]);
});

it('should return correct view for index action', function () {
    $postResult = view('chewby::models.index', [
        'resource' => Post::class,
    ]);
    $flightResult = view('chewby::models.index', [
        'resource' => Flight::class,
    ]);
    expect($this->postController->index())->toEqual($postResult);
    expect($this->flightController->index())->toEqual($flightResult);
});

it('should return correct view for show action', function () {
    $postResult = view('chewby::models.show', [
        'model' => Post::find(1),
        'types' => $this->types,
    ]);
    $flightResult = view('chewby::models.show', [
        'model' => Flight::find(8),
        'types' => $this->types,
    ]);
    expect($this->postController->show(1))->toEqual($postResult);
    expect($this->flightController->show(8))->toEqual($flightResult);
});

it('should correctly delete model for delete action', function () {
    $this->postController->destroy(4);
    $this->flightController->destroy(8);
    expect(Post::all()->count())->toEqual(9);
    expect(Post::find(4))->toEqual(null);
    expect(Flight::all()->count())->toEqual(19);
    expect(Flight::find(8))->toEqual(null);
});

it('should correctly update model', function () {
    $attributes = [
        'title' => 'Update title',
        'online' => 1,
        'online_from' => '1010-10-10 10:10:10',
        'online_until' => '1010-10-10 10:10:10',
        'description' => 'Update description',
    ];
    $request = new \Illuminate\Http\Request();
    $request->setMethod('PATCH');
    $request->request->add($attributes);

    $this->postController->update($request, 1);
    $postAttributes = Post::find(1)->getAttributes();
    $this->flightController->update($request, 8);
    $flightAttributes = Flight::find(8)->getAttributes();
    foreach ($attributes as $attribute => $value) {
        expect($postAttributes[$attribute])->toBe($value);
        expect($flightAttributes[$attribute])->toBe($value);
    }
});

test('getIndexColumns() should return indexColumns and neededColumns merged', function () {
    $postControllerResult = [
        'id' => [
            'label' => 'ID',
            'render' => null,
            'centered' => true,
        ],
        'title' => [
            'label' => 'Title',
            'render' => null,
        ],
        'online' => [
            'label' => 'Online',
            'render' => [ResourceController::class, 'renderOnline'],
            'centered' => true,
        ],
        'online_from' => [
            'label' => 'Publication date',
            'render' => [ResourceController::class, 'renderOnlineFrom'],
            'centered' => true,
        ],
        'description' => [
            'label' => 'Description',
            'render' => null,
        ],
    ];
    $flightControllerResult = [
        'id' => [
            'label' => 'ID',
            'render' => null,
            'centered' => true,
        ],
        'title' => [
            'label' => 'Title',
            'render' => null,
        ],
        'online' => [
            'label' => 'Online',
            'render' => [ResourceController::class, 'renderOnline'],
            'centered' => true,
        ],
        'online_from' => [
            'label' => 'Publication date',
            'render' => [ResourceController::class, 'renderOnlineFrom'],
            'centered' => true,
        ],
    ];
    expect($this->postController->getIndexColumns())->toBe($postControllerResult);
    expect($this->flightController->getIndexColumns())->toBe($flightControllerResult);
});

test('getModelTypes() should return types for given model', function () {
    expect($this->postController->getModelTypes(new Post()))->toEqual($this->types);
    expect($this->flightController->getModelTypes(new Flight()))->toEqual($this->types);
});

test('getModel() should return correct model associated to current controller', function () {
    expect($this->postController->getModel())->toBe(Post::class);
    expect($this->flightController->getModel())->toBe(Flight::class);
    expect($this->postController->getModel(true))->toEqual(new Post());
    expect($this->flightController->getModel(true))->toEqual(new Flight());
});
