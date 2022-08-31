<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Price;
use App\Models\Account;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Price::truncate();
        $csvData = fopen((storage_path() . "/files/import.csv"), 'r');
        $transRow = true;
        while (($data = fgetcsv($csvData, 555, ',')) !== false) {

            $product = Product::where('sku', $data['0'])->first();
            $account = Account::where('external_reference', $data['1'])->first();
            $user = User::where('external_reference', $data['2'])->first();
            
            if (!$transRow) {
                Price::create([
                    'product_id' => $product->id ?? NULL,
                    'account_id' => $account->id ?? NULL,
                    'user_id' => $user->id ?? NULL,
                    'quantity' => $data['3'],
                    'value' => $data['4']
                ]);
            }
            $transRow = false;
        }
        fclose($csvData);
    }
}
