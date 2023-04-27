<?php

namespace App\Repositories;

class Responses
{
    // Función mensaje correcto
    public function successRes($name, $data)
    {
        return response()->json(['ok' => true, $name => $data]);
    }
    // Función mensajes de error
    public function errorRes($message)
    {
        return response()->json(['ok' => false, 'message' => $message]);
    }
}
