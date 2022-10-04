<?php

namespace Chewbathra\Chewby\Http\Livewire\Models;

use App\Models\User;
use Chewbathra\Chewby\Facades\Config;
use Chewbathra\Chewby\Models\Model;
use Livewire\Component;

class Table extends Component
{
    public Model $model;
    public array $columns;
    public string $search = '';
    public string $orderTerm = "id";
    public string $orderDirection = "ASC";

    public function mount(string|Model $resource)
    {
        if (!is_subclass_of($resource, Model::class)) {
            throw new \Error("Given class $resource dont extend " . Model::class);
        }
        $this->model = new $resource;
        $controller = Config::getControllerForModel($this->model);
        $this->columns = $controller->getIndexColumns();
    }

    public function setOrder(string $term)
    {
        if ($term == $this->orderTerm) {
            $this->orderDirection = $this->orderDirection == "ASC" ? "DESC" : "ASC";
        } else {
            $this->orderTerm = $term;
            $this->reset('orderDirection');
        }
    }

    public function render()
    {
        $models = $this->model::select(array_keys($this->columns))
            ->where('title', 'like', $this->search . "%")
            ->orderBy($this->orderTerm, $this->orderDirection)
            ->get();
        return view("chewby::components.livewire.models.table", [
            "models" => $models
        ]);
    }
}
