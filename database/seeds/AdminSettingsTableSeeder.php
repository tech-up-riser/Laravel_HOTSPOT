<?php

use App\Models\User;
use App\Models\AdminSetting;
use Illuminate\Database\Seeder;

class AdminSettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::where('email', 'admin@admin.com')->first();

        if (isset($admin)) {
            $setting = AdminSetting::create([
                'user_id'                        => $admin->id,
                'upload_promotion'               => "on",
                'redirect_url'                   => "http://dev.chimplinks.com/business",
            ]);

            $setting->save();
        }
    }
}
