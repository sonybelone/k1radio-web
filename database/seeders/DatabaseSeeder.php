<?php

namespace Database\Seeders;

use Database\Seeders\Admin\AdminHasRoleSeeder;
use Illuminate\Database\Seeder;
use Database\Seeders\Admin\AdminSeeder;
use Database\Seeders\Admin\AnnouncementCategorySeeder;
use Database\Seeders\Admin\AnnouncementSeeder;
use Database\Seeders\Admin\AppOnBoardSeeder;
use Database\Seeders\Admin\SetupSeoSeeder;
use Database\Seeders\Admin\ExtensionSeeder;
use Database\Seeders\Admin\AppSettingsSeeder;
use Database\Seeders\Admin\SiteSectionsSeeder;
use Database\Seeders\Admin\BasicSettingsSeeder;
use Database\Seeders\Admin\DailyScheduleSeeder;
use Database\Seeders\Admin\DemoAdminSeeder;
use Database\Seeders\Admin\LanguageSeeder;
use Database\Seeders\Admin\RoleSeeder;
use Database\Seeders\Admin\ScheduleDaySeeder;
use Database\Seeders\Admin\SetupPageSeeder;
use Database\Seeders\User\UserSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        // //Demo Seeder
        // $this->call([
        //     DemoAdminSeeder::class,
        //     RoleSeeder::class,
        //     BasicSettingsSeeder::class,
        //     SetupSeoSeeder::class,
        //     AppSettingsSeeder::class,
        //     AppOnBoardSeeder::class,
        //     SiteSectionsSeeder::class,
        //     ExtensionSeeder::class,
        //     AdminHasRoleSeeder::class,
        //     UserSeeder::class,
        //     SetupPageSeeder::class,
        //     ScheduleDaySeeder::class,
        //     DailyScheduleSeeder::class,
        //     LanguageSeeder::class,
        //     AnnouncementCategorySeeder::class,
        //     AnnouncementSeeder::class,
        // ]);

        //fresh seeder
        $this->call([
            AdminSeeder::class,
            RoleSeeder::class,
            BasicSettingsSeeder::class,
            SetupSeoSeeder::class,
            AppSettingsSeeder::class,
            AppOnBoardSeeder::class,
            SiteSectionsSeeder::class,
            ExtensionSeeder::class,
            AdminHasRoleSeeder::class,
            SetupPageSeeder::class,
            LanguageSeeder::class,
            AnnouncementCategorySeeder::class,
            AnnouncementSeeder::class,
        ]);
    }
}
