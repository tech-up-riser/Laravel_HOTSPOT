<?php

use App\User;
use Illuminate\Database\Seeder;
use jeremykenedy\LaravelRoles\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
         * Add Roles
         *
         */
        if (Role::where('slug', '=', 'admin')->first() === null) {
            $adminRole = Role::create([
                'name'        => 'Admin',
                'slug'        => 'admin',
                'description' => 'Admin Role',
                'level'       => 5,
            ]);
        }

        if (Role::where('slug', '=', 'user')->first() === null) {
            $userRole = Role::create([
                'name'        => 'User',
                'slug'        => 'user',
                'description' => 'User Role',
                'level'       => 1,
            ]);
        }

        if (Role::where('slug', '=', 'business_admin')->first() === null) {
            $userRole = Role::create([
                'name'        => 'Business_Admin',
                'slug'        => 'business',
                'description' => 'Business Admin Role',
                'level'       => 3,
            ]);
        }
    }
}
