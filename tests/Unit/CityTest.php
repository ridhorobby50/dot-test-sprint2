<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class CityTest extends TestCase
{
    public function testUnauthRequestCity()
    {
        $this->json('GET', 'api/v1/search/cities')
            ->assertStatus(401)
            ->assertJson([
                "status" => "Authorization Token not found"
            ]);
    }

    public function testAuthRequestCityByDb()
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

        
        $this->json('GET', 'api/v1/search/cities',[], ['Authorization' => 'Bearer ' . $token])
            ->assertStatus(200)
            ->assertJsonStructure([
                "data" => [
                    "detail" =>[
                        "*" =>[
                            "city_id",
                            "province_id",
                            "type",
                            "city_name",
                            "postal_code",
                            "created_at",
                            "updated_at",
                            "province" => [
                                    "province_id",
                                    "province_name"
                                ]
                        ]
                    ]
                ],
                "message"
            ]);


        DB::table('users')->where('email', $data["email"])->delete();
    }

    public function testAuthRequestCityByOrigins()
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

        
        $this->json('GET', 'api/v1/search/cities',["origins" => 1], ['Authorization' => 'Bearer ' . $token])
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
                                "city_id",
                                "province_id",
                                "province",
                                "type",
                                "city_name",
                                "postal_code"
                            ]
                        ]
                        
                    ]
                ],
                "message"
            ]);

        DB::table('users')->where('email', $data["email"])->delete();
    }
}
