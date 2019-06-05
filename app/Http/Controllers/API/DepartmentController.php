<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DepartmentsRequest;
use App\Models\Department;
use App\Services\DepartmentsServices;

class DepartmentController extends Controller
{
    public function index()
    {
        return Department::all();
    }

    /**
     * @param DepartmentsRequest $request
     */
    public function store(DepartmentsRequest $request)
    {
        $data = $request->validated();

        app(DepartmentsServices::class)->create($data);
    }

    /**
     * @param DepartmentsRequest $request
     * @param Department $department
     */
    public function update(DepartmentsRequest $request, Department $department)
    {
        $data = $request->validated();

        app(DepartmentsServices::class)->update($data, $department);
    }
}
