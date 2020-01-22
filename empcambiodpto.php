<head>
    <title>CAMBIAR DEPARTAMENTO A EMPLEADO</title>
</head>
<h1>FORMULARIO CAMBIAR DEPARTAMENTO A EMPLEADO</h1>
<?php


    require "funciones.php";
    date_default_timezone_set('Europe/Madrid');

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
    $dnis = obtenerDni($db);
    $departamentos = obtenerDepartamentos($db);
    
	
    /* Se inicializa la lista valores*/
	echo '<form action="" method="post">';
?>
	<div>
	DNI:<select name="dni">
		<?php foreach($dnis as $dni) : ?>
			<option> <?php echo $dni ?> </option>
		<?php endforeach; ?>
    </select><br><br>
    Cambiar a Departamento:<select name="departamento">
		<?php foreach($departamentos as $departamento) : ?>
			<option> <?php echo $departamento ?> </option>
		<?php endforeach; ?>
	</select><br><br>
    Seleccionar fecha de cambio: <input type="date" name="fecha">
	</div>
	<br>
<?php
	echo '<div><input type="submit" value="Cambiar Departamento"></div>
	</form>';
} else { 

	$servername = "localhost";
    $username = "root";
    $password = "rootroot";
    $dbname = "empleadosnn";
    $departamento = $_POST['departamento'];
    $dni = $_POST['dni'];
    $hoy = $_POST['fecha'];

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

    $sql = "UPDATE emple_depart SET cod_dpto='$codigo', fecha_fin='$hoy' WHERE dni='$dni'";
    
    // COMPROBAR CONEXION
    if (mysqli_query($conn, $sql)) {
        echo "Datos actualizados correctamente en tabla emple_depart<br>";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
	
}

?>