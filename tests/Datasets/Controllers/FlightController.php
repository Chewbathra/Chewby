<?php

namespace Chewbathra\Chewby\Tests\Datasets\Controllers;

use Chewbathra\Chewby\Http\Controllers\Admin\ResourceController;

class FlightController extends ResourceController
{
    public string $resourceName = 'Flight';

    public string $resourcePath = 'flights';
}
