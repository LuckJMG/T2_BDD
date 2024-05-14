<html>
<head>
	<title>Checkout</title>
</head>
<body>
	<a href="/">Home</a>

<h1>Checkout</h1>

<form action="checkout.php" method="post">
    Número de habitación: <input type="number" name="habitacion" required><br>
    <input type="submit"> 

    
</form>
<?php
require 'funciones.php';

$conn = coneccion();

if(isset($_POST['habitacion'])){
	$numero_habitacion = $_POST['habitacion'];

	$sql = "SELECT * FROM ReservaHabitacion WHERE numero_habitacion = $numero_habitacion";
	$result = $conn->query($sql);
}
$conn->close();
    if(isset($result) && $result->num_rows > 0): ?>
    <h2>Reservas para la habitación <?php echo $numero_habitacion; ?></h2>
    <table border="1">
        <tr>
            <th>ID Reserva</th>
            <th>RUT Cliente</th>
            <th>Fecha de Ingreso</th>
            <th>Fecha de Salida</th>
            <th>Fecha CheckOut</th>
        </tr>
        <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row["id"]; ?></td>
                <td><?php echo $row["rut_cliente"]; ?></td>
                <td><?php echo $row["fecha_checkin"]; ?></td>
                <td><?php echo $row["fecha_checkout"]; ?></td>
                <td><form action = "checkout.php" method="POST">
                        Fecha de salida: <input type="date" name="fecha_salida" min="<?php echo $row["fecha_checkin"]; ?>" max="<?php echo $row["fecha_checkout"]; ?>" required><br>
                        <input type="hidden" name="reserva_id" value="<?php echo $row["id"]; ?>">
                        <input type="submit" value = 'Seleccionar'>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
<?php endif; ?>

<?php 
    $conn = coneccion();

    if(isset($_POST['fecha_salida'])){
        $reserva_id = $_POST['reserva_id'];
        $fecha_salida = $_POST['fecha_salida'];
        $sql1 = "UPDATE ReservaHabitacion SET fecha_checkout = '$fecha_salida' WHERE id = $reserva_id";
        $result1 = $conn->query($sql1);
        $sql2 = "CALL calcular_valor($reserva_id)";
        $result2 = $conn->query($sql2);
        $sql = "SELECT * FROM ReservaHabitacion WHERE id = $reserva_id";
        $result = $conn->query($sql);
        while($row = $result->fetch_assoc()){
            $rut_cliente = $row['rut_cliente'];
            $fecha_checkin = $row['fecha_checkin'];
            $fecha_checkout = $row['fecha_checkout'];
            $total = $row['valor_total'];
        }
        echo "<h2>CheckOut para la habitación con ID $reserva_id</h2>
                <table border='1'>
                    <tr>
                        <th>ID Reserva</th>
                        <th>RUT Cliente</th>
                        <th>Fecha de Ingreso</th>
                        <th>Fecha de Salida</th>
                        <th>Total<th>
                        <th>Calificacion<th>
                        <th>CheckOut<th>
                    </tr>
                    <tr>
                        <td>$reserva_id</td>
                        <td>$rut_cliente</td>
                        <td>$fecha_checkin</td>
                        <td>$fecha_checkout</td>
                        <td>$total</td>
                        <td><form action = 'checkout.php' method='POST'>
                                Calificacion: <input type='number' name='calificacion' min='1' max='5' required><br>
                                <input type='hidden' name='reserva_id' value='$reserva_id'>
                                <input type='submit' value = 'Seleccionar'>
                            </form>
                        </td>
                    <tr>
                    
                <table>";
                    
    }

    $conn->close();
?>



