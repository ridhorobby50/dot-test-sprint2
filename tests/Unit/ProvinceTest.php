<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ProvinceTest extends TestCase
{
    public function testUnauthRequestProvince()
    {
        $this->json('GET', 'api/v1/search/province')
            ->assertStatus(401)
            ->assertJson([
                "status" => "Authorization Token not found"
            ]);
    }

    public function testAuthRequestProvinceByDb()
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
        
        $response = $this->json('POST', 'api/v1/login', $userData, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                "token"
            ]);
        $this->assertAuthenticated();

        $token = $response->json('token');

        
        $this->json('GET', 'api/v1/search/province',[], ['Authorization' => 'Bearer ' . $token])
            ->assertStatus(200)
            ->assertJsonStructure([
                "data" => [
                    "detail" =>[
                        "*" =>[
                            "province_id",
                            "province_name",
                            "created_at",
                            "updated_at"
                        ]
                    ]
                ],
                "message"
            ]);


        DB::table('users')->where('email', $data["email"])->delete();
    }

    public function testAuthRequestProvinceByOrigins()
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
        
        $response = $this->json('POST', 'api/v1/login', $userData, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                "token"
            ]);
        $this->assertAuthenticated();

        $token = $response->json('token');

        
        $this->json('GET', 'api/v1/search/province',["origins" => 1], ['Authorization' => 'Bearer ' . $token])
            ->assertStatus(200)
            ->assertJsonStructure([
                "data" => [
                    "detail" =>[
                        "query",
                        "status" => [
                            "code", "description"
                        ],
                        "results" => [
                            "*" =>[
                                "province_id",
                                "province"
                            ]
                        ]
                        
                    ]
                ],
                "message"
            ]);


        DB::table('users')->where('email', $data["email"])->delete();
    }
}
