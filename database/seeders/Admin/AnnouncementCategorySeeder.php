<?php

namespace Database\Seeders\Admin;

use App\Models\Admin\AnnouncementCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AnnouncementCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $announcement_categories = array(
            array('id' => '1','admin_id' => '1','name' => 'Music Genres','slug' => 'music-genres','status' => '1','created_at' => '2023-10-24 17:13:21','updated_at' => '2023-11-06 15:20:10'),
            array('id' => '2','admin_id' => '1','name' => 'Contests and Giveaways','slug' => 'contests-and-giveaways','status' => '1','created_at' => '2023-10-24 17:13:30','updated_at' => '2023-11-06 15:19:55'),
            array('id' => '3','admin_id' => '1','name' => 'Platform News','slug' => 'platform-news','status' => '1','created_at' => '2023-10-24 17:13:55','updated_at' => '2023-11-06 15:19:34'),
            array('id' => '4','admin_id' => '1','name' => 'Program Updates','slug' => 'program-updates','status' => '1','created_at' => '2023-10-24 17:14:02','updated_at' => '2023-11-06 15:19:24'),
            array('id' => '5','admin_id' => '1','name' => 'New Music Releases','slug' => 'new-music-releases','status' => '1','created_at' => '2023-10-24 17:14:10','updated_at' => '2023-11-06 15:19:14')
          );

          AnnouncementCategory::insert($announcement_categories);
    }
}
