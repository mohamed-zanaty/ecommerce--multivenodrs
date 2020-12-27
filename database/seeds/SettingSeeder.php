<?php

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{

    public function run()
    {
        Setting::setMany([
           'default_locale'=>'ar',
           'default_timezone'=>'Africa/Cairo',
           'reviews_enabled'=>true,
           'auto_reviews_approved'=>true,
           'supported_currency'=>['USD','LE','SAR'],
           'default_currency'=>'USD',
           'store_email'=>'admin@gmail.test',
           'search_engine'=>'mysql',
            'local_shipping_cost'=>0,
            'outer_shipping_cost'=>0,
            'free_shipping_cost'=>0,
            'translatable'=>[
                'store_name'=>'zanaty store',
                'free_shipping_label'=>'free shipping',
                'local_label'=>'local shipping',
                'outer_label'=>'outer shipping',
            ]
        ]);
    }
}
