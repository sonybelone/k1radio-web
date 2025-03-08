<?php

namespace Database\Seeders\Admin;

use App\Models\Admin\AppSettings;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AppSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $app_settings = array(
            array('id' => '1','version' => '1.2.0','splash_screen_image' => 'c596b76a-9a47-471c-be4c-6a0bad4a8961.webp','url_title' => 'Download The AdRadio App Today','android_url' => 'https://play.google.com/store/apps?hl=en&gl=US','iso_url' => 'https://www.apple.com/store','created_at' => '2023-11-02 16:18:39','updated_at' => '2023-11-30 16:59:50')
          );

        AppSettings::insert($app_settings);
    }
}
