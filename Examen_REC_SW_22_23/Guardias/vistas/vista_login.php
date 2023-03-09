<?php

if(isset($_POST["btnLogin"])){

    $error_usuario = $_POST["usuario"] == "";
    $error_clave = $_POST["clave"] == "";

    $error_form = $error_usuario || $error_clave;

    if(!$error_form){

        $url = DIR_SERV . "/login";

        $datos['usuario'] = $_POST["usuario"];
        $datos['clave'] = md5($_POST["clave"]);

        $respuesta = consumir_servicios_REST($url, "POST", $datos);        

        $obj = json_decode($respuesta);

        if(!$obj){

            session_destroy();
            die(error_page("EXAM_REC_SW_22_23","Error servicio","<p>Error consumiendo el servicio: " . $url . "</p>" . $respuesta));
        
        }
        
        if(isset($obj->error)){
        
            session_destroy();
            die(error_page("EXAM_REC_SW_22_23","Error servicio",$obj->errror));
        
        }

        if(isset($obj->mensaje)){

            $error_usuario = true;
            $no_user = $obj->mensaje;

        }else{

            session_name("EXAM_REC_SW_22_23");
            session_start();

            $_SESSION["usuario"] = $_POST["usuario"];
            $_SESSION["clave"] = $_POST["clave"];
            $_SESSION["id_usuario"] = $obj->usuario->id_usuario;
            $_SESSION["ultimo_acceso"] = time();
            $_SESSION["api_session"] = $obj->api_session;

            header("Location:index.php");
            exit;

        }

    }

}

?>


<form action="index.php" method="post">

    <p><label for="usuario">Usuario: </label>
    <input type="text" name="usuario" id="usuario" value='<?php if(isset($_POST["btnLogin"]))  echo $_POST["usuario"]; ?>' />
    <?php if(isset($_POST["btnLogin"]) && $error_usuario)  
        if($_POST["usuario"] == '') echo "<span class='error'> * Campo Vacío * </span>";
        else echo "<span class='error'> * " . $no_user ." * </span>"; ?>    
    </p>

    <p><label for="clave">Contraseña: </label>
    <input type="password" name="clave" id="clave" value="" />
    <?php if(isset($_POST["btnLogin"]) && $error_clave)  echo "<span class='error'> * Campo Vacío * </span>"; ?>
    </p>

    <button type="submit" name="btnLogin" >Entrar</button>

</form>