<?php

namespace App;

use Schema;
use Illuminate\Database\Eloquent\Builder;

class GenericFilters extends QueryFilters
{
    /**
     * Filter by sortable column.
     *
     * @param   string  $sort
     * @return  \Illuminate\Database\Eloquent\Builder
     */
    public function sort($sort)
    {
        $column = str_replace('-', '', $sort);
        $orderBy = ($column === $sort) ? 'orderBy' : 'orderByDesc';

        if (! Schema::hasColumn($this->builder->getModel()->getTable(), $column)) {
            return;
        }

        return $this->builder->$orderBy($column);
    }

    /**
     * Filter by select fields.
     *
     * @param  string $fields
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function fields($fields)
    {
        // Remove fields not present as a column in the schema.
        foreach ($fields as $index => $field) {
            if (! Schema::hasColumn($this->builder->getModel()->getTable(), $field)) {
                unset($fields[$index]);
            }
        }

        return $this->builder->select($fields);
    }

    /**
     * Filter by field content.
     *
     * @param   string  $field
     * @param   string  $value
     * @return  \Illuminate\Database\Eloquent\Builder
     */
    public function searchByField($field, $value)
    {
        return $this->builder->where($field, 'like', "%$value%");
    }

    /**
     * Filter by content of each searchable field.
     *
     * @param   string  $value
     * @return  \Illuminate\Database\Eloquent\Builder
     */
    public function search($value)
    {
        $builder = $this->builder;

        foreach ($this->builder->getModel()->searchable as $field) {
            $builder = $builder->orWhere($field, 'like', "%$value%");
        }

        return $builder;
    }
}
