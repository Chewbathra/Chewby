<?php

use Chewbathra\Chewby\Tests\Datasets\Controllers\PostController;
use Chewbathra\Chewby\Tests\Datasets\Models\Flight;
use Chewbathra\Chewby\Tests\Datasets\Models\Post;

dataset('config', [
    'base' => 'test',
    'date_format' => 'Y-m-d',
    'models' => [
        Post::class,
        Flight::class,
    ],
    'controllers' => [
        Post::class => PostController::class,
    ],
]);
