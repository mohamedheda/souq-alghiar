<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $packages = [
            [
                'name_ar' => 'الأساسية',
                'name_en' => 'Basic',
                'price' => 250,
                'months' => 1,
                'products' => 20,
                'featured_products' => 0,
                'comments' => 10,
                'pinned_comments' => 0,
                'default_package' => 1,
                'promotional_text' => null,
                'features' => [
                    'حتى 20 منتج عادي/شهر',
                    'حتى 10 تعليقات عادية/شهر',
                    'بروفايل عام قابل للمشاركة',
                ],
            ],
            [
                'name_ar' => 'المتقدمة',
                'name_en' => 'Advanced',
                'price' => 600,
                'months' => 1,
                'products' => 50,
                'featured_products' => 5,
                'comments' => 50,
                'pinned_comments' => 5,
                'promotional_text' => null,
                'default_package' => 0,
                'features' => [
                    'حتى 50 منتج عادي/شهر',
                    'حتى 5 منتجات عادية/شهر',
                    'حتى 50 تعليقات عادية/شهر',
                    'حتى 5 تعليقات مميزة/شهر',
                    'بروفايل عام قابل للمشاركة',
                ],
            ],
            [
                'name_ar' => 'السنوية - الأكثر توفيرا',
                'name_en' => 'Yearly - Most Saving',
                'price' => 5000,
                'months' => 12,
                'products' => null,
                'featured_products' => 20,
                'comments' => null,
                'pinned_comments' => 20,
                'promotional_text' => 'وفر 2200 جنيه مقارنة بالشهري يعادل فقط 416 جنيه/شهر',
                'default_package' => 0,
                'features' => [
                    'منتجات عادية غير محدودة',
                    'حتى 20 منتجات مميزة',
                    'تعليقات غير محدودة',
                    'حتى 20 تعليق مميز',
                    'دعم مباشر وترتيب أعلى في البحث',
                    'بروفايل عام قابل للمشاركة',
                ],
            ],
        ];

        foreach ($packages as $package) {
            $packageId = DB::table('packages')->insertGetId([
                'name_en' => $package['name_en'],
                'name_ar' => $package['name_ar'],
                'price' => $package['price'],
                'months' => $package['months'],
                'products' => $package['products'],
                'featured_products' => $package['featured_products'],
                'comments' => $package['comments'],
                'pinned_comments' => $package['pinned_comments'],
                'promotional_text' => $package['promotional_text'],
                'default_package' => $package['default_package'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            foreach ($package['features'] as $feature) {
                DB::table('package_features')->insert([
                    'package_id' => $packageId,
                    'name_ar' => $feature,
                    'name_en' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
