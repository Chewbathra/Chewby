<?php

namespace Chewbathra\Chewby\Tests\Datasets\Controllers;

use Chewbathra\Chewby\Http\Controllers\Admin\ResourceController;

class PostController extends ResourceController
{
    public string $resourceName = 'Post';

    public string $resourcePath = 'posts';

    protected array $indexColumns = [
        'description' => [
            'label' => 'Description',
            'render' => null,
        ],
    ];
}
