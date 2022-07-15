<?php


namespace App\Models\Traits;


use App\Http\Filters\ProductsFilter;
use App\Http\Filters\QueryFilter;
use Illuminate\Database\Eloquent\Builder;

trait Filterable
{
    /**
     * @param Builder $builder
     * @param ProductsFilter $filter
     *
     * @return Builder
     */
    public function scopeFilter(Builder $builder, QueryFilter $filter)
    {
        $filter->apply($builder);

        return $builder;
    }
}
