<!DOCTYPE html>
<html>
    <head>
        <title>Reserva de Habitaciones</title>
    </head>
    <body>
		<a href='/'>Home</a>
        
        <div class="busqueda">
            <div><h1>Disponibilidad</h1></div>
            <form action = "reserva_habitacion.php" method="POST">
                Busqueda: <input type="number" name="Busqueda"><br>
                <input type="submit">
            </form>
        </div>

        <?php
        require 'funciones.php';

        $conn = coneccion();

        if(isset($_POST["Busqueda"])){
            $busqueda = $_POST["Busqueda"];
            $sql = "SELECT * FROM ReservaHabitacion WHERE numero_habitacion = $busqueda";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                echo "No Disponible";
            } 
            else {
                echo "Disponible";
            }
        }
        $conn->close();
        ?>

        <div class="reservahabitaciones">
            <div><h1>Reserva de Habitaciones</h1></div>
            
            <p>Datos del Cliente:<p>
            <form action="reserva_habitacion.php" method="POST">
                Nombre: <input type="text" name="nombre" required><br>
                Apellido: <input type="text" name="apellido" required><br>
                RUT: <input type="number" name="RUT" required><br>
                Numero Habitacion: <input type="number" name="numero_habitacion" required><br>
                fecha_ingreso: <input type="date" name="fecha_de_entrada" required><br>
                fecha_salida: <input type="date" name="fecha_de_salida" required><br>
                <input type="submit">
            </form>
        </div>

<?php

$conn = coneccion();

if(isset($_POST["RUT"])){
	// Obtener datos del form
	$nombre = $_POST["nombre"];
	$apellido = $_POST["apellido"];
	$RUT = $_POST["RUT"];
	$numero_habitacion = $_POST["numero_habitacion"];
	$fecha_ingreso = $_POST["fecha_de_entrada"];
	$fecha_salida = $_POST["fecha_de_salida"];

	// Query chequeo de disponibilidad
	$query = "
	SELECT * FROM ReservaHabitacion
	WHERE numero_habitacion = $numero_habitacion
	AND ((fecha_checkin BETWEEN '$fecha_ingreso' AND '$fecha_salida')
	OR (fecha_checkout BETWEEN '$fecha_ingreso' AND '$fecha_salida'))
	";

	if ($conn->query($query)->num_rows == 0) {
		// Registrar cliente si no está registrado
		if (!checkDisponibilidad($conn, 'Cliente', 'rut', $RUT)) {
			$sql1 = "
			INSERT INTO Cliente (rut, nombre, apellido)
			VALUES ($RUT, '$nombre', '$apellido');
			";

			if ($conn->query($sql1) === TRUE) 
				echo "<p>Cliente $nombre $apellido $RUT agregado.</p>";
			else echo "Error: " . $sql1 . "<br>" . $conn->error;
		}

		// Hacer la reserva de habitacion en las fechas indicadas
		$sql2 = "
		INSERT INTO ReservaHabitacion (rut_cliente, numero_habitacion, fecha_checkin, fecha_checkout)
		VALUES ($RUT, $numero_habitacion, '$fecha_ingreso', '$fecha_salida');
		";

		if ($conn->query($sql2) === TRUE)
			echo "<p>Habitación $numero_habitacion reservada desde $fecha_ingreso a $fecha_salida.</p>";
		else echo "Error: " . $sql2 . "<br>" . $conn->error;
	}
	else {
		echo "<p>La habitación $numero_habitacion ya ha sido reservada entre $fecha_ingreso y $fecha_salida.</p>";
	}
}

$conn->close();
?>

<?php

$conn = coneccion();

if(isset($_POST["rut_cliente1"])) {
	$rut_cliente = $_POST["rut_cliente1"];
	$numero_habitacion = $_POST["numero_habitacion2"];
	$fecha_ingreso = $_POST["fecha_de_entrada1"];
	$fecha_salida = $_POST["fecha_de_salida1"];

	$sql1 = "SELECT * FROM ReservaHabitacion WHERE rut_cliente = $rut_cliente";
	$result = $conn->query($sql1);

	if ($result->num_rows > 0) {
		// output data of each row
		$row = $result->fetch_assoc();
		$sql = "UPDATE ReservaHabitacion SET numero_habitacion = $numero_habitacion, fecha_checkin = '$fecha_ingreso', fecha_checkout = '$fecha_salida' WHERE rut_cliente = $rut_cliente";
		if ($conn->query($sql) === TRUE) {
		echo "Reserva modificada";
		} else {echo "Error: " . $sql . "<br>" . $conn->error;}
	}
	else echo "<p>Cliente $RUT no encontrado.</p>";
}

$conn->close();
?>

<?php
$conn = coneccion();

if(isset($_POST["eliminar"])) {
	$id = intval($_POST["eliminar"]);

	// Eliminar reserva por ID
	$query = "
	DELETE FROM ReservaHabitacion
	WHERE id = $id;
	";

	if ($conn->query($query) === TRUE)
		echo "<p>Reserva $id eliminada.</p>";
	else 
		echo "Error al cancelar reservas: " . $conn->error;
}

$conn->close();  
?>

			<hr>

<script>
function mostrarModificar(id) {
	let form = document.getElementById("modificar" + id);

	if (form.style.display === 'none') form.style.display = 'block';
	else form.style.display = 'none';
}
</script>

<?php
$conn = coneccion();

// Ejecutar la consulta
$sql = "SELECT * FROM ReservaHabitacion";
$result = $conn->query($sql);

// Verificar si hay resultados y mostrarlos
if ($result->num_rows > 0) {
	// Imprimir los datos de cada fila
	echo "<ul>";
	while($row = $result->fetch_assoc()) {
		$id = $row["id"];
		$numero = $row["numero_habitacion"];
		$checkin = $row["fecha_checkin"];
		$checkout = $row["fecha_checkout"];

		echo "
		<li>
		<p>Reserva $id: Habitación $numero, $checkin - $checkout</p>
		<button onclick=mostrarModificar($id)>Modificar</button>
		<form action='reserva_habitacion.php' method='POST'>
			<button name='eliminar' value='$id' type='submit'>Eliminar</button>
		</form>
		<form action='reserva_habitacion.php' method='POST' id='modificar$id' style='display: none'>
			<p>Habitación: <input type=number name='numero_habitacion$id'/></p>
			<p>Fecha checkin: <input type=date name='checkin$id'/></p>
			<p>Fecha checkout: <input type=date name='checkout$id'/></p>
		</form>
		</li>
		";
	}
	echo "</ul>";
}

$conn->close();  
?>
