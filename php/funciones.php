<?php
function coneccion(){
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

    return $conn;
}

function checkDisponibilidad($conn, $table, $column, $id) {
	$query = "
	SELECT $column FROM $table
	WHERE $column=$id;
	";

	$result = $conn->query($query);
	
	if ($result->num_rows == 0) return False;

	return True;
}
?>
