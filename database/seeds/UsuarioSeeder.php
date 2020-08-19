<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
        $user1 = User::create([
            'name' => 'Giancarlo',
            'email' => 'gian@mail.com',
            'password' => Hash::make('11111111'),
            'url' => 'http://gian.com',
        ]);

        $user2 = User::create([
            'name' => 'Mafer',
            'email' => 'mafer@mail.com',
            'password' => Hash::make('11111111'),
            'url' => 'http://mafer.com',
        ]);
    }
}
