<!DOCTYPE html>
<html>
    <head>
        <title>Reserva de Habitaciones</title>
    </head>
    <body>
        <div><h1>Reserva de Habitaciones</h1></div>

        <h2>Datos del Cliente:</h2>
        <form action="reserva_habitacion.php" method="POST">
            Nombre: <input type="text" name="nombre"><br>
            RUT: <input type="text" name="RUT"><br>
            fecha_ingreso: <input type="text" name="Fecha de Entrada"><br>
            fecha_salida: <input type="text" name="Fecha de Salida"><br>
            <input type="submit">
        </form>
<?php

require funciones.php

$base = coneccion();