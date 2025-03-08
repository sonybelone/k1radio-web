<?php

namespace Database\Seeders\Admin;

use App\Models\Admin\AppOnboardScreens;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AppOnBoardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $app_onboard_screens = array(
            array('id' => '1','title' => NULL,'sub_title' => NULL,'image' => 'c24fb19d-5f5a-4a97-80a9-bdafab1e95a8.webp','status' => '1','last_edit_by' => '1','created_at' => '2023-11-30 12:39:13','updated_at' => '2023-11-30 12:39:13')
          );
        AppOnboardScreens::insert($app_onboard_screens);
    }
}
