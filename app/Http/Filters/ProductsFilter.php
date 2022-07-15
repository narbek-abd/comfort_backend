<?php

namespace App\Http\Filters;


use Illuminate\Database\Eloquent\Builder;

class ProductsFilter extends QueryFilter
{
    public function search(Builder $builder, $value)
    {
        $builder->where('name', 'like', '%' . $value . '%');
    }

    public function price_from(Builder $builder, $value)
    {
        $builder->where('price', '>=', $value);
    }

    public function price_to(Builder $builder, $value)
    {
        $builder->where('price', '<=', $value);
    }

    public function categories(Builder $builder, $value)
    {
        $categories = explode("-", $value);
        $builder->whereIn('category_id', $categories);
    }

    public function sort_by(Builder $builder, $value)
    {
        if($value === 'new') {
            $builder->orderBy('created_at', 'DESC');
        }

         if($value === 'price_low_to_high') {
            $builder->orderBy('price', 'ASC');
        }

        if($value === 'price_high_to_low') {
            $builder->orderBy('price', 'DESC');
        }
    }
}
