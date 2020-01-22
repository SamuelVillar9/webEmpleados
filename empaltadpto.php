<?php

    require "funciones.php";

    //RECOGIDA DE DATOS
    $servername = "localhost";
    $username = "root";
    $password = "rootroot";
    $dbname="empleadosnn";
    $nombre_dpto=limpiar_campo($_POST['nombre_dpto']);

    //CONEXION A LA BBDD
    $conn=conexion($servername, $username, $password, $dbname);

    if (!conexion($servername, $username, $password, $dbname)) {
        die("Conexion Fallida " . mysqli_connect_error());
    }

    $resultMax = 'SELECT max(cod_dpto) FROM departamento';
    $result = mysqli_query($conn, $resultMax);
    $codFinal = "";

    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $cod_max = $row['max(cod_dpto)'];
            $codFinal = substr($cod_max, 1);
            settype($codFinal, 'integer');
            $codFinal = $codFinal+1;
            $codFinal = str_pad($codFinal, 3, "0", STR_PAD_LEFT);
            $codFinal = "D" . $codFinal;        
        }
    } else {
        $codFinal = "D001";
    }

    //INSERTAMOS EN TABLA DEPARTAMENTO
    $sql = "INSERT INTO departamento (cod_dpto, nombre_dpto) VALUES ('$codFinal', '$nombre_dpto')";

    // COMPROBAR CONEXION
    if (mysqli_query($conn, $sql)) {
        echo "Datos introducidos correctamente";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
    //CERRAMOS CONEXION CON LA BASE DE DATOS
    mysqli_close($conn);


?>