<html>
<head>
	<title>Reserva de Tours</title>
</head>
<body>
	<a href="/">Home</a>

	<h1>Tours</h1>
	<h2>Reservar Tour</h2>
	<form action="reserva_tours.php" method="post">
		ID Reserva: <input type="number" name="id_reserva" required><br>
		ID Tour: <input type="number" name="id_tour" required><br>
		<input type="submit">
	</form>

<?php
require 'funciones.php';

$conn = coneccion();

if (isset($_POST["id_reserva"])
	&& checkDisponibilidad($conn, "ReservaHabitacion", "id", $_POST["id_reserva"])
	&& checkDisponibilidad($conn, "Tour", "id", $_POST["id_tour"])) {
	$id_reserva = $_POST["id_reserva"];
	$query = "
	SELECT * FROM ReservaTour
	INNER JOIN ReservaHabitacion
	ON ReservaTour.id_reserva_habitacion=ReservaHabitacion.id
	WHERE ReservaHabitacion.id=$id_reserva;
	";
	
	if ($conn->query($query)->num_rows == 0) {
		$id_tour = $_POST["id_tour"];

		$query = "
		INSERT INTO ReservaTour (id_reserva_habitacion, id_tour)
		VALUES ($id_reserva, $id_tour);
		";

		echo $query;
		if ($conn->query($query)) echo "Reserva Completada!";
		else echo "Ha ocurrido un error, contactar a servicio técnico.";
	}
}

$conn->close();
?>

	<h2>Tours Disponibles</h2>
<?php 
$conn = coneccion();

if ($_POST["delete"] != "") {
	$container =  explode("-", $_POST["delete"]);
	$id_tour = intval($container[0]);
	$id_reserva = intval($container[1]);

	$query = "
	DELETE FROM ReservaTour
	WHERE id_tour=$id_tour AND id_reserva_habitacion=$id_reserva;
	";

	$conn->query($query);
}

$conn->close();
?>

<?php 
$conn = coneccion();

$result = $conn->query("SELECT * FROM Tour;");
if ($result->num_rows > 0) {
	while ($row = $result->fetch_assoc()) {
		echo "<h3>" . $row["id"] . " - " . $row["lugar"] . "</h3>";
		echo "<img src='/images/" . $row["lugar"] . ".jpg'>";
		echo "<p><b>Fecha: </b>" . $row["fecha"] . "</p>";
		echo "<p><b>Transporte: </b>" . $row["transporte"] . "</p>";
		echo "<p><b>Valor: </b>" . $row["valor"] . "</p>";
		
		$id = $row["id"];
		$query = "
		SELECT * FROM ReservaHabitacion
		WHERE id IN (
			SELECT id_reserva_habitacion FROM ReservaTour
			WHERE id_tour=$id
		);
		";

		$reservas = $conn->query($query);
		if ($reservas->num_rows == 0) { continue; }

		echo "<p><b>Reservas:</b><ul>";
		while ($reserva = $reservas->fetch_assoc()) {
			$id_reserva = $reserva["id"];
			$numero = $reserva["numero_habitacion"];
			echo "
			<li>Reserva $id_reserva, Habitación $numero. 
				<form action='reserva_tours.php' method='POST'>
					<button name='delete' value='$id-$id_reserva' type='submit'>Eliminar</button>
				</form>
			</li>";
		}
		echo "</ul>";
	}
}

$conn->close();
?>

</body>
</html>
