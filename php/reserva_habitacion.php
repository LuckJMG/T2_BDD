<!DOCTYPE html>
<html>
    <head>
        <title>Reserva de Habitaciones</title>
    </head>
    <body>
        
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
        else {
            echo "Error: Datos incompletos";
        }
        $conn->close();
        ?>

        <div class="modificacionreservas">
            <div><h1>Modificacion reserva de Habitaciones</h1></div>
            
            <p>Datos reserva:<p>
            <form action="reserva_habitacion.php" method="POST">
                Numero de Habitacion: <input type="number" name="nombre"><br>
                fecha_ingreso: <input type="date" name="fecha de entrada"><br>
                fecha_salida: <input type="date" name="fecha de salida"><br>
                <input type="submit">
            </form>
        </div>
        <?php

        $conn = coneccion();
        
        if(isset($_POST["numero_habitacion"]) && isset($_POST["fecha_de_entrada"]) && isset($_POST["fecha_de_salida"])){
            $numero_habitacion = $_POST["numero_habitacion"];
            $fecha_ingreso = $_POST["fecha_de_entrada"];
            $fecha_salida = $_POST["fecha_de_salida"];
            $sql = "UPDATE ReservaHabitacion SET fecha_checkin = '$fecha_ingreso', fecha_checkout = '$fecha_salida' WHERE numero_habitacion = $numero_habitacion";
            if ($conn->query($sql) === TRUE) {
                echo "Reserva modificada";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
        else {
            echo "Error: Datos incompletos";
        }
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
            
            // Obtener el rut del cliente
            $sql_rut = "SELECT rut_cliente FROM ReservaHabitacion WHERE numero_habitacion = $numero_habitacion";
            $result_rut = $conn->query($sql_rut);
        
            if ($result_rut->num_rows > 0) {
                // Obtener el valor del rut del cliente
                $row_rut = $result_rut->fetch_assoc();
                $rut_cliente = $row_rut["rut_cliente"];
        
                // Eliminar reservas asociadas al cliente
                $sql_delete_reservas = "DELETE FROM ReservaHabitacion WHERE numero_habitacion = $numero_habitacion";
                if ($conn->query($sql_delete_reservas) === TRUE) {
                    // Eliminar cliente después de eliminar las reservas
                    $sql_delete_cliente = "DELETE FROM Cliente WHERE rut = $rut_cliente";
                    if ($conn->query($sql_delete_cliente) === TRUE) {
                        echo "Cliente eliminado y reservas canceladas";
                    } else {echo "Error al eliminar cliente: " . $conn->error;}
                } else {echo "Error al cancelar reservas: " . $conn->error;}
            }
        }
        $conn->close();  
        ?>