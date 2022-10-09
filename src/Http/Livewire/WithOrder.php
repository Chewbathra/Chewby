<?php

namespace Chewbathra\Chewby\Http\Livewire;

use Chewbathra\Chewby\Models\Model;
use Illuminate\Database\Eloquent\Builder;

trait WithOrder
{
    public string $orderTerm = 'id';

    public string $orderDirection = 'ASC';

    public function setOrder(string $term): void
    {
        if ($term == $this->orderTerm) {
            $this->orderDirection = $this->orderDirection == 'ASC' ? 'DESC' : 'ASC';
        } else {
            $this->orderTerm = $term;
            $this->reset('orderDirection');
        }
    }

    /**
     * @param  Builder<Model>  $query
     * @return Builder<Model>
     */
    public function setOrderBy(Builder $query): Builder
    {
        return $query->orderBy($this->orderTerm, $this->orderDirection);
    }
}
