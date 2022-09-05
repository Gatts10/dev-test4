<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PriceResource;
use App\Models\Product;
use Illuminate\Support\Collection;

class PriceController extends Controller
{

    private $prices;

    public function __construct()
    {
        $json = json_decode(file_get_contents(storage_path() . "/files/live_prices.json"), true);

        $this->prices = collect($json);
    }

    public function index()
    {
        return response()->json($this->prices);
    }

    public function show($skus)
    {
        $skus_array = explode(",", $skus);
        $skus_array = array_map('trim', $skus_array);

        $prices_from_json = new Collection($this->prices);

        $products = Product::whereIn('sku', $skus_array)->orderBy('price', 'asc')->get();

        if ($products->isEmpty()) {
            return response()->json([
                'message' => 'Record not found.'
            ], 422);
        }

        foreach ($products as $product) {

            $json_price = $prices_from_json->where('sku', $product->sku)->first();

            if ($json_price) {
                $product->price = $json_price['price'];
            }
        }

        return response()->json($products);
    }
}