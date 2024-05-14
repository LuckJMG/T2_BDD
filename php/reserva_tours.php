<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<title>Reserva de Tours</title>
</head>
<body>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
	<?php include 'include/navbar.php'; ?>

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
	$id_tour = $_POST["id_tour"];

	$query = "
	INSERT INTO ReservaTour (id_reserva_habitacion, id_tour)
	VALUES ($id_reserva, $id_tour);
	";

	if ($conn->query($query)) echo "Reserva Completada!";
	else echo "Ha ocurrido un error, contactar a servicio técnico.";
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
		echo "<img src='/images/" . $row["lugar"] . ".jpg' height='200px'>";
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
