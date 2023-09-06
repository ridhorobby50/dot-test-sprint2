<?php

namespace App\Http\Controllers;

use App\Models\Province;
use Illuminate\Http\Request;
use \Illuminate\Auth\AuthenticationException;

class ProvinceController extends Controller
{   
    public $route = "province";

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
                        "province_id" => $value["province_id"],
                        "province_name" => $value["province"],
                        'created_at' => now(),
                        'updated_at' => now()
                    ];
                }
                Province::insert($data_insert);
            }
        } catch (AuthenticationException $e) {
        }
    }

    public function getData(Request $request){
        $origins = $request->origins ?? 0;
        if($origins==0){
            $data = Province::get();
            return response()->json(ResponseApi($data, "Success get data province"), 200);
        }else{
            list($statusCode, $response, $message) = $this->getFromOrigins();
            return response()->json(ResponseApi($response, $message), $statusCode);
        }
    }

    protected function getFromOrigins(){
        $url = getenv('URL_API').'/province';
        $token = getenv('TOKEN_RAJAONGKIR');
        try {
            list($statusCode, $response) = getGuzzle($url, [], $token);
            $response = $response["rajaongkir"];
            return [$statusCode, $response, "Success get data province from origins"];
        } catch (AuthenticationException $e) {
            return [400, [], "Failed get data province from origins"];
        }
    }
}
