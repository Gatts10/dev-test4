<?php

namespace App\Http\Controllers\Api;

use App\Models\Account;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;

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

    public function sku($skus)
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

    public function account($accounts)
    {
        $accounts_from_json = new Collection($this->prices);

        $accounts = Account::where('external_reference', $accounts)->get();

        if ($accounts->isEmpty()) {
            return response()->json([
                'message' => 'Record not found.'
            ], 422);
        }

        foreach ($accounts as $account) {
            $json_account = $accounts_from_json->where('account', $account->external_reference)->sortBy('price')->values()->first();
        }

        return response()->json([$json_account]);
    }
}
