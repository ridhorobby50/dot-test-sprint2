<?php
    if (!function_exists('ResponseApi')) {
        function ResponseApi($data, $message){
            return [
                "data"  => [
                    "detail"  => $data,
                ],
            "message"   => $message
            ];
        }
    }
?>