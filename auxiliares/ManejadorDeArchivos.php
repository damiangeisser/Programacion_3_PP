<?php

class ManejadorDeArchivos{


    public static function guardarArchivo($nombreArchivo, $contenido)
    {
        $archivo = fopen($nombreArchivo, 'a+');

        fwrite($archivo , $contenido.PHP_EOL);

        fclose($archivo);
    }
}



?>