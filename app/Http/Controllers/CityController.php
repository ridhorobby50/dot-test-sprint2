<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;
use \Illuminate\Auth\AuthenticationException;
class CityController extends Controller
{
    public $route = "city";

    public function sync(){
        $url = getenv('URL_API').$this->route;
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
        }
    }

    public function getData(Request $request){
        $origins = $request->origins ?? 0;
        if($origins==0){
            $data = City::with([
                'province' => function ($query) {
                    $query->select('province_id', 'province_name');
                }
            ])->get();
            return response()->json(ResponseApi($data, "Success get data city"), 200);
        }else{
            list($statusCode, $response, $message) = $this->getFromOrigins();
            return response()->json(ResponseApi($response, $message), $statusCode);
        }
    }

    protected function getFromOrigins(){
        $url = getenv('URL_API').'/city';
        $token = getenv('TOKEN_RAJAONGKIR');
        try {
            list($statusCode, $response) = getGuzzle($url, [], $token);
            $response = $response["rajaongkir"];
            return [$statusCode, $response, "Success get data city from origins"];
        } catch (AuthenticationException $e) {
            return [400, [], "Failed get data city from origins"];
        }
    }
}
