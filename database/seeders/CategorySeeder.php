<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = file_get_contents(public_path('json\categories.json'));
        $categories = json_decode($json, true);
        foreach ($categories as $categoryData) {
            $category = Category::create([
                'name_ar' => $categoryData['name_ar'],
                'name_en' => $categoryData['name_en'],
                'show_home' => $categoryData['show_home'],
                'image' =>  "img/categories/".strtolower(str_replace(' ', '-', $categoryData['name_en'])) . '.svg'
            ]);

            if (isset($categoryData['subcategories'])) {
                foreach ($categoryData['subcategories'] as $subcategory) {
                    Category::create([
                        'parent_id' => $category->id,
                        'name_ar' => $subcategory['name_ar'],
                        'name_en' => $subcategory['name_en'],
                        'show_home' => 0
                    ]);
                }
            }
        }
    }
}
