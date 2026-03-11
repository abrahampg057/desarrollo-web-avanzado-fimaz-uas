<?php

require_once "Usuario.php";
require_once "Admin.php";
require_once "Alumno.php";

$objusuarios = [];

try {
  
    $objadmin = new Admin("Carlos Lopez", "carlos@email.com");
    $objusuarios[] = $objadmin;

    $objalumno = new Alumno("Ana Torres", "ana@email.com", "A12345");
    $objusuarios[] = $objalumno;

    $objlumnoInvalido = new Alumno("Pedro Ruiz", "correo_invalido", "A54321");
    $objusuarios[] = $objalumnoInvalido;

} catch (Exception $e) {
    echo "<p style='color:red;'>Error: " . $e->getMessage() . "</p>";
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Lista de Usuarios</title>
</head>
<body>

<h2>Tabla de Usuarios</h2>

<table border="1" cellpadding="5">
    <tr>
        <th>Nombre</th>
        <th>Correo</th>
        <th>Rol</th>
        <th>Matrícula</th>
    </tr>

    <?php
    foreach ($usuarios as $u) {
        echo "<tr>";
        echo "<td>" . $u->getNombre() . "</td>";
        echo "<td>" . $u->getCorreo() . "</td>";
        echo "<td>" . $u->getRol() . "</td>";

        if ($u instanceof Alumno) {
            echo "<td>" . $u->getMatricula() . "</td>";
        } else {
            echo "<td>-</td>";
        }

        echo "</tr>";
    }
    ?>

</table>

</body>
</html>