<?php

    require "vendor/autoload.php";//LLamo a la clase autoload.php para crear mi app
    require "clases/Usuario.php";

    $app = new Slim\App();//Creo mi app de la clase slim/app
    //Cuando vaya a la dirreccion "/" me tiene que mostrar el mensaje!
    $app->get("/", function($request, $response, $args)
    {
        $nick = $request->getParam("nick");
        $nick2 = $request->getParam("nick2");
        $response->write("Welcome to slim! $nick $nick2");//Con la funcion write escribo lo que va a recibir como mensaje.
        return $response;//Devuelvo el mensaje.
    });
    $app->get('/usuarios[/]', function ($request, $response, $args) {
    $listado=Usuario::TraerTodos();
    $response->write(json_encode($listado));
    
    return $response;
    });
    //BUSCAR AL USUARIO POR ID
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
    $app->get("/login", function($request, $response, $args)
    {
        $mail = $request->getParam("mail");
        $pass = $request->getParam("pass");
        $usuario=Usuario::Chequear($mail,$pass);
        if($usuario==false)
        {
            $response->write("Datos Incorrectos reingrese! ");
        }
    
        else
        {
            $response->write("Datos Correctos! Sus datos son:\n".json_encode($usuario));
        }
        return $response;//Devuelvo el mensaje.
    });
    //AGREGAR
    $app->post('/agregar', function ($request, $response, $args) {
    //$app->post('/usuario/{mail}/{pass}/{nick}', function ($request, $response, $args) {
    $usuario=new stdClass();
    $usuario->mail=$request->getParam("mail");
    $usuario->pass=$request->getParam("pass");
    $usuario->nick=$request->getParam("nick");
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
    //MODIFICAR
    $app->put('/modificar', function ($request, $response, $args) {
   
    $usuario=new stdClass();
    $usuario->id=$request->getParam("id");
    $usuario->mail=$request->getParam("mail");
    $usuario->pass=$request->getParam("pass");
    $usuario->nick=$request->getParam("nick");
    
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

  
    $app->run();//Tiene que estar si o si para que puede correr mi aplicacion.