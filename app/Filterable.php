<?php

/**
 * @author Jeffrey Way
 */
namespace App;

use Illuminate\Database\Eloquent\Builder;

trait Filterable
{
    /**
     * Filter a result set.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  \App\QueryFilters  $filters
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilter($query, QueryFilters $filters)
    {
        return $filters->apply($query);
    }
}
