<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<title>Reportes</title>
</head>
<body>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
	<?php include 'include/navbar.php'; ?>
	<h1>Reportes</h1>

<?php
require 'funciones.php';

$conn = coneccion();

for ($i = 1; $i <= 100; $i++) {
	$result = $conn->query("SELECT * FROM CalificacionHabitacion WHERE numero=$i AND calificacion IS NOT NULL;");
	$tours = $conn->query("SELECT * FROM Tour");

	if ($result->num_rows > 0) {
		echo "<h2>Habitación $i</h2>";

		echo "<h3>Recaudación Tours</h3>";
		echo "<ul>";
		while ($row = $tours->fetch_assoc()) {
			$id = $row["id"];
			$lugar = $row["lugar"];
			$recaudacion = "SELECT RecaudacionHabitacionTour($i, $id)";
			$recaudacion = $conn->query($recaudacion)->fetch_assoc()["RecaudacionHabitacionTour($i, $id)"];

			echo "
			<li>Tour $id - $lugar, recaudó: $recaudacion</li>
			";
		}
		echo "</ul>";

		echo "<h3>Calificaciones:</h3>";
		echo "<ul>";
		while ($row = $result->fetch_assoc()) {
			$tipo = $row["tipo"];
			$checkout = $row["fecha_checkout"];
			$calificacion = $row["calificacion"];

			echo "
			<li>Habitación $tipo, check-out: $checkout, calificacion: $calificacion</li>
			";
		}
		echo "</ul>";
	}
}

$conn->close();
?>
</body>
</html>
