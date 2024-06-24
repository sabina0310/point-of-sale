<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('m_user')->insert([
            'username' => 'admin',
            'name' => 'Admin',
            'role' => 'admin',
            'password' => bcrypt('123')
        ]);
    }
}
