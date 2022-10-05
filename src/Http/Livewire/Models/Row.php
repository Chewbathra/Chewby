<?php

namespace Chewbathra\Chewby\Http\Livewire\Models;

use Chewbathra\Chewby\Facades\Config;
use Chewbathra\Chewby\Http\Controllers\Admin\ResourceController;
use Chewbathra\Chewby\Models\Model;
use Livewire\Component;

class Row extends Component
{
    public Model $model;

    public array $columns;

    public function render()
    {
        /** @var ResourceController $controllers */
        $controllers = Config::getControllerForModel($this->model);
        return view('chewby::components.livewire.models.row', ["route" => "admin." . $controllers->resourcePath . ".delete"]);
    }
}
