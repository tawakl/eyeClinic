<?php

declare(strict_types = 1);

namespace Database\Seeders;

use App\Modules\Users\User;
use App\Modules\Users\UserEnums;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class CreateSuperAdminAccount extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        dump('start Seeding Super Admin account');
        $superAdmin = User::query()->firstOrCreate(
            [
                'type' => UserEnums::SUPER_ADMIN_TYPE,
            ],
            [
                'type' => UserEnums::SUPER_ADMIN_TYPE,
                'first_name' => 'super',
                'last_name' => 'admin',
                'email' => 'super_admin@test.com',
                'password' => '12345678',
                'is_active' => 1,
                'profile_picture' => 'users/profiles/eug9kygiy91662949950.jpg',
            ]
        );
        dump('Super Admin account is ready', $superAdmin);
    }
}
