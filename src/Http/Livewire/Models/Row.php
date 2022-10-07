<?php

namespace Chewbathra\Chewby\Http\Livewire\Models;

use Chewbathra\Chewby\Facades\Config;
use Chewbathra\Chewby\Http\Controllers\Admin\ResourceController;
use Chewbathra\Chewby\Models\Model;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Row extends Component
{
    public Model $model;

    public array $columns;

    public function render(): View
    {
        /** @var ResourceController $controllers */
        $controllers = Config::getControllerForModel($this->model);
        $base = Config::getConfig('base')->first();

        /**
         * @phpstan-ignore-next-line
         */
        return view('chewby::components.livewire.models.row', ['routeNames' => [
            'delete' => $base.'.'.$controllers->resourcePath.'.delete',
            'show' => $base.'.'.$controllers->resourcePath.'.show',
        ]]);
    }
}
