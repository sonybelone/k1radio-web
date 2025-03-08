<?php

namespace Database\Seeders\Admin;

use App\Models\Admin\BasicSettings;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BasicSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $basic_settings = array(
            array('id' => '1','site_name' => 'K1Radio','site_title' => 'Online Radio Streming Platform','base_color' => '#E67E22','secondary_color' => '#F5F6FC','otp_exp_seconds' => '3200','web_version' => '1.2.0','location' => NULL,'timezone' => 'Asia/Dhaka','force_ssl' => '1','user_registration' => '1','secure_password' => '1','agree_policy' => '1','email_verification' => '1','email_notification' => '1','push_notification' => '1','site_logo_dark' => 'a413629a-c53d-4a03-a659-6b182edb5ff7.webp','site_logo' => 'a92a2076-ee30-4184-ad43-f23068e4dfc1.webp','site_fav_dark' => '8e4284fd-618e-42ac-9fa9-08931450396b.webp','site_fav' => '188c8350-cb49-43e5-8762-3d921148fe2a.webp','mail_config' => '{"method":"smtp","host":"appdevs.net","port":"465","encryption":"ssl","username":"system@appdevs.net","password":"QP2fsLk?80Ac","from":"system@appdevs.net","app_name":"AdRadio"}','mail_activity' => NULL,'push_notification_config' => '{"method":"pusher","instance_id":"809313fc-1f5c-4d0b-90bc-1c6751b83bbd","primary_key":"58C901DC107584D2F1B78E6077889F1C591E2BC39E9F5C00B4362EC9C642F03F"}','push_notification_activity' => NULL,'broadcast_config' => '{"method":"pusher","app_id":"1539602","primary_key":"39079c30de823f783dbe","secret_key":"78b81e5e7e0357aee3df","cluster":"ap2"}','broadcast_activity' => NULL,'sms_config' => NULL,'sms_activity' => NULL,'created_at' => '2023-10-26 13:32:53','updated_at' => '2023-10-31 17:11:12')
          );

        BasicSettings::insert($basic_settings);
    }
}
