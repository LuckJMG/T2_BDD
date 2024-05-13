<html>
<head>
	<title>Reserva de Tours</title>
</head>
<body>
	<a href="/">Home</a>

	<h1>Tours</h1>
	<h2>Reservar Tour</h2>
	<form action="reserva_tours.php" method="post">
		Habitación: <input type="number" name="habitacion" required><br>
		ID Tour: <input type="number" name="id_tour" required><br>
		<input type="submit">
	</form>

<?php
function checkDisponibilidad($conn, $table, $column, $id) {
	$query = "
	SELECT $column FROM $table
	WHERE $column=$id;
	";

	$result = $conn->query($query);
	
	if ($result->num_rows == 0) {
		echo "<p>$column $id no se encuentra en $table</p>";
		return False;
	}

	return True;
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Tarea2";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if ($_POST["habitacion"] != ""
	&& checkDisponibilidad($conn, "ReservaHabitacion", "numero_habitacion", $_POST["habitacion"])
	&& checkDisponibilidad($conn, "Tour", "id", $_POST["id_tour"])) {
	$numero = $_POST["habitacion"];
	$query = "
	SELECT * FROM ReservaTour
	INNER JOIN ReservaHabitacion
	ON ReservaTour.id_reserva_habitacion=ReservaHabitacion.id
	WHERE ReservaHabitacion.numero_habitacion=$numero
	";
	
	if ($conn->query($query)->num_rows == 0) {
		$query = "
		SELECT id FROM ReservaHabitacion
		WHERE numero_habitacion=$numero;
		";

		$id_reserva_habitacion = $conn->query($query)->fetch_assoc()["id"];
		$id_tour = $_POST["id_tour"];

		$query = "
		INSERT INTO ReservaTour (id_reserva_habitacion, id_tour)
		VALUES ($id_reserva_habitacion, $id_tour);
		";

		if ($conn->query($query)) {
			echo "Reserva Completada!";
		}
		else {
			echo "Ha ocurrido un error, contactar a servicio técnico.";
		}
	}
}

$conn->close();
?>

	<h2>Tours Disponibles</h2>
<?php 
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Tarea2";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if ($_POST["delete"] != "") {
	$container =  explode("-", $_POST["delete"]);
	$id = intval($container[0]);
	$numero = intval($container[1]);

	$query = "
	DELETE FROM ReservaTour
	WHERE id_tour=$id AND id_reserva_habitacion=(
		SELECT id FROM ReservaHabitacion
		WHERE numero_habitacion=$numero
	);
	";

	$conn->query($query);
}

$conn->close();
?>

<?php 
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Tarea2";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

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
			SELECT * FROM Habitacion
			WHERE numero=(
				SELECT numero_habitacion FROM ReservaHabitacion
				WHERE id=(
					SELECT id_reserva_habitacion FROM ReservaTour
					WHERE id_tour=(
						SELECT id FROM Tour
						WHERE id=$id
					)
				)
			);
		";

		$reservas = $conn->query($query);

		if ($reservas->num_rows == 0) { continue; }

		echo "<p><b>Reservas:</b><ul>";
		while ($reserva = $reservas->fetch_assoc()) {
			$num = $reserva["numero"];
			echo "<li>Habitación " . $num . "<form action='reserva_tours.php' method='POST'><button name='delete' value='$id-$num' type='submit'>Eliminar</button></form></li>";
		}
		echo "</ul>";
	}
}

$conn->close();
?>

</body>
</html>
