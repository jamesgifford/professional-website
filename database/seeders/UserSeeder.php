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
        User::create([
            'name' => 'James Gifford',
            'email' => 'james@jamesgifford.com',
            'password' => '$2y$12$i2fTpH4vHv/Ok2.5UU8IFexTmfnEAExlMTDYgxO7whyQOP0dOUIGO',
            'email_verified_at' => now(),
        ]);
    }
}
