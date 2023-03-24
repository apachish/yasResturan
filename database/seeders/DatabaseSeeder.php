<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::updateOrCreate(['email' => 'admin@yasrest.ir'],[
            'name' => 'admin',
            'family' => 'admin',
            'email' => 'admin@yasrest.ir',
            'mobile' => '09120242742',
            'national_code' => "1280423544",
            'password' => Hash::make('Javad13^@'),

        ]);
        \App\Models\User::updateOrCreate(['email' => 'admin@yasrest.ir'],[
            'name' => 'shahriar',
            'family' => 'pahlevansadegh',
            'email' => 'info@apachish.ir',
            'mobile' => '09120308527',
            'national_code' => "1292037210",
            'password' => Hash::make('123456'),

        ]);
    }
}
