<?php

require_once './auxiliares/Validador.php';
require_once './auxiliares/ManejadorDeArchivos.php';
require_once './auxiliares/Autenticador.php';

class Tarifario
{
    public $_hora;
    public $_estadia;
    public $_mes;

    public function __construct($hora, $estadia, $mes)
    {
        $this->_hora = $hora;
        $this->_estadia = $estadia;
        $this->_mes = $mes;
    }

    public function __get($name)
    {
        echo $this->$name;
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    public function __toString()
    {
        return $this->_hora.'|'.$this->_estadia.'|'.$this->_mes;
    }

    public static function registrarTarifario($hora, $estadia, $mes, $rutaArchivo)
    {      
        if(!empty($hora) || !empty($estadia) ||  !empty($mes) || !is_numeric($hora) || !is_numeric($estadia) ||  !is_numeric($mes))
        {

            $tarifario = new Tarifario($hora, $estadia, $mes);

            ManejadorDeArchivos::guardarArchivo($rutaArchivo, $tarifario);

            echo 'Tarifario actualizado';

        }else
        {
            echo 'Tarifas no válidas';
        }
    }

}


?>