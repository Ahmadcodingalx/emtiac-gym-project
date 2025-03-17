<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'firstname' => 'Ahmad',
            'lastname' => 'MAMAM MOROU',
            'username' => 'admin',
            'email' => 'moroumamam53@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('admin1234'),
            'remember_token' => Str::random(10),
            'is_admin' => 1,
            'image' => 'image',
            'tel' => '96891550',
            'address' => 'Assiama',
            'sex' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
