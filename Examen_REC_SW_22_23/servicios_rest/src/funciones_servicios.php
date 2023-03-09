<?php
require "config_bd.php";

function conexion_pdo()
{
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
        
        $respuesta["mensaje"]="Conexi&oacute;n a la BD realizada con &eacute;xito";
        
        $conexion=null;
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
    }
    return $respuesta;
}


function login($datos, $first_time=true){

    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
        
        try{

            try{

                $consulta = "select * from usuarios where usuario=? and clave=?";
                
                $sentencia = $conexion->prepare($consulta);
                $sentencia->execute($datos);
    
                if($sentencia->rowCount() > 0){
    
                    $respuesta["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC);
    
                    if($first_time){
    
                        session_name("API_REC_SW_22_23");
                        session_start();
    
                        $_SESSION["usuario"] = $datos[0];
                        $_SESSION["clave"] = $datos[1];
                        $respuesta["api_session"] = session_id();
    
                    }
    
                }else{
    
                    $respuesta["mensaje"] = "El usuario no se encuentra registrado en la BD";
    
                }
                
            }
            
        }
        catch(PDOException $e){
            $respuesta["error"]="Imposible conectar:".$e->getMessage();
        }
        
        $conexion=null;
        $sentencia = null;
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
    }
    return $respuesta;

}

function getUser($datos){

    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
        
        try{

            $consulta = "select * from usuarios where id_usuario=?";
            
            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute($datos);

            if($sentencia->rowCount() > 0){

                $respuesta["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC);

            }else{

                $respuesta["mensaje"] = "El usuario con id " . $datos[0] ." no se encuentra registrado en la BD";

            }
            
        }
        catch(PDOException $e){
            $respuesta["error"]="Imposible conectar:".$e->getMessage();
        }
        
        $conexion=null;
        $sentencia = null;
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
    }
    return $respuesta;

}

function usuariosGuardia($datos){

    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
        
        try{

            $consulta = "select * from usuarios join horario_guardias where usuarios.id_usuario=horario_guardias.usuario and dia=? and hora=?";
            
            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute($datos);

            if($sentencia->rowCount() > 0){

                $respuesta["usuarios"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);

            }else{

                $respuesta["mensaje"] = "No se encuentran usuarios en el día " . $datos[0] ." y hora " . $datos[1] . " en la BD";

            }
            
        }
        catch(PDOException $e){
            $respuesta["error"]="Imposible conectar:".$e->getMessage();
        }
        
        $conexion=null;
        $sentencia = null;
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
    }
    return $respuesta;

}

function deGuardia($datos){

    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
        
        try{

            $consulta = "SELECT * from usuarios JOIN horario_guardias WHERE usuarios.id_usuario=horario_guardias.usuario and dia=? and hora=? and id_usuario=?;";
            
            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute($datos);

            if($sentencia->rowCount() > 0){

                $respuesta["profesor"] = $sentencia->fetch(PDO::FETCH_ASSOC);

            }else{

                switch($datos[0]){

                    case 1:
                        $diaSemana = "Lunes";
                        break;
                    
                    case 2:
                        $diaSemana = "Martes";
                        break;

                    case 3:
                        $diaSemana = "Miércoles";
                        break;
                    
                    case 4:
                        $diaSemana = "Jueves";
                        break;
    
                    case 5:
                        $diaSemana = "Viernes";
                        break;

                }

                $respuesta["mensaje"] = "¡¡ Atención, usted no se encuentra de guardia el " . $diaSemana . " a " . $datos[1] . "ª hora !!";

            }
            
        }
        catch(PDOException $e){
            $respuesta["error"]="Imposible conectar:".$e->getMessage();
        }
        
        $conexion=null;
        $sentencia = null;
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
    }
    return $respuesta;

}

?>
