<?php

$url = DIR_SERV . '/logueado';
$key['api_session'] = $_SESSION["api_session"];
$respuesta = consumir_servicios_REST($url, "GET", $key);
$obj = json_decode($respuesta);

if(!$obj){

    $url = DIR_SERV . "/salir";
    consumir_servicios_REST($url, "POST", $key);
    session_destroy();
    die();

}

if(isset($obj->error)){

    $url = DIR_SERV . "/salir";
    consumir_servicios_REST($url, "POST", $key);
    session_destroy();
    die();

}

if(isset($obj->no_auth)){

    session_unset();
    $_SESSION["seguridad"] = "API agotada";
    header("Location:" . $salto);
    exit;

}

if(isset($obj->usuario)){

    if(time() - $_SESSION["ultimo_acceso"] > MINUTOS*60){

        session_unset();
        $_SESSION["seguridad"] = "El tiempo de sesión ha expirado";
        header("Location:" . $salto);
        exit;

    }

}else{

    $url = DIR_SERV . "/salir";
    consumir_servicios_REST($url, "POST", $key);
    $_SESSION["seguridad"] = "Zona restringida";
    header("Location:" . $salto);
    exit;

}

$datos_usuario = $obj->usuario;
$_SESSION["ultimo_acceso"] = time();

?>