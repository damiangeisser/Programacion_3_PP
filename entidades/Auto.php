<?php

require_once './auxiliares/Validador.php';
require_once './auxiliares/ManejadorDeArchivos.php';
require_once './auxiliares/Autenticador.php';

class Auto
{
    public $_patente;
    public $_tipo;
    public $_fechaIngreso;
    public $_fechaEgreso;

    public function __construct($patente, $tipo, $fechaIngreso,$fechaEgreso)
    {
        $this->_patente = $patente;
        $this->_tipo = $tipo;
        $this->_fechaIngreso = $fechaIngreso;
        $this->_fechaEgreso = $fechaEgreso ?? "";
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
        return $this->_patente.'|'.$this->_tipo.'|'.$this->_fechaIngreso.'|'.$this->_fechaEgreso ?? "";
    }

    public static function registrarIngresoVehiculo($patente, $tipo, $ingreso, $rutaArchivo)
    {      
        if(!empty($patente) || !empty($tipo))
        {

            $auto = new Auto($patente, $tipo, $ingreso,"-");

            ManejadorDeArchivos::guardarArchivo($rutaArchivo, $auto);

            echo 'Vehículo ingresado';
        }else
        {
            echo 'Vehículo no válidas';
        }
    }

    public static function retirarVehiculo($patente, $tipo, $ingreso, $rutaArchivo)
    {      
        if(!empty($patente) || !empty($tipo))
        {

            $auto = new Auto($patente, $tipo, $ingreso,"-");

            ManejadorDeArchivos::guardarArchivo($rutaArchivo, $auto);

            echo 'Vehículo ingresado';
        }else
        {
            echo 'Vehículo no válidas';
        }
    }

}


?>