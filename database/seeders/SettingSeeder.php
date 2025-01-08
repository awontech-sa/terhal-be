<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            [
                'about' => 'نص حول الموقع',
                'terms_conditions' => 'نص الشروط والأحكام',
                'policies' => 'نص السياسات'
            ]
        ];

        foreach ($settings as $setting) {
            Setting::create($setting);
        }
    }
}
