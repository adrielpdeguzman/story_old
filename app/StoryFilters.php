<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;

class StoryFilters extends GenericFilters
{
    /**
     * Filter by random entry.
     *
     * @return  \Illuminate\Database\Eloquent\Builder
     */
    public function random()
    {
        return $this->builder->inRandomOrder()->limit(1);
    }
}
