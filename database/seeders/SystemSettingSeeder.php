<?php

namespace Database\Seeders;

use App\Models\SystemSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SystemSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SystemSetting::create([
            'site_name' => 'Inventory Shop 1',
            'site_logo' => null,
            'site_favicon' => null,
            'site_phone' => 123456789,
            'site_email' => 'admin@inventory.com',
            'site_facebook_link' => 'inventory@facebook.com',
            'meta_keywords' => 'POS, Inventory, Shopping',
            'meta_description' => 'Its a multi-product inventory shop'
        ]);

    }
}
