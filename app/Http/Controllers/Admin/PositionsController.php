<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\PositionsRequest;
use App\Services\PositionsServices;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PositionsController extends Controller
{
    /**
     * @param \App\Http\Requests\Admin\PositionsRequest $request
     */
    public function store(PositionsRequest $request)
    {
        $data = $request->validated();

        app(PositionsServices::class)->create($data);
    }
}
