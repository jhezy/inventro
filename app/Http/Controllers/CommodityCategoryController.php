<?php

namespace App\Http\Controllers;

use App\CommodityCategory;
use App\Http\Requests\StoreCommodityCategoryRequest;
use App\Http\Requests\UpdateCommodityCategoryRequest;

class CommodityCategoryController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(CommodityCategory::class, 'commodity_category');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $commodityCategories = CommodityCategory::orderBy('name', 'ASC')->get();

        return view('commodity-categories.index', compact('commodityCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCommodityCategoryRequest $request)
    {
        CommodityCategory::create($request->validated());

        return to_route('kategori.index')->with('success', 'Data berhasil ditambahkan!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommodityCategoryRequest $request, CommodityCategory $commodityCategory)
    {
        $commodityCategory->update($request->validated());

        return to_route('kategori.index')->with('success', 'Data berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CommodityCategory $commodityCategory)
    {
        if ($commodityCategory->commodities()->exists()) {
            return to_route('kategori.index')
                ->with('error', 'Kategori tidak dapat dihapus karena masih terkait dengan data komoditas!');
        }

        $commodityCategory->delete();

        return to_route('kategori.index')->with('success', 'Data berhasil dihapus!');
    }
}
