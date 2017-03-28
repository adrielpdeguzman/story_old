<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;

class UserFilters extends GenericFilters {
    /**
     * Filter by single users.
     *
     * @return  \Illuminate\Database\Eloquent\Builder
     */
    public function single()
    {
        return $this->builder->where('partner_id', null);
    }
}
