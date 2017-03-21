<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require 'vendor/autoload.php';
require "clases/Usuario.php";
//require "clases/AccesoDatos.php";

$app = new \Slim\App;

$app->get('/hello/{name}', function (Request $request, Response $response ,$args) 
{
    $name = $request->getAttribute('name');
    //$nick = $request->getParam("nick");
    $response->getBody()->write("Hello, $name ");
    

    return $response;
});

$app->get('/bye/{name}/{apellido}', function (Request $request, Response $response) 
{
    $name = $request->getAttribute('name');
    //$apellido="flores";
    $apellido = $request->getAttribute('apellido');
    $response->getBody()->write("Bye, $name $apellido");
    

    return $response;
});
//TRAER TODOS LOS USUARIOS!
$app->get('/usuarios[/]', function ($request, $response, $args) {
    $listado=Usuario::TraerTodos();
    $response->write(json_encode($listado));
    
    return $response;
});
//BUSCAR POR ID
$app->get('/usuario/{id}', function ($request, $response, $args) {
    $usuario=Usuario::Buscar($args['id']);
    if($usuario==false)
    {
        $response->write("No se encontro datos de ese ID");
    }
   
    else
    {
        $response->write("ID encontrado!\n".json_encode($usuario));
    }
   // $response->write(json_encode($usuario));
    return $response;
});
//LOGIN
$app->get('/usuario/login', function ($request, $response, $args) {
//$app->get('/usuario/{mail}/{pass}', function ($request, $response, $args) { OTRA OPCION 1
    $nick=$request->getParam("nick");
    $mail=$request->getParam("mail");
    $pass=$request->getParam("pass");
    $usuario=Usuario::Chequear($mail,$pass);
    //$usuario=Usuario::Chequear($args['mail'],$args["pass"]); OTRA OPCION 1
    if($usuario==false)
    {
        $response->write("Datos Incorrectos reingrese! $nick");
    }
   
    else
    {
        $response->write("Datos Correctos! $nick Sus datos son:\n".json_encode($usuario));
    }
    return $response;
});
//ELIMINAR
$app->delete('/eliminar/{id}', function ($request, $response, $args) {
    $id=$args["id"];
    $cantidad=Usuario::Eliminar($args['id']);
    if($cantidad>0)
    {
        $response->write("Se elimino correctamente al usuario con ID: $id");
    }
    else
    {
        $response->write("No se pudo eliminar o ID no encontrado!");
    }
    
    return $response;
});
//AGREGAR
$app->post('/agregar/{mail}/{pass}/{nick}', function ($request, $response, $args) {
    //$app->post('/usuario/{mail}/{pass}/{nick}', function ($request, $response, $args) {
    $usuario=new stdClass();
    $usuario->mail=$args["mail"];
    $usuario->pass=$args["pass"];
    $usuario->nick=$args["nick"];
    //$response->write("Soy $usuario->nick\n mi mail es: $usuario->mail y mi password es : $usuario->pass");
    $cantidad=Usuario::Agregar($usuario);
    if($cantidad>0)
    {
        $response->write("Se agrego correctamente al usuario $usuario->nick");
    }
    else
    {
        $response->write("No se pudo guardar !");
    }

    return $response;
});
//MODIFICAR
$app->put('/modificar/{mail}/{pass}/{nick}/{id}', function ($request, $response, $args) {
   // $app->put('/usuario/{mail}/{pass}/{nick}/{id}', function ($request, $response, $args) {
    $usuario=new stdClass();
    $usuario->id=$args["id"];
    $usuario->mail=$args["mail"];
    $usuario->pass=$args["pass"];
    $usuario->nick=$args["nick"];
    //$response->write("Soy $usuario->nick\n mi mail es: $usuario->mail y mi password es : $usuario->pass");
    $cantidad=Usuario::Modificar($usuario);
    if($cantidad>0)
    {
        $response->write("Se modifico correctamente al usuario con ID: $usuario->id");
    }
    else
    {
        $response->write("No se pudo modificar o ID no encontrado!");
    }
    return $response;
});
$app->run();
?>