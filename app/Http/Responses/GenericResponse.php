<?php

namespace App\Http\Responses;

use Illuminate\Http\Response;

class GenericResponse
{
    public static function response($array)
    {
        return (new Response(['data' => $array['message'], 'status' => $array['status']], $array['status']))
        ->header('Content-Type', 'application/json');
    }
}