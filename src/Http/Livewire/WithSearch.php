<?php

namespace Chewbathra\Chewby\Http\Livewire;

use Chewbathra\Chewby\Models\Model;
use Illuminate\Database\Eloquent\Builder;

trait WithSearch
{
    public string $search = '';

    public function updatingSearch(): void
    {
        if (method_exists($this, 'resetPage')) {
            $this->resetPage();
        }
    }

    /**
     * @param  Builder<Model>  $query
     * @param  string  $column
     * @return Builder<Model>
     */
    public function setSearch(Builder $query, string $column): Builder
    {
        return $query->where($column, 'like', $this->search.'%');
    }
}
