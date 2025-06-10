<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Mark;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductMark;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get existing data for relationships
        $users = User::pluck('id')->toArray();
        $categories = Category::pluck('id')->toArray();
        $subCategories = Category::whereNotNull('parent_id')->pluck('id')->toArray();
        $marks = Mark::with('models')->get();

        // Generate 50 fake products
        for ($i = 0; $i < 50; $i++) {

            $isUsed = fake()->boolean(30); // 30% chance of being used
            $isFeatured = fake()->boolean(20); // 20% chance of being featured
            $forAllMakes = fake()->boolean(40); // 40% chance of being for all makes

            // Create the product
            $product = Product::create([
                'title' => fake()->words(fake()->numberBetween(2, 8), true) ,
                'description' => fake()->paragraphs(fake()->numberBetween(2, 5), true),
                'used' => $isUsed,
                'user_id' => fake()->randomElement($users),
                'category_id' => fake()->randomElement($categories),
                'sub_category_id' => fake()->randomElement($subCategories),
                'price' => fake()->numberBetween(1000, 100000),
                'all_makes' => $forAllMakes,
                'featured' => $isFeatured,
                'views' => fake()->numberBetween(0, 5000),
            ]);

            $numImages = fake()->numberBetween(1, 5);
            for ($j = 0; $j < $numImages; $j++) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => 'https://picsum.photos/seed/' . fake()->uuid . '/300/300',
                ]);
            }

            if (!$forAllMakes) {
                $numMarks = $marks->isEmpty() ? 0 : fake()->numberBetween(1, min(3, $marks->count()));

                $selectedMarks = $numMarks > 0 ? $marks->random($numMarks) : collect();

                foreach ($selectedMarks as $mark) {
                    $modelCount = min($mark->models->count(), fake()->numberBetween(1, 3)); // Safe limit
                    $models = $mark->models->random($modelCount);
                    foreach ($models as $model) {
                        $yearFrom = fake()->numberBetween(1990, 2015);
                        ProductMark::create([
                            'product_id' => $product->id,
                            'mark_id' => $mark->id,
                            'model_id' => $model->id,
                            'year_from' => $yearFrom,
                            'year_to' => fake()->numberBetween($yearFrom + 1, 2023),
                        ]);
                    }
                }
            }
            if (fake()->boolean(70)) {
                $product->increment('views', fake()->numberBetween(10, 200));
            }
        }
    }
}
