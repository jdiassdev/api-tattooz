<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\Products\ProductsListRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ProductsListRequest $request)
    {
        $data = $request->validated();

        $products = Product::query()->select('slug', 'name', 'description', 'price', 'stock')
            ->when(
                $request->filled('slug'),
                fn($q) =>
                $q->where('slug', $request->slug)
            )
            ->when(
                $request->filled('price_min'),
                fn($q) =>
                $q->where('price', '>=', $request->price_min)
            )
            ->when(
                $request->filled('price_max'),
                fn($q) =>
                $q->where('price', '<=', $request->price_max)
            )
            ->active()
            ->paginate(15);

        return $this->success('', Response::HTTP_OK, [
            'products' => $products,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
