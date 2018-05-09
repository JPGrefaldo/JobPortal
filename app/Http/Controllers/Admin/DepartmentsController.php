<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\DepartmentsRequest;
use App\Models\Department;
use App\Services\DepartmentsServices;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DepartmentsController extends Controller
{
    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'name'        => ['required', 'string', 'max:255', 'unique:departments'],
            'description' => ['nullable', 'string'],
        ]);

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
