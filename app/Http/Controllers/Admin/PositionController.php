<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PositionsRequest;
use App\Models\Position;
use App\Services\PositionsServices;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    public function index()
    {
        return Position::all();
    }

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
     * @param \App\Models\Position $position
     *
     */
    public function update(PositionsRequest $request, Position $position)
    {
        $data = $request->validated();

        app(PositionsServices::class)->update($data, $position);
    }
}
