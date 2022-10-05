<?php

namespace Chewbathra\Chewby\Tests\Datasets\Controllers;

use Chewbathra\Chewby\Http\Controllers\Admin\ResourceController;

class TestPost2Controller extends ResourceController
{
    public string $resourceName = 'testPost2';

    public string $resourcePath = 'testPosts2';
}
