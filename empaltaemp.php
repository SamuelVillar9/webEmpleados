<head>
        <title>FORMULARIO EMPLEADO MYSQL</title>
</head>
<h1>FORMULARIO INSERTAR EN TABLA EMPLEADO</h1>
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
    DNI: <input type='text' name='dni' value='' size='32'><br><br>
    Nombre: <input type='text' name='nombre_empleado' value='' size='30'><br><br>
    Apellidos: <input type='text' name='apellidos' value='' size='40'><br><br>
    Fecha Nacimiento: <input type='date' name='fecha_nac' value='' size='30'><br><br>
    Salario: <input type='text' name='salario' value='' size='30'><br><br>
    Fecha Inicio: <input type='date' name='fecha_ini' value='' size='30'><br><br>    
	Departamentos<select name="departamento">
		<?php foreach($departamentos as $departamento) : ?>
			<option> <?php echo $departamento ?> </option>
		<?php endforeach; ?>
	</select>
	</div>
	<br>
<?php
    echo "<div><input type='submit' value='Enviar'>
    <input type='reset' value='Borrar'></div>
    </form>";
    
            
} else { 

    // Lo primero obtengo el dpto actual (para contrastar)
    $servername = "localhost";
    $username = "root";
    $password = "rootroot";
    $dbname="empleadosnn";
    $dni=limpiar_campo($_POST['dni']);
    $nombre=limpiar_campo($_POST['nombre_empleado']);
    $apellidos=limpiar_campo($_POST['apellidos']);
    $fecha_nac=limpiar_campo($_POST['fecha_nac']);
    $salario=limpiar_campo($_POST['salario']);
    $fecha_ini=limpiar_campo($_POST['fecha_ini']);
    
    
    $conn=conexion($servername, $username, $password, $dbname);

    if (!conexion($servername, $username, $password, $dbname)) {
        die("Conexion Fallida " . mysqli_connect_error());
    } else {
        echo "Conexion Completada con Exito<br>";
    }

    $sql = "INSERT INTO empleado (dni, nombre, apellidos, fecha_nac, salario) VALUES ('$dni', '$nombre', '$apellidos', '$fecha_nac', '$salario')";
    
    $departamento=$_POST['departamento'];
	$sql1 = "SELECT cod_dpto FROM departamento WHERE nombre_dpto= '$departamento' ";
	$resultado=mysqli_query($db, $sql1);//el resultado no es valido, hay que tratarlo
    $row=mysqli_fetch_assoc($resultado);    
    $codigo=$row['cod_dpto'];
	$sql1 = "INSERT INTO emple_depart (dni, cod_dpto, fecha_ini) VALUES ('$dni', '$codigo', '$fecha_ini')";

    // COMPROBAR CONEXION
    if (mysqli_query($conn, $sql)) {
        echo "Datos introducidos correctamente en tabla empleado<br>";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    if (mysqli_query($conn, $sql1)) {
        echo "Datos introducidos correctamente en tabla emple_depart<br>";
    } else {
        echo "Error: " . $sql1 . "<br>" . mysqli_error($conn);
    }

    //CERRAMOS CONEXION CON LA BASE DE DATOS
    mysqli_close($conn);

        
    }
?>