<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Models\ORM\Usuario;
use App\Models\ORM\UsuarioController;
use App\Models\ORM\Materia;
use App\Models\ORM\MateriaController;


include_once __DIR__ . '/../../src/app/modelORM/usuario.php';
include_once __DIR__ . '/../../src/app/modelORM/usuarioControler.php';
include_once __DIR__ . '/../../src/app/modelORM/materia.php';
include_once __DIR__ . '/../../src/app/modelORM/materiaControler.php';

return function (App $app) {
    $container = $app->getContainer();

    $app->group('/usuario', function () {   

        $this->get('[/]', UsuarioController::class . ':traerTodos');

        $this->get('/{id}', UsuarioController::class . ':traerUno');

        $this->post('/', UsuarioController::class . ':cargarUno');

        $this->post('/{legajo}', UsuarioController::class . ':modificarUno');

    });

    $app->group('/login', function () {
      
      $this->post('/',UsuarioController::class . ':login');
   
    });

    $app->group('/materia', function () {

      $this->get('[/]',MateriaController::class . ':traerTodos');

      $this->get('/{id}', MateriaController::class . ':traerUno');
      
      $this->post('/', MateriaController::class . ':cargarUno')->add(Middleware::class . ':esAdmin');
   
    });

};