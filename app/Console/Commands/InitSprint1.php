<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\City;
use App\Models\Province;
use Illuminate\Support\Facades\Artisan;
use \Illuminate\Auth\AuthenticationException;

class InitSprint1 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'init:sprint1';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate sync data city and province to db';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Running migration...');
        Artisan::call('migrate');

        $this->syncProvince();
        $this->info('Sync Province executed');

        $this->syncCity();
        $this->info('Sync City executed');

        $this->info('Migration and custom logic completed.');

        
    }

    public function syncProvince(){
        $url = getenv('URL_API').'/province';
        $token = getenv('TOKEN_RAJAONGKIR');
        try {
            list($statusCode, $response) = getGuzzle($url, [], $token);
            $response = $response["rajaongkir"];
            if($response['status']['code']==200){
                $data_insert = [];
                foreach ($response["results"] as $key => $value) {
                    $data_insert[] = [
                        "province_id" => $value["province_id"],
                        "province_name" => $value["province"],
                        'created_at' => now(),
                        'updated_at' => now()
                    ];
                }
                Province::insert($data_insert);
            }
        } catch (AuthenticationException $e) {
            return redirect('login');
        }
    }

    public function syncCity(){
        $url = getenv('URL_API').'/city';
        $token = getenv('TOKEN_RAJAONGKIR');
        try {
            list($statusCode, $response) = getGuzzle($url, [], $token);
            $response = $response["rajaongkir"];

            if($response['status']['code']==200){
                $data_insert = [];
                foreach ($response["results"] as $key => $value) {
                    $data_insert[] = [
                        "city_id" => $value["city_id"],
                        "province_id" => $value["province_id"],
                        "type"        => $value["type"],
                        "city_name"   => $value["city_name"],
                        "postal_code" => $value["postal_code"],
                        'created_at' => now(),
                        'updated_at' => now()
                    ];
                }
                City::insert($data_insert);
            }
        } catch (AuthenticationException $e) {
            return redirect('login');
        }
    }
}
