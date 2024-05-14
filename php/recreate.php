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
function createTour($conn, $lugar, $fecha, $transporte, $valor) {
	$query = "
	INSERT INTO Tour (lugar, fecha, transporte, valor)
	VALUES ('$lugar', '$fecha', '$transporte', $valor);
	";

	$conn->query($query);
}

createTour($conn, "Puerto Montt", "1990-08-13", "Caballo", 2);
createTour($conn, "Puerto Varas", "3000-01-18", "Nave Espacial", 200000);
createTour($conn, "Frutillar", "2024-02-20", "Frutimovil", 10000);
createTour($conn, "Hornopiren", "2025-10-30", "Canoa", 40000);
createTour($conn, "Antartica", "2030-12-24", "Trineo", 696969);

$tabla_reservas_habitaciones = "
CREATE TABLE ReservaHabitacion (
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	rut_cliente INT UNSIGNED NOT NULL,
	numero_habitacion INT UNSIGNED NOT NULL,
	FOREIGN KEY (rut_cliente) REFERENCES Cliente(rut) ON DELETE CASCADE,
	FOREIGN KEY (numero_habitacion) REFERENCES Habitacion(numero),
	fecha_checkin DATE NOT NULL,
	fecha_checkout DATE NOT NULL,
	calificacion TINYINT,
	valor_total INT
)
";
createTable($conn, $tabla_reservas_habitaciones, "ReservaHabitacion");

$tabla_reservas_tours = "
CREATE TABLE ReservaTour (
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	id_reserva_habitacion INT UNSIGNED NOT NULL,
	id_tour INT UNSIGNED NOT NULL,
	FOREIGN KEY (id_reserva_habitacion) REFERENCES ReservaHabitacion(id),
	FOREIGN KEY (id_tour) REFERENCES Tour(id)
)
";
createTable($conn, $tabla_reservas_tours, "ReservaTour");

$tabla_calificaciones = "
CREATE TABLE Calificacion (
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	numero_habitacion INT UNSIGNED NOT NULL,
	FOREIGN KEY (numero_habitacion) REFERENCES Habitacion(numero),
	fecha_checkout DATE NOT NULL,
	calificacion TINYINT NOT NULL
)
";
createTable($conn, $tabla_calificaciones, "Calificacion");

$view_calificaciones = "
CREATE VIEW CalificacionHabitacion AS
SELECT Habitacion.numero, Habitacion.tipo, Calificacion.fecha_checkout, Calificacion.calificacion
FROM Calificacion
INNER JOIN Habitacion
ON Calificacion.numero_habitacion=Habitacion.numero
ORDER BY Habitacion.numero ASC;
";
createTable($conn, $view_calificaciones, "View Calificaciones");

$function_tour = "
CREATE FUNCTION RecaudacionHabitacionTour (p_habitacion INT, p_id_tour INT)
RETURNS INT
DETERMINISTIC
BEGIN
	DECLARE valor_tour INT;
    DECLARE cantidad_inscripciones INT;
    
    SELECT valor INTO valor_tour 
    FROM Tour
    WHERE id = p_id_tour;
    
    SELECT COUNT(*) INTO cantidad_inscripciones
    FROM ReservaTour
	INNER JOIN ReservaHabitacion
	ON ReservaTour.id_reserva_habitacion = ReservaHabitacion.id
    WHERE id_tour = p_id_tour
    AND numero_habitacion = p_habitacion;

	RETURN valor_tour * cantidad_inscripciones;
END
";
createTable($conn, $function_tour, "Function Recaudacion");

$procedure_checkout = "
CREATE PROCEDURE calcular_valor (IN id_reserva INT)
BEGIN
	DECLARE habitacion INT;
	DECLARE tipo_habitacion VARCHAR(30) DEFAULT 'Single';
	DECLARE valor_habitacion INT DEFAULT 10000;
	DECLARE cantidad_dias INT DEFAULT 0;
	DECLARE total_tours INT DEFAULT 0;
	DECLARE total INT DEFAULT 0;

	SELECT numero_habitacion INTO habitacion
	FROM ReservaHabitacion
	INNER JOIN Habitacion
	ON ReservaHabitacion.numero_habitacion = Habitacion.numero
	WHERE ReservaHabitacion.id = id_reserva;

	SELECT tipo INTO tipo_habitacion
	FROM Habitacion
	WHERE numero=habitacion;

	IF tipo_habitacion = 'King' THEN
		SET valor_habitacion = 40000;
	ELSEIF tipo_habitacion = 'Double' THEN
		SET valor_habitacion = 20000;
	ELSE
		SET valor_habitacion = 10000;
	END IF;

	SELECT DATEDIFF(fecha_checkout, fecha_checkin) INTO cantidad_dias
	FROM ReservaHabitacion
	WHERE id=id_reserva;

	IF cantidad_dias < 0 THEN
		SET cantidad_dias = 0;
	END IF;

	SELECT SUM(valor) INTO total_tours
	FROM ReservaTour
	INNER JOIN Tour
	ON ReservaTour.id_tour=Tour.id
	WHERE id_reserva_habitacion=id_reserva;

	IF total_tours IS NULL THEN
		SET total_tours = 0;
	END IF;
	
	SET total = valor_habitacion + cantidad_dias * 1000 + total_tours;

	UPDATE ReservaHabitacion
	SET valor_total = total
	WHERE id = id_reserva;
END;
";
createTable($conn, $procedure_checkout, "Checkout Procedure");

$trigger_delete_reserva = "
CREATE TRIGGER delete_reserva
BEFORE DELETE
ON ReservaHabitacion FOR EACH ROW
BEGIN
	INSERT INTO Calificacion (numero_habitacion, fecha_checkout, calificacion)
	VALUES (OLD.numero_habitacion, OLD.fecha_checkout, OLD.calificacion);
END
";
createTable($conn, $trigger_delete_reserva, "Trigger");

$conn->close();
?>
