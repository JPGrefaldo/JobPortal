<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DepartmentsRequest;
use App\Models\Department;
use App\Services\DepartmentsServices;

class DepartmentsController extends Controller
{
    /**
     * @param \App\Http\Requests\Admin\DepartmentsRequest $request
     */
    public function store(DepartmentsRequest $request)
    {
        $data = $request->validated();

        app(DepartmentsServices::class)->create($data);
    }

    /**
     * @param \App\Http\Requests\Admin\DepartmentsRequest $request
     * @param \App\Models\Department                      $department
     */
    public function update(DepartmentsRequest $request, Department $department)
    {
        $data = $request->validated();

        app(DepartmentsServices::class)->update($data, $department);
    }
}
