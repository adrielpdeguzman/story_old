<?php

namespace App;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

abstract class QueryFilters
{
    /**
     * The request object.
     *
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * The builder instance.
     *
     * @var \Illuminate\Database\Eloquent\Builder
     */
    protected $builder;

    /**
     * Create a new QueryFilters instance.
     *
     * @param \Illuminate\Http\Request  $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Apply the filters to the builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(Builder $builder)
    {
        $this->builder = $builder;
        foreach ($this->filters() as $name => $value) {
            if (! method_exists($this, $name)) {
                // Handle per-field searches
                if (in_array($name, $this->builder->getModel()->searchable ?? [])) {
                    $this->searchByField($name, $value);
                }

                continue;
            }

            if ($name === 'fields') {
                // Handle array-based parameters using single invoke
                $arrayValues = [];

                foreach ($value as $arrayValue) {
                    $arrayValues[] = $arrayValue;
                }

                $this->$name($arrayValues);
            } elseif (is_array($value)) {
                // Handle array-based parameters with chained invokes
                foreach ($value as $arrayValue) {
                    $this->$name($arrayValue);
                }
            } elseif (strlen($value)) {
                $this->$name($value);
            } else {
                $this->$name();
            }
        }

        return $this->builder;
    }

    /**
     * Get all request filters data.
     *
     * @return array
     */
    public function filters()
    {
        return $this->request->all();
    }
}
