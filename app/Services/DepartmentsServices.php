<?php


namespace App\Services;


use App\Models\Department;
use App\Utils\StrUtils;

class DepartmentsServices
{
    /**
     * @param array $data
     *
     * @return \App\Models\Department
     */
    public function create(array $data)
    {
        $data = $this->formatData($this->filterData($data));

        return Department::create($data);
    }

    /**
     * @param array                  $data
     * @param \App\Models\Department $department
     *
     * @return \App\Models\Department
     */
    public function update(array $data, Department $department)
    {
        $data = $this->formatData($this->filterData($data));

        $department->update($data);

        return $department;
    }

    /**
     * @param array $data
     *
     * @return array
     */
    public function filterData(array $data)
    {
        return array_only($data, ['name', 'description']);
    }

    /**
     * @param array $data
     *
     * @return array
     */
    public function formatData(array $data)
    {
        $data['name']        = title_case($data['name']);
        $data['description'] = StrUtils::convertNull($data['description']);

        return $data;
    }
}