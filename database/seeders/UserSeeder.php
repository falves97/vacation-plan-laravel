<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::truncate();

        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => 'senha'
        ]);

        User::factory(10)->create([
            'password' => 'senha'
        ]);
    }
}
