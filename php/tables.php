<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Tarea2";

// Create connection
$conn = new mysqli($servername, $username, $password);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "DROP DATABASE Tarea2";
if ($conn->query($sql) === TRUE) {
  echo "<p>Base de Datos borrada</p>";
} else {
  echo "Error al dropear las tablas: " . $conn->error;
}

$sql = "CREATE DATABASE Tarea2";
if ($conn->query($sql) === TRUE) {
  echo "<p>Bases de Datos creada</p>";
} else {
  echo "Error al dropear las tablas: " . $conn->error;
}

$conn->close();

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

function createTable($conn, $table, $name) {
	if ($conn->query($table) === TRUE) {
	  echo "<p>Table $name created successfully</p>";
	} else {
	  echo "Error creating table: " . $conn->error;
	}
}

// sql to create table
$tabla_clientes = "
CREATE TABLE Cliente (
	rut INT UNSIGNED PRIMARY KEY,
	nombre VARCHAR(30) NOT NULL,
	apellido VARCHAR(30) NOT NULL
)
";
createTable($conn, $tabla_clientes, "Cliente");

$tabla_habitaciones = "
CREATE TABLE Habitacion (
	numero INT UNSIGNED PRIMARY KEY,
	tipo VARCHAR(30) NOT NULL
)
";
createTable($conn, $tabla_habitaciones, "Habitacion");

for ($numero = 1; $numero <= 100; $numero++) {
	$tipo = array("Single", "Double", "King")[$numero % 3];
	$query = "
	INSERT INTO Habitacion (numero, tipo)
	VALUES ($numero, '$tipo')
	";
	$conn->query($query);
}

$tabla_tours = "
CREATE TABLE Tour (
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	fecha DATE,
	lugar VARCHAR(100),
	transporte VARCHAR(30),
	valor INT UNSIGNED
)
";
createTable($conn, $tabla_tours, "Tour");
function addTour($conn, $id, $fecha, $lugar, $transporte, $valor) {
	$query = "
	INSERT INTO Habitacion (id, fecha, lugar, transporte, valor)
	VALUES ($id, '$fecha', '$lugar', '$transporte', $valor)
	";
	$conn->query($query);
}
addTour($conn, 1, '2024-06-01', 'Llanquihue', 'Bus', 20000);
addTour($conn, 2, '2024-07-02', 'Frutillar', 'Canoa', 10);
addTour($conn, 3, '2024-08-03', 'Puerto Varas', 'Nave Espacial', 999999);
addTour($conn, 4, '1990-01-20', 'Puerto Montt', 'Carreta a Caballo', 200);
addTour($conn, 5, '3000-12-24', 'Antartica', 'Trineo', 800000);

$tabla_reservas_habitaciones = "
CREATE TABLE ReservaHabitacion (
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	rut_cliente INT UNSIGNED NOT NULL,
	numero_habitacion INT UNSIGNED NOT NULL,
	FOREIGN KEY (rut_cliente) REFERENCES Cliente(rut),
	FOREIGN KEY (numero_habitacion) REFERENCES Habitacion(numero),
	fecha_checkin DATE NOT NULL,
	fecha_checkout DATE NOT NULL,
	calificacion TINYINT
)
";
createTable($conn, $tabla_reservas_habitaciones, "ReservaHabitacion");

$tabla_reservas_tours = "
CREATE TABLE ReservaTour (
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	id_reserva_habitacion INT UNSIGNED,
	id_tour INT UNSIGNED NOT NULL,
	FOREIGN KEY (id_reserva_habitacion) REFERENCES ReservaHabitacion(id),
	FOREIGN KEY (id_tour) REFERENCES Tour(id)
)
";
createTable($conn, $tabla_reservas_tours, "ReservaTour");

$conn->close();
?>
