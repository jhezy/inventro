<?php

namespace App\Http\Controllers\API;

use App\CommodityCategory;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;

class CommodityCategoryController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(CommodityCategory $commodityCategory)
    {
        return response()->json([
            'code' => Response::HTTP_OK,
            'message' => 'success',
            'data' => $commodityCategory,
        ], Response::HTTP_OK);
    }
}
