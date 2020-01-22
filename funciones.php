<?php

function conexion($servername, $username, $password, $dbname){

    //CREAR CONEXION
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    return $conn;

}

function limpiar_campo($campoformulario) {
    $campoformulario = trim($campoformulario); //elimina espacios en blanco por izquierda/derecha
    $campoformulario = stripslashes($campoformulario); //elimina la barra de escape "\", utilizada para escapar caracteres
    $campoformulario = htmlspecialchars($campoformulario);  
  
    return $campoformulario;  
}

// Obtengo todos los departamentos para mostrarlos en la lista de valores
function obtenerDepartamentos($db) {
	$departamentos = array();
	
	$sql = "SELECT cod_dpto,nombre_dpto FROM departamento";
	
	$resultado = mysqli_query($db, $sql);
	if ($resultado) {
		while ($row = mysqli_fetch_assoc($resultado)) {
			$departamentos[] = $row['nombre_dpto'];
		}
	}
	return $departamentos;
}

//Obtengo todos los dni para mostrarlos en la lista de valores
function obtenerDni($db) {
	$dni = array();
	
	$sql = "SELECT dni FROM empleado";
	
	$resultado = mysqli_query($db, $sql);
	if ($resultado) {
		while ($row = mysqli_fetch_assoc($resultado)) {
			$dni[] = $row['dni'];
		}
	}
	return $dni;
}

//Obtengo todos los dni para mostrarlos en la lista de valores
function obtenerEmpleados($db) {
	$empleados = array();
	
	$sql = "SELECT nombre FROM empleado";
	
	$resultado = mysqli_query($db, $sql);
	if ($resultado) {
		while ($row = mysqli_fetch_assoc($resultado)) {
			$empleados[] = $row['nombre'];
		}
	}
	return $empleados;
}

?>