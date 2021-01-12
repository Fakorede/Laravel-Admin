<?php

namespace App\Http\Controllers\Influencer;

use App\Http\Resources\ProductResource;
use App\Product;
use Illuminate\Http\Request;

class ProductController
{
    public function index(Request $request)
    {
        $products = \Cache::remember('products', 60 * 30, function () use ($request) {
            return Product::all();
        });

        $query = Product::query();

        if ($s = $request->input('s')) {
            $products = $products->filter(function (Product $product) use ($s) {
                return \Str::contains($product->title, $s) ||
                \Str::contains($product->description, $s);
            });
        }

        return ProductResource::collection($products);
    }
}
