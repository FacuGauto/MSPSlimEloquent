<?php
namespace App\Models\ORM;

use App\Models\AutentificadorJWT;
use App\Models\ORM\Usuario;
use App\Models\IApiControler;

include_once __DIR__ . '/usuario.php';
include_once __DIR__ . '../../modelAPI/IApiControler.php';
include_once __DIR__ . '../../modelAPI/AutentificadorJWT.php';


use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


class UsuarioController implements IApiControler 
{
 	public function Beinvenida($request, $response, $args) {
      $response->getBody()->write("GET => Bienvenido!!! ,a UTN FRA SlimFramework");
    
    return $response;
    }
    
    public function TraerTodos($request, $response, $args) {
       	//return cd::all()->toJson();
        $todosLosUsuarios=usuario::all();
        $newResponse = $response->withJson($todosLosUsuarios, 200);  
        return $newResponse;
    }
    public function TraerUno($request, $response, $args) {
        $id = $args['id'];
        $usuario = usuario::find($id);
        $newResponse = $response->withJson($usuario, 200);  
        return $newResponse;
    }
   
    public function CargarUno($request, $response, $args) {
        $arry_params = $request->getParsedBody();
        $usuario= new usuario;
        $usuario->nombre = $arry_params['nombre'];
        $usuario->email = $arry_params['email'];
        $usuario->clave = $arry_params['clave'];
        $usuario->tipo = $arry_params['tipo'];
        $usuario->legajo = rand(10000, 99999);
        $usuario->save();
        $newResponse = $response->withJson($usuario, 200);  
        return $newResponse;
    }

      public function BorrarUno($request, $response, $args) {
  		//complete el codigo
     	$newResponse = $response->withJson("sin completar", 200);  
      	return $newResponse;
    }
     
     public function ModificarUno($request, $response, $args) {
        $legajo = $args['legajo'];
        $datos = $request->getParsedBody();
        $tipo = $datos['tipo'];
        $usuario = Usuario::where('usuarios.legajo','=',$legajo)->get()->first();
        switch ($tipo) {
            case 'alumno':
                return $this->ModificarAlumno($usuario,$datos,$response);
                break;
            case 'profesor':
                break;
            case 'admin':
                break;
            default:
                break;
        }
    }

    public function ModificarAlumno($alumno, $body, $response)
    {
        $alumno = Usuario::find($alumno['id']);
        if (array_key_exists("email", $body)) {
            $alumno->email = $body["email"];
        }
        $alumno->save();
        return $response->withJson($alumno, 200);
    }

    public function Login($request,$response,$args){
        $datos = $request->getParsedBody();
        $nombre = $datos['nombre'];
        $usuario = Usuario::where('usuarios.legajo','=',$datos['legajo'])->get()->first();
        if ($usuario) {
          $token = AutentificadorJWT::CrearToken($nombre);
          $newResponse = $response->withJson($token, 200);
        }
        else {
          $newResponse = $response->withJson("No se pudo iniciar sesion, vuelva a intentarlo", 200);
        }
        return $newResponse;

    }
  
}