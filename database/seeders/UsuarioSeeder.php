<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'first_name' => 'admin',
            'last_name' => 'admin',
            'phone' => '123456789',
            'email' => 'admin@admin.com',
            'password' => Hash::make('654321'),
            'estado' => 1,
            'rol_id' => 1
        ]);
    }
}
