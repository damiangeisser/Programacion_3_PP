<?php

require_once './entidades/Usuario.php';
require_once './entidades/Tarifario.php';

$method = $_SERVER['REQUEST_METHOD'];

$path_info = $_SERVER['PATH_INFO']; //Entidad '/nombre_entidad'

$rutaUsuarios = './archivos/usuarios.txt';

$rutaPrecios = './archivos/precios.txt';

if(!empty($_SERVER['HTTP_TOKEN']))
{
    $token = $_SERVER['HTTP_TOKEN'];
}

switch($method){
    case'GET':
        switch($path_info)
        {
            case '/materia':


               $token = Autenticador::valiladorDeToken($_SERVER['HTTP_TOKEN']);

               if(Usuario::autenticarUsuario($token, $rutaUsuarios))
               {
                   Materia::listarMaterias($rutaMaterias);
               }
            break;
            default:
            break;
        }
    break;
    case'POST':
        switch($path_info)
        {
            case '/registro':
                Usuario::registrarUsuario($_POST['email'] ?? "",$_POST['tipo'] ?? "",$_POST['password'] ?? "", $rutaUsuarios);
            break;

            case '/login':
                Usuario::generarTokenUsuario($_POST['email'] ?? "",$_POST['password'] ?? "", $rutaUsuarios);
            break;
            case '/precio':
               $token = Autenticador::valiladorDeToken($_SERVER['HTTP_TOKEN']);


               if(Usuario::autenticarUsuario($token, $rutaUsuarios))
               {
                    if(Usuario::validarTipoDeUsuario($token) == 'admin')
                    {
                        Tarifario::registrarTarifario($_POST['precio_hora'] ?? "",$_POST['precio_estadia'] ?? "",$_POST['precio_mensual'] ?? "", $rutaMaterias);
                    }
                }
            break;

            default:
            break;
        }
    break;
    case'PUT':
        echo "Se utilizó PUT, no se encuentra implementado\n";
    break;
    case'DELETE':
        echo "Se utilizó DELETE, no se encuentra implementado\n";
    break;
    default:
        echo "Ocurrió un error en la interpretación del METHOD\n";
    break;
}


?>