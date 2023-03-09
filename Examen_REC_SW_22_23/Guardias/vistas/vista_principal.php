<p>Bienvenido <strong><?php echo $_SESSION["usuario"]; ?></strong></p>

<h2>Equipos de Guardia del IES Mar de Alborán</h2>

<table>

    <tr><th></th><th>Lunes</th><th>Martes</th><th>Miércoles</th><th>Jueves</th><th>Viernes</th></tr>

<?php

    $equipo = 0;

    for($i = 1; $i < 4; $i++){

        echo "<tr>";
        echo "<td>" . $i . "ºHora<td>";
        for($j = 1; $j < 6; $j++){

            $equipo++;

            echo '<td><form action="index.php" method="post">';
            echo '<input type="hidden" name="dia" value="' . $j . '" />';
            echo '<input type="hidden" name="hora" value="' . $i . '" />';
            echo '<button type="submit" name="checkGuardia" class="enlace" value="' . $equipo . '">Equipo ' . $equipo . ' </button></form></td>';

        }
        echo "<tr>";

    }

    echo "<tr colspan='6'>RECREO</tr>";

    for($i = 4; $i < 7; $i++){

        echo "<tr>";
        echo "<td>" . $i . "ºHora<td>";
        for($j = 1; $j < 6; $j++){

            $equipo++;

            echo '<td><form action="index.php" method="post">';
            echo '<input type="hidden" name="dia" value="' . $j . '" />';
            echo '<input type="hidden" name="hora" value="' . $i . '" />';
            echo '<button type="submit" name="checkGuardia" class="enlace" value="' . $equipo . '">Equipo ' . $equipo . ' </button></form></td>';

        }
        echo "<tr>";

    }

?>

</table>