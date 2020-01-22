<head>
    <title>CAMBIAR SALARIO</title>
</head>
<h1>CAMBIAR SALARIO A UN EMPLEADO</h1>
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
    $empleados = obtenerEmpleados($db);
    
	
    /* Se inicializa la lista valores*/
	echo '<form action="" method="post">';
?>
	<div>
    Empleados:<select name="empleados">
		<?php foreach($empleados as $empleado) : ?>
			<option> <?php echo $empleado ?> </option>
		<?php endforeach; ?>
	</select><br><br>
    <select name="operacion">
        <option value="aumentar">AUMENTAR SALARIO</option>
        <option value="reducir">REDUCIR SALARIO</option>
    </select><br><br>
    Cantidad: <input type="text" name="cantidad">
	</div>
	<br>
<?php
	echo '<div><input type="submit" value="Cambiar Salario"></div>
	</form>';
} else { 

	$servername = "localhost";
    $username = "root";
    $password = "rootroot";
    $dbname = "empleadosnn";
    $empleado = $_POST['empleados'];
    $salario = limpiar_campo($_POST['operacion']);
    $nuevoSalario = limpiar_campo($_POST['cantidad']);

    $conn=conexion($servername, $username, $password, $dbname);

    if (!conexion($servername, $username, $password, $dbname)) {
        die("Conexion Fallida " . mysqli_connect_error());
    } else {
        echo "Conexion Completada con Exito<br><br>";
    }

    $sql = "SELECT nombre, salario FROM empleado WHERE nombre= '$empleado' ";
	$resultado=mysqli_query($db, $sql);//el resultado no es valido, hay que tratarlo
    $row=mysqli_fetch_assoc($resultado);    
    $nombre=$row['nombre']; //guardamos el nombre del empleado
    $salarioAntiguo=$row['salario']; //guardamos el salario del empleado

    if($salario == "aumentar"){
        $nuevoSalario = $salarioAntiguo + $nuevoSalario;
        $sql = "UPDATE empleado SET salario='$nuevoSalario' WHERE nombre='$nombre'";
	}else if($salario == "reducir"){
        $nuevoSalario = $salarioAntiguo - $nuevoSalario;
        $sql = "UPDATE empleado SET salario='$nuevoSalario' WHERE nombre='$nombre'";
    }
    
    

    // COMPROBAR CONEXION
    if (mysqli_query($conn, $sql)) {
        echo "Salario actualizado correctamente<br>";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
?>