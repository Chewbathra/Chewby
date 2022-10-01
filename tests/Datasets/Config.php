<?php

use Chewbathra\Chewby\Tests\Datasets\Controllers\TestPostController;
use Chewbathra\Chewby\Tests\Datasets\Models\TestPost;
use Chewbathra\Chewby\Tests\Datasets\Models\TestPost2;

dataset('chewbyConfig', [
    'base' => 'testBase',
    'date_format' => 'Y-m-d',
    'models' => [
        TestPost::class,
        TestPost2::class,
    ],
    'controllers' => [
        TestPost::class => TestPostController::class,
    ],
]);
