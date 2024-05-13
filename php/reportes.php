<html>
<head>
	<title>Reportes</title>
</head>
<body>
	<a href="/">Home</a>
	<h1>Reportes</h1>

<?php
require 'funciones.php';

$conn = coneccion();

for ($i = 1; $i <= 100; $i++) {
	$result = $conn->query("SELECT * FROM CalificacionHabitacion WHERE numero=$i;");
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
