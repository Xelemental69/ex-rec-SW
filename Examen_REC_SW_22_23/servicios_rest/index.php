<?php

require "src/funciones_servicios.php";
require __DIR__ . '/Slim/autoload.php';

$app= new \Slim\App;

$app->post("/salir", function($request){

    session_id($request->getParam("api_session"));
    session_start();
    session_destroy();

    echo json_encode(array("log_off" => "Sesión destruida con éxito"));

});

$app->get('/conexion_PDO',function($request){

    echo json_encode(conexion_pdo());
});

$app->post('/login', function($request){

    $datos[] = $request->getParam('usuario');
    $datos[] = $request->getParam('clave');
    
    echo json_encode(login($datos));

});

$app->get('/logueado', function($request){
    session_id($request->getParam('api_session'));
    session_start();
    if (isset($_SESSION["usuario"])) {
        $datos[] = $_SESSION["usuario"];
        $datos[] = $_SESSION["clave"];
        echo json_encode(login($datos, false));
    } else {
        session_destroy();
        echo json_encode(array("no_auth" => "No tienes permiso para usar este servicio"));
    }

});

$app->get('/usuario/{id_usuario}', function($request){

    session_id($request->getParam('api_session'));
    session_start();
    if (isset($_SESSION["usuario"])) {

        $datos[] = $request->getAttribute("id_usuario");

        echo json_encode(getUser($datos));

    }else{
        session_destroy();
        echo json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));

    }

});

$app->get('/usuariosGuardia/{dia}/{hora}', function($request){

    session_id($request->getParam('api_session'));
    session_start();
    if (isset($_SESSION["usuario"])) {

        $datos[] = $request->getAttribute("dia");
        $datos[] = $request->getAttribute("hora");

        echo json_encode(usuariosGuardia($datos));

    }else{
        session_destroy();
        echo json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));

    }

});

$app->get('/deGuardia/{dia}/{hora}/{id_usuario}', function($request){

    session_id($request->getParam('api_session'));
    session_start();
    if (isset($_SESSION["usuario"])) {

        $datos[] = $request->getAttribute("dia");
        $datos[] = $request->getAttribute("hora");
        $datos[] = $request->getAttribute("id_usuario");

        echo json_encode(deGuardia($datos));

    }else{
        session_destroy();
        echo json_encode(array("no_auth" => "No tienes permisos para usar este servicio"));

    }

});

// Una vez creado servicios los pongo a disposición
$app->run();
?>
