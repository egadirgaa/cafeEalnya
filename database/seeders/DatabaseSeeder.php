<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'ealnya',
            'email' => 'ealnya@gmail.com',
            'password' => Hash::make('123123'),
            'role' => 'admin'
        ]);

        DB::table('menus')->insert([
            [
                'id' => 1,
                'nama_menu' => 'dimsum ayam ( 5/Porsi )',
                'kategori' => 'cemilan',
                'harga' => 12000,
                'gambar' => 'fUVXJ8DWjYombaMFw379ScEIzopUj2AvsOtkkwVj.jpg',
                'stok' => 990,
                'user_id' => null,
                'created_at' => '2026-01-16 11:37:44',
                'updated_at' => '2026-01-16 15:21:32',
            ],
            [
                'id' => 2,
                'nama_menu' => 'Beef Ramen',
                'kategori' => 'makanan',
                'harga' => 25000,
                'gambar' => 'menu/Nt5Dzuy6OooEr2hxenQWcfQpnEccsQoelHsQ6Wtm.jpg',
                'stok' => 110,
                'user_id' => null,
                'created_at' => '2026-01-16 11:38:23',
                'updated_at' => '2026-01-16 15:21:23',
            ],
            [
                'id' => 3,
                'nama_menu' => 'Chocolate Shake Drink',
                'kategori' => 'minuman',
                'harga' => 12000,
                'gambar' => 'lA9SyxAcH78sRGftG33LTwFLcYCCuOcvXrmPBUIC.jpg',
                'stok' => 120,
                'user_id' => null,
                'created_at' => '2026-01-16 11:55:28',
                'updated_at' => '2026-01-16 15:21:37',
            ],
            [
                'id' => 4,
                'nama_menu' => 'Capuccino Ice',
                'kategori' => 'minuman',
                'harga' => 12000,
                'gambar' => 'kSFgDYBR5WCKEhhEVeq0K32zw1iM9xPSZEoGCrNu.jpg',
                'stok' => 10,
                'user_id' => null,
                'created_at' => '2026-01-16 11:56:35',
                'updated_at' => '2026-01-16 15:21:40',
            ],
            [
                'id' => 5,
                'nama_menu' => 'Matcha Green Tea Smoothie',
                'kategori' => 'minuman',
                'harga' => 12000,
                'gambar' => 'iu83Ga32Ha25emQ00mxhL5xSNej5Z4O0pJWIjyLb.jpg',
                'stok' => 320,
                'user_id' => null,
                'created_at' => '2026-01-16 11:57:05',
                'updated_at' => '2026-01-16 15:21:42',
            ],
            [
                'id' => 6,
                'nama_menu' => 'French Fries',
                'kategori' => 'cemilan',
                'harga' => 8000,
                'gambar' => 'v5U367NnrCSEMI96n1QkExadLWnO8qkx2IkFVPly.webp',
                'stok' => 120,
                'user_id' => null,
                'created_at' => '2026-01-16 12:05:03',
                'updated_at' => '2026-01-16 15:21:46',
            ],
            [
                'id' => 7,
                'nama_menu' => 'Milkshake Taro',
                'kategori' => 'minuman',
                'harga' => 12000,
                'gambar' => 'iD84QAXRg7bY4w152Zn1XnlAl44vzyadHIPyoKwN.webp',
                'stok' => 120,
                'user_id' => null,
                'created_at' => '2026-01-16 12:11:55',
                'updated_at' => '2026-01-16 15:21:57',
            ],
            [
                'id' => 8,
                'nama_menu' => 'Teriyaki Chicken Bowl',
                'kategori' => 'makanan',
                'harga' => 20000,
                'gambar' => 'cbUU2VUWEgBrZsRbR3DHI8R8nKfOH7jnYpLGxHUS.jpg',
                'stok' => 120,
                'user_id' => null,
                'created_at' => '2026-01-16 12:19:28',
                'updated_at' => '2026-01-16 15:21:53',
            ],
        ]);
    }
}
