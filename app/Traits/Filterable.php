<?php


namespace App\Traits;


use App\Filters\UserBodyTrackers\Weight\QueryFilters;

trait Filterable
{
    public function scopeFilter($query, QueryFilters $filters)
    {
        return $filters->apply($query);
    }
}
