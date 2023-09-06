<?php

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use \Illuminate\Auth\AuthenticationException;

if (!function_exists('storeGuzzle')) {

    function storeGuzzle($url, $data,$token=null)
    {   
        $client = new Client();
        $responseData = [];
        $statusCode = 0;

        $headers = [
            'Accept'        => 'application/json'
        ];

        if($token!=null){
            $headers["key"] = $token;
        }
        try {
            $response = $client->post($url, [
                'headers'   => $headers,
                'json'      => $data
            ]);

            $statusCode = $response->getStatusCode();
            $responseData = json_decode($response->getBody(), true);

            
            
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $statusCode = $response->getStatusCode();
            $responseData = json_decode($response->getBody(), true);
        } finally {
            if($statusCode==401){
                Session::flash('error', $responseData["message"] ?? $responseData["error"]);
                throw new AuthenticationException();
            }
            return [$statusCode, $responseData];
        }
    }
}


if (!function_exists('getGuzzle')) {

    function getGuzzle($url, $data,$token=null){
        $client = new Client();
        $responseData = [];
        $statusCode = 0;

        $headers = [
            'Accept'        => 'application/json'
        ];

        if($token!=null){
            $headers["key"] = $token;
        }
        try {
            $response = $client->get($url, [
                'headers'   => $headers,
                'query'      => $data
            ]);

            $statusCode = $response->getStatusCode();
            $responseData = json_decode($response->getBody(), true);

        } catch (ClientException $e) {
            $response = $e->getResponse();
            $statusCode = $response->getStatusCode();
            $responseData = json_decode($response->getBody(), true);

        } finally {
            if($statusCode==401){
                Session::flash('error', $responseData["message"] ?? $responseData["error"]);
                throw new AuthenticationException();
            }
            return [$statusCode, $responseData];
        }
    }
}

if (!function_exists('updateGuzzle')) {

    function updateGuzzle($url, $data,$token=null){
        $client = new Client();
        $responseData = [];
        $statusCode = 0;

        $headers = [
            'Accept'        => 'application/json'
        ];

        if($token!=null){
            $headers["Authorization"] = 'Bearer '.$token;
        }
        try {
            $response = $client->put($url, [
                'headers'   => $headers,
                'json'      => $data
            ]);

            $statusCode = $response->getStatusCode();
            $responseData = json_decode($response->getBody(), true);


        } catch (ClientException $e) {
            $response = $e->getResponse();
            $statusCode = $response->getStatusCode();
            $responseData = json_decode($response->getBody(), true);

        } finally {
            if($statusCode==401){
                Session::flash('error', $responseData["message"] ?? $responseData["error"]);
                throw new AuthenticationException();
            }
            return [$statusCode, $responseData];
        }
    }
}

if (!function_exists('deleteGuzzle')) {

    function deleteGuzzle($url, $data,$token=null){
        $client = new Client();
        $responseData = [];
        $statusCode = 0;

        $headers = [
            'Accept'        => 'application/json'
        ];

        if($token!=null){
            $headers["Authorization"] = 'Bearer '.$token;
        }
        try {
            $response = $client->delete($url, [
                'headers'   => $headers
            ]);

            $statusCode = $response->getStatusCode();
            $responseData = json_decode($response->getBody(), true);

        } catch (ClientException $e) {
            $response = $e->getResponse();
            $statusCode = $response->getStatusCode();
            $responseData = json_decode($response->getBody(), true);

        } finally {
            if($statusCode==401){
                Session::flash('error', $responseData["message"] ?? $responseData["error"]);
                throw new AuthenticationException();
            }
            return $statusCode;
        }
    }
}

