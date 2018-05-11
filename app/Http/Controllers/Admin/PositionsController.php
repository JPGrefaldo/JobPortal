<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\PositionsRequest;
use App\Models\Position;
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

    /**
     * @param \App\Http\Requests\Admin\PositionsRequest $request
     * @param \App\Models\Position                      $position
     *
     */
    public function update(PositionsRequest $request, Position $position)
    {
        $data = $request->validated();

        app(PositionsServices::class)->update($data, $position);
    }
}
