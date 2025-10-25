<?php

namespace App\Http\Controllers\API;

use App\Rab;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class CommodityLocationController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(Rab $rab)
    {
        return response()->json([
            'code' => Response::HTTP_OK,
            'message' => 'success',
            'data' => $rab,
        ], Response::HTTP_OK);
    }
}
