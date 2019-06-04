<?php

namespace App\Nova\Filters;

use App\Models\Role;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;

class UserPosition extends Filter
{
    /**
     * Apply the filter to the given query.
     *
     * @param Request $request
     * @param Builder $query
     * @param mixed $value
     * @return Builder
     */
    public function apply(Request $request, $query, $value)
    {
        return $query->{'are' . $value}();
    }

    /**
     * Get the filter's available options.
     *
     * @param Request $request
     * @return array
     */
    public function options(Request $request)
    {
        return [
            'Crew'      => Role::CREW,
            'Producers' => Role::PRODUCER,
        ];
    }
}
