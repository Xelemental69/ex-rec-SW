<h1>EQUIPO DE GUARDIA <?php echo $_POST["checkGuardia"] ?></h1>

<?php

$url = DIR_SERV . "/deGuardia/" . $_POST["dia"] . "/" . $_POST["hora"] . "/" . $_SESSION["id_usuario"];

$respuesta = consumir_servicios_REST($url, "GET", $key);

$obj = json_decode($respuesta);

if (!$obj) {

    session_destroy();
    die(error_page("EXAM_REC_SW_22_23", "Error servicio", "Error al conectar con la base de datos"));
}

if (isset($obj->error)) {

    session_destroy();
    die(error_page("EXAM_REC_SW_22_23", "Error servicio", $obj->errror));
}

if (isset($obj->mensaje)) {

    echo '<p>' . $obj->mensaje . '</p>';
} else {

    $url = DIR_SERV . "/usuariosGuardia/" . $_POST["dia"] . "/" . $_POST["hora"];

    $respuesta = consumir_servicios_REST($url, "GET", $key);

    $lista = json_decode($respuesta);

    if (!$lista) {

        session_destroy();
        die(error_page("EXAM_REC_SW_22_23", "Error servicio", "Error al conectar con la base de datos"));
    }

    if (isset($lista->error)) {

        session_destroy();
        die(error_page("EXAM_REC_SW_22_23", "Error servicio", $lista->errror));
    }

    if (isset($lista->mensaje)) {

        echo $lista->mensaje;
    } else {

        $once = true;
        $rows = 0;

        echo "<table>";

        echo "<tr><th>Profesores de Guardia</th><th>Información del Profesor con id_usuario</th></tr>";

        foreach ($lista->usuarios as $profesor) {$rows++;}

        foreach ($lista->usuarios as $profesor) {

            echo "<tr>";

            echo '<td><form action="index.php" method="post">';
            echo '<input type="hidden" name="dia" value="' . $_POST["dia"] . '" />';
            echo '<input type="hidden" name="hora" value="' . $_POST["hora"] . '" />';
            echo '<input type="hidden" name="id_usuario" value="' . $profesor->id_usuario . '" />';
            echo '<button type="submit" name="checkGuardia" class="enlace" value="' . $_POST["checkGuardia"] . '">' . $profesor->nombre . ' </button>';
            echo '</form></td>';

            if ($once) {

                echo "<td rowspan='" . $rows . '">';

                if (isset($_POST["id_usuario"])) {

                    $url = DIR_SERV . "/usuario/" . $_POST["id_usuario"];

                    $respuesta = consumir_servicios_REST($url, "GET", $key);

                    $user = json_decode($respuesta);

                    if (!$user) {

                        session_destroy();
                        die(error_page("EXAM_REC_SW_22_23", "Error servicio", "Error al conectar con la base de datos"));
                    }

                    if (isset($user->error)) {

                        session_destroy();
                        die(error_page("EXAM_REC_SW_22_23", "Error servicio", $user->errror));
                    }

                    if (isset($user->mensaje)) {

                        echo 'El profesor ya no se encuentra en esa hora';

                    } else {

                        echo "<strong>Nombre:</strong> " . $user->usuario->nombre . "<br/>";
                        echo "<strong>Usuario:</strong> " . $user->usuario->usuario . "<br/>";
                        echo "<strong>Contraseña:</strong> <em>(Oculto por privacidad)</em><br/>";
                        echo "<strong>Email:</strong> " . $user->usuario->email . "<br/>";

                    }
                }

                echo "</td>";
            }

            echo "</tr>";
        }

        echo "</table>";
    }
}
?>
//Jefe de equipo ESTOY A TOPE