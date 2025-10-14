<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        dump('DatabaseSeeder is running...');
        $this->call(CreateSuperAdminAccount::class);
        dump('Seeding completed!');
    }
}
