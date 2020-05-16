<?php

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'João Martins',
            'email' => 'joaomartins.2000@gmail.com',
            'password' => bcrypt('123456'),
            'birtdate' => '1985-06-23',
            'cpf' => '05038183484',
        ]);

        DB::table('users')->insert([
            'name' => 'Aline Martins',
            'email' => 'alinefg.2000@gmail.com',
            'password' => bcrypt('123456'),
            'birtdate' => '1984-01-16',
            'cpf' => '04723112345',
        ]);

        DB::table('users')->insert([
            'name' => 'Tarciso Amorim',
            'email' => 'tarciso.amorim@gmail.com',
            'password' => bcrypt('123456'),
            'birtdate' => '1984-01-16',
            'cpf' => '01234567890',
        ]);
    }
}
