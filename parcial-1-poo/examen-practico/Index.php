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

    <style>
        body{
            font-family: Arial, Helvetica, sans-serif;
            background-color: #f4f6f9;
            margin:0;
            padding:0;
        }

        h2{
            text-align:center;
            margin-top:40px;
            color:#333;
        }
    table{
            border-collapse: collapse;
            margin:40px auto;
            width:70%;
            background:white;
            box-shadow:0px 4px 10px rgba(0,0,0,0.1);
        }

    th{
            background-color:#2c3e50;
            color:white;
            padding:12px;
            text-transform:uppercase;
            font-size:14px;
        }
        td{
            padding:10px;
            text-align:center;
            border-bottom:1px solid #ddd;
        }

        tr:hover{
            background-color:#f2f2f2;
        }

        tr:nth-child(even){
            background-color:#fafafa;
        }
    </style>

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
    foreach ($objusuarios as $u) {
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