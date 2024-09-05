<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'address'=>'bekasi'
        ]);
        User::factory()->create([
            'name' => 'Test User 2',
            'email' => 'test2@example.com',
            'address'=>'jakarta'
        ]);
        $this->call([
            KategoriSeeder::class
        ]);

        $this->call([
            ProdukSeeder::class
        ]);

        $this->call([
            OrderSeeder::class
        ]);
    }
}
