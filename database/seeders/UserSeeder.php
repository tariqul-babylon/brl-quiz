<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['id' => 1],
            [
                'username' => 'superadmin',
                'name' => 'Super Admin',
                'email' => 'admin@gmail.com',
                'password' => bcrypt(12341234),
            ]
        );
    }
}
