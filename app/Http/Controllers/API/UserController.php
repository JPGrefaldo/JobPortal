<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @return Response
     */
    public function show(Request $request)
    {
        $user = auth()->user();

        return response()->json([
            'user' => $user->load([
                'roles', 'sites',
            ]),
        ]);
    }
}
