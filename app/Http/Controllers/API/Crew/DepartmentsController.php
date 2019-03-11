<?php

namespace App\Http\Controllers\API\Crew;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Department;

class DepartmentsController extends Controller
{
    public function index()
    {
        $departments = Department::all();
        
        return response()->json([
            'departments' => $departments
        ]);
    }
}
