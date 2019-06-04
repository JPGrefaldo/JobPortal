<?php

namespace App\Services;

use App\Models\Position;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class PositionsServices
{
    /**
     * @param array $data
     *
     * @return Position
     */
    public function create(array $data)
    {
        $data = $this->prepareData($this->filterData($data));

        return Position::create($data);
    }

    /**
     * Format and set default values
     *
     * @param array $data
     *
     * @return array
     */
    public function prepareData(array $data)
    {
        $data['name'] = Str::title($data['name']);
        $data['has_gear'] = Arr::get($data, 'has_gear', 0);
        $data['has_union'] = Arr::get($data, 'has_union', 0);

        return $data;
    }

    /**
     * @param array $data
     *
     * @return array
     */
    public function filterData(array $data)
    {
        return Arr::only($data, [
            'name',
            'department_id',
            'position_type_id',
            'has_gear',
            'has_union',
        ]);
    }

    /**
     * @param array $data
     * @param Position $position
     *
     * @return Position
     */
    public function update(array $data, Position $position)
    {
        $data = $this->prepareData($this->filterData($data));

        $position->update($data);

        return $position;
    }
}
