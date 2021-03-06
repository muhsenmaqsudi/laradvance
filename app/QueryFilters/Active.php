<?php

namespace App\QueryFilters;

use Illuminate\Database\Eloquent\Builder;

class Active extends Filter
{
    protected function applyFilter(Builder $builder)
    {
        return $builder->where($this->filterName(), request($this->filterName()));
    }
}
