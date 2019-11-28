<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        factory(App\User::class, 30)->create();
        App\User::where('id', 1)->update(['email' => 'admin@lite.test']);
    }
}
