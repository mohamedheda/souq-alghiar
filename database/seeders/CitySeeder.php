<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = [
            ['name_ar' => 'القاهرة', 'name_en' => 'Cairo'],
            ['name_ar' => 'الجيزة', 'name_en' => 'Giza'],
            ['name_ar' => 'السويس', 'name_en' => 'Suez'],
            ['name_ar' => 'المنيا', 'name_en' => 'Minya'],
            ['name_ar' => 'الأقصر', 'name_en' => 'Luxor'],
            ['name_ar' => 'بورسعيد', 'name_en' => 'Port Said'],
            ['name_ar' => 'الإسكندرية', 'name_en' => 'Alexandria'],
            ['name_ar' => 'دمياط', 'name_en' => 'Damietta'],
            ['name_ar' => 'القليوبية', 'name_en' => 'Qalyubia'],
            ['name_ar' => 'أسوان', 'name_en' => 'Aswan'],
            ['name_ar' => 'بني سويف', 'name_en' => 'Beni Suef'],
            ['name_ar' => 'سوهاج', 'name_en' => 'Sohag'],
            ['name_ar' => 'الإسماعيلية', 'name_en' => 'Ismailia'],
            ['name_ar' => 'أسيوط', 'name_en' => 'Assiut'],
            ['name_ar' => 'البحيرة', 'name_en' => 'Beheira'],
            ['name_ar' => 'البحر الأحمر', 'name_en' => 'Red Sea'],
            ['name_ar' => 'الدقهلية', 'name_en' => 'Dakahlia'],
            ['name_ar' => 'الفيوم', 'name_en' => 'Faiyum'],
            ['name_ar' => 'الغربية', 'name_en' => 'Gharbia'],
            ['name_ar' => 'قنا', 'name_en' => 'Qena'],
            ['name_ar' => 'مطروح', 'name_en' => 'Matrouh'],
            ['name_ar' => 'كفر الشيخ', 'name_en' => 'Kafr El Sheikh'],
            ['name_ar' => 'المنوفية', 'name_en' => 'Menoufia'],
            ['name_ar' => 'حلوان', 'name_en' => 'Helwan'],
            ['name_ar' => 'جنوب سيناء', 'name_en' => 'South Sinai'],
            ['name_ar' => 'شمال سيناء', 'name_en' => 'North Sinai'],
        ];

        foreach ($cities as $city) {
            City::create($city);
        }
    }
}
