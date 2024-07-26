<?php

namespace App\Models\Traits;


use App\Filters\QueryFilters;
use Illuminate\Database\Eloquent\Builder;

trait Filterable
{
    public function scopeFilter($query, QueryFilters $filters): Builder
    {
        return $filters->apply($query);
    }
}
