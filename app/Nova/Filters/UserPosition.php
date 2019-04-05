<?php

namespace App\Nova\Filters;

use App\Models\Role;
use Illuminate\Http\Request;
use Laravel\Nova\Filters\Filter;

class UserPosition extends Filter
{
    /**
     * Apply the filter to the given query.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(Request $request, $query, $value)
    {
        return $query->{'are' . $value}();
    }

    /**
     * Get the filter's available options.
     *
     * @param  \Illuminate\Http\Request  $request
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
