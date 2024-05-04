<?php

if (! function_exists('response_api')) {
    function response_api($data, $success = true, $message = '', $code = 200)
   {
        return response()->json([
            "data"=> $data,
            "success"=> $success,
            "message"=> $message
        ], $code);
    }
}