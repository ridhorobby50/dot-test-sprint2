<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        $faker = Faker::create('id_ID');
        for ($i=0; $i <= 5; $i++) { 
            DB::table('users')->insert([
    			'name' => $faker->name(),
                'email' => $faker->unique()->safeEmail(),
                'password' => bcrypt('dot-sprint2')
    		]);
        }
    }
}
