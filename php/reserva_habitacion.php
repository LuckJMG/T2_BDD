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
                Nombre: <input type="text" name="nombre"><br>
                Apellido: <input type="text" name="apellido"><br>
                RUT: <input type="text" name="RUT"><br>
                Numero Habitacion: <input type="number" name="numero_habitacion"><br>
                fecha_ingreso: <input type="date" name="fecha_de_entrada"><br>
                fecha_salida: <input type="date" name="fecha_de_salida"><br>
                <input type="submit">
            </form>
        </div>
        <?php

        $conn = coneccion();

        if(isset($_POST["nombre"]) && isset($_POST["apellido"]) && isset($_POST["RUT"]) && isset($_POST["numero_habitacion"]) && isset($_POST["fecha_de_entrada"]) && isset($_POST["fecha_de_salida"])){
            $nombre = $_POST["nombre"];
            $apellido = $_POST["apellido"];
            $RUT = $_POST["RUT"];
            $numero_habitacion = $_POST["numero_habitacion"];
            $fecha_ingreso = $_POST["fecha_de_entrada"];
            $fecha_salida = $_POST["fecha_de_salida"];
            $sql1 = "INSERT INTO Cliente (rut, nombre, apellido) VALUES ($RUT, '$nombre', '$apellido')";
            $sql2 = "INSERT INTO ReservaHabitacion (rut_cliente, numero_habitacion, fecha_checkin, fecha_checkout) VALUES ($RUT, $numero_habitacion, '$fecha_ingreso', '$fecha_salida')";
            if ($conn->query($sql1) === TRUE) {
                echo "Cliente Agregado";
            } else {
                echo "Error: " . $sql1 . "<br>" . $conn->error;
            }
            if ($conn->query($sql2) === TRUE) {
                echo "Reserva realizada";
            } else {
                echo "Error: " . $sql2 . "<br>" . $conn->error;
            }
        }
        $conn->close();
        ?>

        <div class="modificacionreservas">
            <div><h1>Modificacion reserva de Habitaciones</h1></div>
            
            <p>Datos reserva:<p>
            <form action="reserva_habitacion.php" method="POST">
                RUT del Cliente: <input type="text" name="rut_cliente1"><br>
                Numero de Habitacion: <input type="number" name="numero_habitacion2"><br>
                Fecha de Ingreso: <input type="date" name="fecha_de_entrada1"><br>
                Fecha de Salida: <input type="date" name="fecha_de_salida1"><br>
                <input type="submit">
            </form>
        </div>
        <?php

        $conn = coneccion();
        
        if(isset($_POST["rut_cliente1"]) && isset($_POST["numero_habitacion2"]) && isset($_POST["fecha_de_entrada1"]) && isset($_POST["fecha_de_salida1"])){
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
			else {
				echo "Cliente no encontrado";
			}
        }
        $conn->close();
        ?>

        <div class="cancelacionreservas">
            <div><h1>Cancelacion de reserva de Habitaciones</h1></div>
            
            <p>Eliminar reserva por habitacion:<p>
            <form action="reserva_habitacion.php" method="POST">
                Numero de Habitacion: <input type="number" name="numero_habitacion1"><br>
                <input type="submit">
            </form>
        </div>

        <?php
        $conn = coneccion();
        if(isset($_POST["numero_habitacion1"])){
            $numero_habitacion = $_POST["numero_habitacion1"];

            $sql_delete_reservas = "DELETE FROM ReservaHabitacion WHERE numero_habitacion = $numero_habitacion";

			if ($conn->query($sql_delete_reservas) === TRUE) {
				// Eliminar cliente después de eliminar las reservas
				echo "Cliente eliminado y reservas canceladas";
			} else {echo "Error al cancelar reservas: " . $conn->error;}
        }
        $conn->close();  
        ?>

        <?php
        $sql = "SELECT * FROM ReservaHabitacion";
        $conn = coneccion();
        // Ejecutar la consulta
        $result = $conn->query($sql);
        
        // Verificar si hay resultados y mostrarlos
        if ($result->num_rows > 0) {
            // Imprimir los datos de cada fila
            while($row = $result->fetch_assoc()) {
                echo "ID: " . $row["id"] . "<br>";
                echo "RUT Cliente: " . $row["rut_cliente"] . "<br>";
                echo "Número de Habitación: " . $row["numero_habitacion"] . "<br>";
                echo "Fecha Check-in: " . $row["fecha_checkin"] . "<br>";
                echo "Fecha Check-out: " . $row["fecha_checkout"] . "<br>";
                echo "Calificación: " . $row["calificacion"] . "<br>";
                echo "<hr>"; // Línea horizontal para separar las entradas
            }}
        $conn->close();  
        ?>
