<?php

namespace Chewbathra\Chewby\Http\Livewire\Models;

use Chewbathra\Chewby\Facades\Config;
use Chewbathra\Chewby\Models\Model;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Table extends Component
{
    public Model $model;

    public array $columns;

    public string $search = '';

    public string $orderTerm = 'id';

    public string $orderDirection = 'ASC';

    public function mount(string|Model $resource): void
    {
        if (! is_subclass_of($resource, Model::class)) {
            throw new \Error("Given class $resource dont extend ".Model::class);
        }
        $this->model = new $resource;
        $controller = Config::getControllerForModel($this->model);
        $this->columns = $controller->getIndexColumns();
    }

    public function setOrder(string $term): void
    {
        if ($term == $this->orderTerm) {
            $this->orderDirection = $this->orderDirection == 'ASC' ? 'DESC' : 'ASC';
        } else {
            $this->orderTerm = $term;
            $this->reset('orderDirection');
        }
    }

    public function render(): View
    {
        $models = $this->model::select(array_keys($this->columns))
            ->where('title', 'like', $this->search.'%')
            ->orderBy($this->orderTerm, $this->orderDirection)
            ->get();
        /**
         * @phpstan-ignore-next-line
         */
        return view('chewby::components.livewire.models.table', ['models' => $models]);
    }
}
