<?php

namespace Chewbathra\Chewby\Http\Livewire\Models;

use App\Models\User;
use Chewbathra\Chewby\Facades\Config;
use Chewbathra\Chewby\Models\Model;
use Livewire\Component;

class Row extends Component
{
    public Model $model;
    public array $columns;
//    public string $deleteRouteName = "admin.posts.delete";


    public function render()
    {
//        $currentRoute = Route::getCurrentRoute()->getAction()["as"];
//        $splittedCurrentRoute = explode(".", $currentRoute);
//        array_pop($splittedCurrentRoute);
//        $splittedCurrentRoute[] = "delete";
//        $this->deleteRouteName = implode(".", $splittedCurrentRoute);
        return view('chewby::components.livewire.models.row');
    }
}
