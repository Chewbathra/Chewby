<?php

namespace Chewbathra\Chewby\Http\Livewire\Models;

use Chewbathra\Chewby\Models\Model;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Row extends Component
{
    public Model $model;

    public array $columns;

    public function render(): View
    {
        return view('chewby::components.livewire.models.row');
    }
}
