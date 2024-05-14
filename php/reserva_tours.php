<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<link rel="stylesheet" href="../css/styles.css">
	<title>Reserva de Tours</title>
</head>
<body>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
	<?php include 'include/navbar.php'; ?>

	<div class="cuadrado">
		<div class="card">
			<h3 class="card-header">Reserva de Tours</h3>
			<div class="card-body">
				<form action="reserva_tours.php" method="post">
					<div class="mb-3">
						<label for="id_reserva" class="form-label">ID Reserva de Habitacion</label>
						<input type="number" class="form-control" id="id_reserva" name="id_reserva" required>
					</div>
					<div class="mb-3">
						<label for="id_tour" class="form-label">ID Tour</label>
						<input type="number" class="form-control" id="id_tour" name="id_tour" required>
					</div>
					<button type="submit" class="btn btn-primary">Reservar</button>
				</form>
			</div>
		</div>
	</div>
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
	<figure class="text-center">
  <blockquote class="blockquote">
    <h2>Tours Disponibles</h2>
  </blockquote>
  <figcaption class="blockquote-footer">
    La diversion <cite title="Source Title">total</cite>
  </figcaption>
</figure>
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

		echo "	<div class='cuadrado2'>
				<div class='card'>
				<h3 class='card-header'>" . $row["id"] . " - " . $row["lugar"] . "</h3>
				<img src='/images/" . $row["lugar"] . ".jpg' class='imagen-tour'>
				<p><b>Fecha: </b>" . $row["fecha"] . "</p>
				<p><b>Transporte: </b>" . $row["transporte"] . "</p>
				<p><b>Valor: </b>" . $row["valor"] . "</p>";
		
		$id = $row["id"];
		$query = "
		SELECT * FROM ReservaHabitacion
		WHERE id IN (
			SELECT id_reserva_habitacion FROM ReservaTour
			WHERE id_tour=$id
		);
		";

		$reservas = $conn->query($query);
		if ($reservas->num_rows == 0) { echo "</div>
			</div>"; continue; }

		echo "<p><b>Reservas:</b></p>
			<div class='cuadrado3'> 
			<ol class='list-group list-group-numbered'>";
		while ($reserva = $reservas->fetch_assoc()) {
			$id_reserva = $reserva["id"];
			$numero = $reserva["numero_habitacion"];
			echo "
					<li class='list-group-item d-flex justify-content-between align-items-start'>
						<div class='ms-2 me-auto'>
							<div class='fw-bold'>Reserva $id_reserva</div>
							Habitación $numero
						</div>
						<form action='reserva_tours.php' method='POST'>
							<button class='btn btn-primary' name='delete' value='$id-$id_reserva' type='submit'>Eliminar</button>
						</form>
					</li>";
		}
		echo "</ol>
			</div>";
		echo "</div>
			</div>";
	}
}

$conn->close();
?>

</body>
</html>
