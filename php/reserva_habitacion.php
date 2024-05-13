<!DOCTYPE html>
<html>
    <head>
        <title>Reserva de Habitaciones</title>
    </head>
    <body>

        <div><h1>Disponibilidad</h1></div>

        <div class="reservahabitaciones">
            <div><h1>Reserva de Habitaciones</h1></div>
            
            <h2>Datos del Cliente:</h2>
            <form action="reserva_habitacion.php" method="POST">
                Nombre: <input type="text" name="nombre"><br>
                Apellido: <input type="text" name="apellido"><br>
                RUT: <input type="text" name="RUT"><br>
                fecha_ingreso: <input type="text" name="fecha de entrada"><br>
                fecha_salida: <input type="text" name="fecha de salida"><br>
                <input type="submit">
            </form>
        </div>


        <div class="modificacionreservas">
            <div><h1>Modificacion reserva de Habitaciones</h1></div>
            
            <h2>Datos del Cliente:</h2>
            <form action="reserva_habitacion.php" method="POST">
                Nombre: <input type="text" name="nombre"><br>
                Apellido: <input type="text" name="apellido"><br>
                RUT: <input type="text" name="RUT"><br>
                fecha_ingreso: <input type="text" name="fecha de entrada"><br>
                fecha_salida: <input type="text" name="fecha de salida"><br>
                <input type="submit">
            </form>
        </div>


        <div class="cancelacionreservas">
            <div><h1>Cancelacion de reserva de Habitaciones</h1></div>
            
            <h2>Datos del Cliente:</h2>
            <form action="reserva_habitacion.php" method="POST">
                Nombre: <input type="text" name="nombre"><br>
                Apellido: <input type="text" name="apellido"><br>
                RUT: <input type="text" name="RUT"><br>
                fecha_ingreso: <input type="text" name="fecha de entrada"><br>
                fecha_salida: <input type="text" name="fecha de salida"><br>
                <input type="submit">
            </form>
<?php

require funciones.php;

#$conn = coneccion();

#$nombre = $_POST["nombre"];
#$apellido = $_POST["apellido"];
#$RUT = $_POST["RUT"];
#$fecha_ingreso = $_POST["fecha de entrada"];
#$fecha_salida = $_POST["fecha de salida"];


?>