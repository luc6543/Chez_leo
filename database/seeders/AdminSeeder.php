<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::firstOrCreate(
            [
                'email' => env('ADMIN_EMAIL') // search param
            ],
            [
                'name' => 'admin',
                'password' => Hash::make(env('ADMIN_PASSWORD'))
            ]);
        $user->assignRole('admin');
        $user->removeRole('klant');
    }
}
