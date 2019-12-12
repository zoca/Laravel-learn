<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'role' => User::ADMINISTRATOR,
            'name' => 'Zorica Mijatovic',
            'email' => 'zoca@cubes.rs',
            'password' => Hash::make('cubes'),
            'address' => 'Bulevar mihajla Pupina 181, Beograd',
            'phone' => '060 410 59 82',
            'active' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
