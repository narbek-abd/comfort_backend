<?php


namespace App\Http\Filters;


use Illuminate\Database\Eloquent\Builder;

class QueryFilter
{
    /** @var array */
    private $query = [];

    /**
     * @param array query
     */
    public function __construct(array $query)
    {
        $this->query = $query;
    }

    public function apply(Builder $builder)
    {
        foreach ($this->query as $name => $value) {
            if (method_exists($this, $name) && $value !== null) {
                call_user_func([$this, $name], $builder, $value);
            }
        }
    }
  
}
