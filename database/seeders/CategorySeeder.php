<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // array list of default insurance categories
        $categories = [
            'Health Insurance',
            'Life Insurance',
            'Property Insurance',
            'Vehicle Insurance',
            'Travel Insurance'
        ];
        // insert each category into the database
        foreach ($categories as $category) {
            Category::create([
                'category_name' => $category
            ]);
        }
    }
}
