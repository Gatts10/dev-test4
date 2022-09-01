<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PriceController extends Controller
{
    public function index()
    {
        $prices = json_decode(file_get_contents(storage_path() . "/files/live_prices.json"), true);

        return response()->json($prices);
    }
}
