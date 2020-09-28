<?php

Class Validador
{

    public static function ValidarClave($clave)
    {
        if(empty($clave))
        {
            echo "Debe ingresar una clave válida\n";

            return false;
        }else
        {
            return true;
        }
    }

    public static function ValidarTipoDeUsuario($tipo)
    {
        if(empty($tipo) || ($tipo !='admin' && $tipo !='user'))
        {
            echo "Debe ingresar un tipo de usuario válido\n";

            return false;
        }else
        {
            return true;
        }
    }


    public static function ValidarCorreo($email)
    {
        if(preg_match("/@/", $email)!=1 || empty($email) || preg_match("/[,;áéíóúñ]/", $email)!=0)
        {
            echo "Debe ingresar un email válido\n";

            return false;
        }else
        {
            return true;
        };
    }

}

?>