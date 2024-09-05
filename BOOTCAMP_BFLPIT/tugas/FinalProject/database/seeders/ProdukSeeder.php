<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('produk')->insert([
            [
                'name'=>'produk 1',
                'kategori_id'=>1,
                'price'=>20000
            ],
            [
                'name'=>'produk 2',
                'kategori_id'=>1,
                'price'=>50000
            ],
            [
                'name'=>'produk 3',
                'kategori_id'=>2,
                'price'=>100000
            ],
            [
                'name'=>'produk 4',
                'kategori_id'=>2,
                'price'=>200000
            ],
        ]);
    }
}
