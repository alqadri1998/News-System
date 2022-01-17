<?php

use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        \App\Admin::create([
            'name' => 'SuperAdmin',
            'email' => 'super-admin@news.com',
            'mobile' => '14141414',
            'password' => \Illuminate\Support\Facades\Hash::make(1234),
            'age' => '33',
            'gender' => 'Male'
        ]);
    }
}
