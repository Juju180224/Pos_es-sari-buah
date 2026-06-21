<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['key' => 'app_name', 'value' => 'Es Buah Sari'],
            ['key' => 'currency_symbol', 'value' => 'Rp'],
            ['key' => 'currency_code', 'value' => 'IDR'],
            ['key' => 'currency_symbol_position', 'value' => 'before'],
            ['key' => 'decimal_separator', 'value' => ','],
            ['key' => 'thousand_separator', 'value' => '.'],
            ['key' => 'number_of_decimals', 'value' => 0],
        ];

        foreach ($data as $value) {
            Setting::updateOrCreate([
                'key' => $value['key']
            ], [
                'value' => $value['value']
            ]);
        }
    }
}
