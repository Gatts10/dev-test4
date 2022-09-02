<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PriceResource;
use App\Models\Product;

class PriceController extends Controller
{
    public function index()
    {
        $prices = json_decode(file_get_contents(storage_path() . "/files/live_prices.json"), true);

        return response()->json($prices);
    }

    public function show($sku)
    {
        $prices = json_encode(file_get_contents(storage_path() . "/files/live_prices.json"), true);

        $products = Product::query()->where('sku', $sku)->get();

        return response()->json($products);
    }
}
