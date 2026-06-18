<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class SettingSeeder extends Seeder
{
    public function run()
    {
        $settings = [
            ['key' => 'app_name',     'value' => 'SIMP-PRO'],
            ['key' => 'app_logo',     'value' => 'images/logo_simppro.png'],
            ['key' => 'company_name', 'value' => 'PT Sketsa Instrumentasi Persada'],
            ['key' => 'company_address', 'value' => 'Jl. Contoh No. 1, Semarang'],
            ['key' => 'company_phone',   'value' => '024-1234567'],
            ['key' => 'company_email',   'value' => 'info@sketsa.com'],
            ['key' => 'app_color',    'value' => '#3b5bdb'],
        ];

        foreach ($settings as $setting) {
            DB::table('settings')->updateOrInsert(
                ['key' => $setting['key']],
                ['value' => $setting['value'], 'updated_at' => now(), 'created_at' => now()]
            );
        }
    }
}