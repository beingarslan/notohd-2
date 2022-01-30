<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // currency_id, name, symbol, code
        $currencies = [
            [
                'name' => 'United States Dollar',
                'symbol' => '$',
                'code' => 'USD',
            ],
            [
                'name' => 'Euro',
                'symbol' => '€',
                'code' => 'EUR',
            ]
            ];

        foreach ($currencies as $currency) {
            \App\Models\Currency::create($currency);
        }
    }
}
