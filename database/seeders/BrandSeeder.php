<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brandList = collect([
            ['name' => 'Apple', 'code' => 101],
            ['name' => 'Dell', 'code' => 102],
            ['name' => 'HP', 'code' => 103],
            ['name' => 'Lenovo', 'code' => 104],
            ['name' => 'Asus', 'code' => 105],
            ['name' => 'Acer', 'code' => 106],
            ['name' => 'Microsoft', 'code' => 107],
            ['name' => 'MSI', 'code' => 108],
            ['name' => 'Razer', 'code' => 109],
            ['name' => 'Samsung', 'code' => 110],
        ]);

        foreach ($brandList as $brand) {
            Brand::create([
                'name' => $brand['name'],
                'slug' => Str::slug($brand['name']),
                'code' => $brand['code'],
            ]);
        }
    }
}
