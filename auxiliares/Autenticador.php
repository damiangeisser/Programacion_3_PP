<?php

require __DIR__ . '/vendor/autoload.php';
use \Firebase\JWT\JWT;

class Autenticador
{
    public static function generadorDeToken($usuario,$tipo)
    {
        $key = "primerparcial";
        $payload = array(
            "usuario" => $usuario,
            "tipo" => $tipo
        );

        $tokenAutenticacion = JWT::encode($payload, $key);

        return $tokenAutenticacion;
    }

    public static function valiladorDeToken($token)
    {
        $key = "primerparcial";

        try
        {
            $payload = JWT::decode($token, $key, array('HS256'));
        }
        catch(Exception $e)
        {
            echo "Token inválido";

            die();
        }
        
        return $payload;
    }


}

?>