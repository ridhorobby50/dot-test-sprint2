<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class LoginTest extends TestCase
{
    public function test_Login()
    {   
        $faker = Faker::create('id_ID');
        $data = [
            'name' => $faker->name(),
            'email' => $faker->unique()->safeEmail(),
            'password' => bcrypt('dot-sprint2')
        ];
        DB::table('users')->insert($data);

        $userData = [
            "email" => $data["email"],
            "password" => 'dot-sprint2',
        ];
        
        $this->json('POST', 'api/v1/login', $userData, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                "token"
            ]);
        $this->assertAuthenticated();

        DB::table('users')->where('email', $data["email"])->delete();
    }

    public function testMustEnterEmailAndPassword()
    {
        $this->json('POST', 'api/v1/login', [], ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJson([
                "error" => [
                    'email' => ["The email field is required."],
                    'password' => ["The password field is required."],
                ]
            ]);
    }
}
