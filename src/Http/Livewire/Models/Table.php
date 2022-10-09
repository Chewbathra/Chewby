<?php

namespace Chewbathra\Chewby\Http\Livewire\Models;

use Chewbathra\Chewby\Facades\Config;
use Chewbathra\Chewby\Http\Livewire\WithOrder;
use Chewbathra\Chewby\Http\Livewire\WithSearch;
use Chewbathra\Chewby\Models\Model;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithOrder, WithSearch, WithPagination;

    public Model $model;

    public array $columns;

    public string $createRoute;

    /**
     * @var array
     */
    protected $queryString = [
        'search' => ['except' => ''],
        'orderTerm' => ['except' => 'id', 'as' => 'order'],
        'orderDirection' => ['except' => 'ASC', 'as' => 'direction'],
        'page' => ['except' => 1],
    ];

    public function mount(string|Model $resource): void
    {
        if (! is_subclass_of($resource, Model::class)) {
            throw new \Error("Given class $resource dont extend ".Model::class);
        }
        $this->model = new $resource;
        $controller = Config::getControllerForModel($this->model);
        $this->createRoute = Config::getConfig('base')->first().'.'.$controller->resourcePath.'.create';
        $this->columns = $controller->getIndexColumns();
    }

//    public function paginationView()
//    {
//        return 'chewby::layouts.pagination' ;
//    }

    public function render(): View
    {
        $models = $this->setOrderBy(
            $this->setSearch(
                $this->model::select(array_keys($this->columns)),
                'title'
            )
        )
            ->paginate(10);
        /**
         * @phpstan-ignore-next-line
         */
        return view('chewby::components.livewire.models.table', ['models' => $models]);
    }
}
