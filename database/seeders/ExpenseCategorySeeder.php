<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use App\Models\ExpenseCategory;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ExpenseCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categoryList = [
            'Purchase',
            'Snacks',
            'Rent',
            'Cleaning',
            'Electricity Bill',
            'Water Bill',
            'Gas Bill',
            'Miscellaneous'
        ];

        foreach ($categoryList as $category) {
            ExpenseCategory::create([
                'name' => $category,
                'slug' => Str::slug($category),

            ]);
        }
    }
}
