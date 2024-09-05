<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('order')->insert([
            [
                'user_id'=>1,
                'produk_id'=>1,
                'quantity'=>2,
                'total_price'=>40000
            ],
            [
                'user_id'=>1,
                'produk_id'=>3,
                'quantity'=>2,
                'total_price'=>400000
            ],
            [
                'user_id'=>2,
                'produk_id'=>3,
                'quantity'=>2,
                'total_price'=>400000
            ]
        ]);
    }
}
