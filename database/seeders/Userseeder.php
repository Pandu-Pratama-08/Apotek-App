<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class Userseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Administrator',
            'email' => 'adminapotek@gmail.com',
            'role' => 'admin',
            'password' => Hash::make('admin123')
        ]);
        User::create([
            'name' => 'Kasir 1',
            'email' => 'kasirapotek@gmail.com',
            'role' => 'kasir',
            'password' => Hash::make('kasir123')
        ]);
    }
}
