<head>
    <title>VER HISTORICO</title>
</head>
<h1>VER HISTORICO DE EMPLEADOS DE UN DEPARTAMENTO</h1>
<?php


    require "funciones.php";

    /* Conexión BD */
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'rootroot');
define('DB_DATABASE', 'empleadosnn');
$db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
   
   if (!$db) {
		die("Error conexión: " . mysqli_connect_error());
	}

/* Se muestra el formulario la primera vez */
if (!isset($_POST) || empty($_POST)) { 

	/*Función que obtiene los departamentos de la empresa*/
    $departamentos = obtenerDepartamentos($db);
    
	
    /* Se inicializa la lista valores*/
	echo '<form action="" method="post">';
?>
	<div>
    Departamento a listar:<select name="departamento">
		<?php foreach($departamentos as $departamento) : ?>
			<option> <?php echo $departamento ?> </option>
		<?php endforeach; ?>
	</select><br><br>
	</div>
	<br>
<?php
	echo '<div><input type="submit" value="Ver Empleados"></div>
	</form>';
} else { 

	$servername = "localhost";
    $username = "root";
    $password = "rootroot";
    $dbname = "empleadosnn";
    $departamento = $_POST['departamento'];

    $conn=conexion($servername, $username, $password, $dbname);

    if (!conexion($servername, $username, $password, $dbname)) {
        die("Conexion Fallida " . mysqli_connect_error());
    } else {
        echo "Conexion Completada con Exito<br><br>";
    }

    $sql = "SELECT cod_dpto FROM departamento WHERE nombre_dpto= '$departamento' ";
	$resultado=mysqli_query($db, $sql);//el resultado no es valido, hay que tratarlo
    $row=mysqli_fetch_assoc($resultado);    
    $codigo=$row['cod_dpto']; //guardamos el codigo del departamento

    $sql = "SELECT emple_depart.cod_dpto, empleado.*
    FROM emple_depart, empleado
    WHERE emple_depart.dni = empleado.dni
    AND emple_depart.cod_dpto !='$codigo' AND emple_depart.fecha_fin IS NOT NULL";
    $resultado = mysqli_query($conn, $sql);
    
    echo "<h2>HISTORIAL DE EMPLEADOS EN EL DEPARTAMENTO</h2>";
    echo "<br><table width=80%>
                <tr><td width=16%><b>DEPARTAMENTO</b></td><td width=16%><b>DNI</b></td>
                <td width=16%><b>NOMBRE</b></td><td width=16%><b>APELLIDOS</b></td>
                <td width=16%><b>FECHA NACIMIENTO</b></td><td width=16%><b>SALARIO</b></td>
                </tr>";
    while($mostrar=mysqli_fetch_array($resultado)){

        
        echo "<tr>
                <td width=16%>" . $mostrar['cod_dpto'] . "</td>
                <td width=16%>" . $mostrar['dni'] . "</td>
                <td width=16%>" . $mostrar['nombre'] . "</td>
                <td width=16%>" . $mostrar['apellidos'] . "</td>
                <td width=16%>" . $mostrar['fecha_nac'] . "</td>
                <td width=16%>" . $mostrar['salario'] . "</td>
            </tr>";
    }
    echo "</table>";
    
}
?>