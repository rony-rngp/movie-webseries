<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class Admin extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->delete();
        \App\Models\Admin::create([
           'name' => 'Rony Islam',
            'email' => 'rony.rng@gmail.com',
            'password' => Hash::make('11111111'),
        ]);
    }
}
