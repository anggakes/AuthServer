<?php
/**
 * Created by PhpStorm.
 * User: anggakes
 * Date: 7/23/17
 * Time: 1:50 PM
 */

namespace App\Reponse;


use Illuminate\Contracts\Validation\Validator;

class JsonResponse
{

    static $successDevMessage = 'Proses Berhasil';
    static $successMessage = 'Proses Berhasil';

    static $errorDevMessage = 'Proses Gagal';
    static $errorMessage = 'Terjadi Kesalahan Server';

    static $debug = true;


    public static function success($data, $devMessage = '', $links = [], $message=''){

        $meta = [
            "code"          => 200,
            "devMessage"       => ($devMessage) ?: static::$successDevMessage,
            "message"    => ($message) ?: static::$successMessage,
        ];

        $response = [
            "status" => "success",
            "data" => $data,
            "meta" => $meta,
            "links" => $links
        ];

        return response(json_encode($response), 200, ["Content-Type" => "application/json"]);
    }

    public static function error($errorCode, $devMessage = '', $trace, $message=''){

        $meta = [
            "code"          => $errorCode,
            "devMessage"       => ($devMessage) ?: static::$errorDevMessage,
            "message"    => ($message) ?: static::$errorMessage,
            "debug" => $trace
        ];

        $response = [
            "status" => "error",
            "meta" => $meta
        ];

        return response(json_encode($response), $errorCode, ["Content-Type" => "application/json"]);
    }

    public static function unauthenticated($message){
        $errorCode = 401;
        $meta = [
            "code"          => $errorCode,
            "devMessage"    => $message,
            "message"       => 'unauthorized',
        ];

        $response = [
            "status" => "error",
            "meta" => $meta
        ];

        return response(json_encode($response), $errorCode, ["Content-Type" => "application/json"]);
    }

    public static function validatitonError(Validator $validator){
        $errorCode = 400;
        $meta = [
            "code"          => $errorCode,
            "devMessage"    => $validator->getMessageBag()->first(),
            "message"       => $validator->getMessageBag()->first(),
        ];

        $response = [
            "status" => "error",
            "meta" => $meta,
            "errors" => $validator->getMessageBag()->toArray()
        ];

        return response(json_encode($response), $errorCode, ["Content-Type" => "application/json"]);
    }

    public static function notFound(){
        $errorCode = 404;
        $meta = [
            "code"          => $errorCode,
            "devMessage"    => "Page Not Found",
            "message"       => "Halaman tidak ditemukan",
        ];

        $response = [
            "status" => "error",
            "meta" => $meta
        ];

        return response(json_encode($response), $errorCode, ["Content-Type" => "application/json"]);
    }

    public static function badRequest($devMessage, $message = ''){
        $errorCode = 400;
        $meta = [
            "code"          => $errorCode,
            "devMessage"    => $devMessage,
            "message"       => (!$message) ? $devMessage : $message,
        ];

        $response = [
            "status" => "error",
            "meta" => $meta
        ];

        return response(json_encode($response), $errorCode, ["Content-Type" => "application/json"]);
    }
}