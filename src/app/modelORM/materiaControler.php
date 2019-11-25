<?php
namespace App\Models\ORM;
use App\Models\ORM\materia;
use App\Models\IApiControler;

include_once __DIR__ . '/materia.php';
include_once __DIR__ . '../../modelAPI/IApiControler.php';

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


class MateriaController implements IApiControler 
{
    public function TraerTodos($request, $response, $args) {
        $todasLasMaterias=materia::all();
        $newResponse = $response->withJson($todasLasMaterias, 200);  
        return $newResponse;
    }
    public function TraerUno($request, $response, $args) {
      $id = $args['id'];
      $usuario = materia::find($id);
      $newResponse = $response->withJson($usuario, 200);  
      return $newResponse;
    }
   
      public function CargarUno($request, $response, $args) {
     	  $arry_params = $request->getParsedBody();
        $materia = new materia;
        $materia->nombre = $arry_params['nombre'];
        $materia->cuatrimestre = $arry_params['cuatrimestre'];
        $materia->cupo = $arry_params['cupo'];
        $materia->save();
        $newResponse = $response->withJson($materia, 200);  
        return $newResponse;
    }
      public function BorrarUno($request, $response, $args) {
  		//complete el codigo
     	$newResponse = $response->withJson("sin completar", 200);  
      	return $newResponse;
    }
     
     public function ModificarUno($request, $response, $args) {
     	//complete el codigo
     	$newResponse = $response->withJson("sin completar", 200);  
		return 	$newResponse;
    }


  
}