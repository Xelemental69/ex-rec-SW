<?php
function consumir_servicios_REST($url,$metodo,$datos=null)
{
    $llamada=curl_init();
    curl_setopt($llamada,CURLOPT_URL,$url);
    curl_setopt($llamada,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($llamada,CURLOPT_CUSTOMREQUEST,$metodo);
    if(isset($datos))
        curl_setopt($llamada,CURLOPT_POSTFIELDS,http_build_query($datos));
    $respuesta=curl_exec($llamada);
    curl_close($llamada);
    return $respuesta;
}

function error_page($title,$cabecera,$mensaje)
{
    $html='<!DOCTYPE html><html lang="es"><head><meta charset="UTF-8"><meta http-equiv="X-UA-Compatible" content="IE=edge"><meta name="viewport" content="width=device-width, initial-scale=1.0">';
    $html.='<title>'.$title.'</title></head>';
    $html.='<body><h1>'.$cabecera.'</h1>'.$mensaje.'</body></html>';
    return $html;
}

define("MINUTOS", 5);
define("DIR_SERV", "http://localhost/Proyectos/Examen_REC_SW_22_23/servicios_rest");

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EXAM_REC_SW_22_23</title>
</head>
<body>

    <h1>Gestión de Guardias</h1>

    <?php        

        session_name("EXAM_REC_SW_22_23");
        session_start();

        if(isset($_SESSION["usuario"]) && isset($_SESSION["clave"]) && isset($_SESSION["id_usuario"])){

            require "src/seguridad.php";

            echo "Sesion iniciada";

            require "vistas/vista_principal.php";

            if(isset($_POST["checkGuardia"]))
                require "vistas/vista_guardia.php";

        }else{

            require "vistas/vista_login.php";

        }

        if(isset($_SESSION["seguridad"])) echo $_SESSION["seguridad"];

    ?>

</body>
</html>
