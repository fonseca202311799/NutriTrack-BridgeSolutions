<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Tip;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        User::create([
            'name' => 'John Andrew Fonseca',
            'email' => '202311799@gordoncollege.edu.ph',
            'password' => Hash::make('password'),
            'role' => 'student',
        ]);



        $admin = User::create([
            'name' => 'Ira Jacob Javier',
            'email' => 'admin@gordoncollege.edu.ph',
            'password' => Hash::make('password2'),
            'role' => 'admin',
        ]);



        // Sample students
        User::factory()->count(5)->create([
            'role' => 'student',
            'password' => Hash::make('student123'),
        ]);

        Tip::factory()->create([
            'title' => 'Eat a Balanced Diet',
            'content' => 'Include fruits, vegetables, proteins, and grains in every meal.',
            'category' => 'Balanced Diet',
            'created_by' => $admin->id,
        ]);

        Tip::factory()->count(15)->create();

    }
}
