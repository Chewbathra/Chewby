<?php

namespace Chewbathra\Chewby\Tests\Datasets\Controllers;

use Chewbathra\Chewby\Http\Controllers\Admin\ResourceController;

class TestPostController extends ResourceController
{
    public string $resourceName = 'testPost';

    public string $resourcePath = 'testPosts';
}
