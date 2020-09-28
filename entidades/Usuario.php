<?php

require_once './auxiliares/Validador.php';
require_once './auxiliares/ManejadorDeArchivos.php';
require_once './auxiliares/Autenticador.php';

class Usuario
{
    private $_email;
    private $_tipo;
    private $_clave;

    public function __construct($email, $tipo, $clave)
    {
        $this->_email = $email;
        $this->_tipo = $tipo;
        $this->_clave = $clave;
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
       return $this->_email.'|'.$this->_tipo.'|'.$this->_clave;

       //return $this->_email." ".$this->_clave;//Descomentar si no se va a utilizar el split. 
    }

    public static function registrarUsuario($email, $tipo, $clave, $rutaArchivo)
    {    
        
        if(Usuario::validarDatosUsuario($email, $tipo, $clave))
        {
            $claveEncriptada = base64_encode($clave);

            $nuevoUsuario = new Usuario($email, $tipo, $claveEncriptada);

            if(!Usuario::encontrarUsuario($rutaArchivo, $nuevoUsuario))
            {
                ManejadorDeArchivos::guardarArchivo($rutaArchivo, $nuevoUsuario);

                //ManejadorDeArchivos::guardarArchivoJson($rutaArchivo, $nuevoUsuario);

                echo 'Usuario agregado';
            }else
            {
                echo 'El usuario ya existe';
            }
        }

    }

    public static function generarTokenUsuario($email, $clave, $rutaArchivo)
    {     
          
        if(Usuario::validarDatosUsuarioLogin($email, $clave))
        {
            $listaDeUsuarios = array();
    
            if(file_exists($rutaArchivo) && filesize($rutaArchivo) > 0)
            {    
                $archivoUsuarios = fopen($rutaArchivo, 'r');
                
                while(!feof($archivoUsuarios))
                {
                    $linea = fgets($archivoUsuarios);
                
                    $datos = explode('|', $linea);
                
                    if(count($datos)==3)
                    {    
                        
                        $usuarioCargado = new Usuario($datos[0], $datos[1],$datos[2]);

                        array_push($listaDeUsuarios,$usuarioCargado);                
                    }
                }
                
                foreach($listaDeUsuarios as $value)
                {
                  if($value->_email == $email)
                  {
                      $usuario = new Usuario($value->_email, $value->_tipo, base64_decode($value->_clave));
                  }
                }

            }else
            {
                echo "No hay usuarios registrados";

                return;
            }
    
            if(count($listaDeUsuarios)>0)
            {  
                foreach($listaDeUsuarios as $value)
                {
                    $correoListado = preg_replace( "/\r|\n/", "", $value->_email);

                   if($correoListado == $usuario->_email)
                   {
                        $claveListada = preg_replace( "/\r|\n/", "", $value->_clave);

                        $claveDesencriptada = base64_decode($claveListada);

                        if($claveDesencriptada == $usuario->_clave)
                        {

                           $respuesta = Autenticador::generadorDeToken($usuario->_email, $usuario->_tipo);

                           echo"$respuesta";
                        }else
                        {
                            echo "clave errónea";
                        }
                   }else
                   {
                    echo "usuario inexistente";
                   }
                }
            }
        }

    }

    public static function autenticarUsuario($token, $rutaArchivo)
    {     
        if(!empty($token)) 
        {
            $listaDeUsuarios = array();

            $usuarioToken = (array)$token;

            if(file_exists($rutaArchivo) && filesize($rutaArchivo) > 0)
            {    
                $archivoUsuarios = fopen($rutaArchivo, 'r');
                
                while(!feof($archivoUsuarios))
                {
                    $linea = fgets($archivoUsuarios);
                
                    $datos = explode('|', $linea);
                
                    if(count($datos)==3)
                    {    
                        
                        $usuarioCargado = new Usuario($datos[0], $datos[1], base64_decode($datos[2]));

                        array_push($listaDeUsuarios,$usuarioCargado);                
                    }
                }
                
                foreach($listaDeUsuarios as $value)
                {
                  if($value->_email == $usuarioToken["usuario"])
                  {
                      $usuario = new Usuario($value->_email, $value->_tipo, base64_decode($value->_clave));

                      return true;
                  }
                }
            }
            echo"No existe usuarios";
            return false;
        }
        echo"Token inválido";
        return false;
    }

    public static function validarTipoDeUsuario($token)
    {     
        if(!empty($token)) 
        {
            $usuarioToken = (array)$token;

            return $usuarioToken["tipo"];
        }
        echo"Token inválido";
        return "";
    }

    public static function validarDatosUsuarioLogin($email, $clave)
    {      
        $emailValido = Validador::ValidarCorreo($email);

        $claveValida = Validador::ValidarClave($clave);

        if($emailValido && $claveValida)
        {
            return true;
        }else
        {
            return false;
        }
    }

    public static function validarDatosUsuario($email, $tipo, $clave)
    {      
        $emailValido = Validador::ValidarCorreo($email);

        $tipoValido = Validador::ValidarTipoDeUsuario($tipo);

        $claveValida = Validador::ValidarClave($clave);

        if($emailValido && $claveValida &&  $tipoValido)
        {
            return true;
        }else
        {
            return false;
        }
    }

    public static function encontrarUsuario($rutaArchivo, $usuario)
    {     
        $listaDeUsuarios = array();

        $existeUsuario = true;

        if(file_exists($rutaArchivo))
        {    
            $archivoUsuarios = fopen($rutaArchivo, 'r');
            
            while(!feof($archivoUsuarios))
            {
                $linea = fgets($archivoUsuarios);
            
                $datos = explode('|', $linea);
            
                if(count($datos)==2)
                {                
                    $usuarioCargado = new Usuario($datos[0],$datos[1]);
                
                    array_push($listaDeUsuarios,$usuarioCargado);                
                }
            }
        }else
        {
            $existeUsuario = false;
        }

        if(count($listaDeUsuarios)>0)
        {
            $existeUsuario = false;

            foreach($listaDeUsuarios as $value)
            {
                $correoListado = preg_replace( "/\r|\n/", "", $value->_email);

               if($correoListado == $usuario->_email)
               {
                $existeUsuario = true;
               }
            }
        }

        return $existeUsuario;
    }
}


?>