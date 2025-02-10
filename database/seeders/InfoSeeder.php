<?php

namespace Database\Seeders;

use App\Models\Info;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $infos = [
            [
                'key' => 'default_user_wallet_points',
                'name_en' => 'Default User Wallet Points',
                'name_ar' => 'النقاط الافتراضية لمحفظة المستخدم',
                'type' => 'number',
                'value' => '100',
            ],
            [
                'key' => 'default_merchant_wallet_points',
                'name_en' => 'Default Merchant Wallet Points',
                'name_ar' => 'النقاط الافتراضية لمحفظة التاجر',
                'type' => 'number',
                'value' => '200',
            ],
            [
                'key' => 'product_addition_points',
                'name_en' => 'Points for Adding a Product',
                'name_ar' => 'نقاط إضافة منتج',
                'type' => 'number',
                'value' => '10',
            ],
            [
                'key' => 'featured_product_points',
                'name_en' => 'Points for Featuring a Product',
                'name_ar' => 'إضافة منتج مميز "ظهور أعلى في ترتيب البحث"',
                'type' => 'number',
                'value' => '20',
            ],
            [
                'key' => 'comment_points',
                'name_en' => 'Points for Commenting',
                'name_ar' => 'نقاط للتعليق',
                'type' => 'number',
                'value' => '5',
            ],
            [
                'key' => 'featured_comment_points',
                'name_en' => 'Points for Featuring a Comment',
                'name_ar' => 'نقاط للتعليق المميز للظهور في الأعلى في التعليقات وتثبيته',
                'type' => 'number',
                'value' => '10',
            ],
            [
                'key' => 'free_product_limit_user',
                'name_en' => 'Allowed Products for Free Users',
                'name_ar' => 'عدد المنتجات المسموح بإضافتها للمستخدم العادي',
                'type' => 'number',
                'value' => '5',
            ],
            [
                'key' => 'withdraw_points_enabled',
                'name_en' => 'Allow to Withdraw Points',
                'name_ar' => 'السماح بسحب النقاط',
                'type' => 'boolean',
                'value' => 'true',
            ],
        ];

        foreach ($infos as $info) {
            Info::updateOrCreate(['key' => $info['key']], $info);
        }
    }
}
