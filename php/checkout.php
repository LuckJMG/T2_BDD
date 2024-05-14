<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<link rel="stylesheet" href="../styles.css">
    <title>Checkout</title>
</head>
<body>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
	<a href="/">Home</a>

<div class="cuadrado2">
    <div class="card">
        <h3 class="card-header">CheckOut</h3>
      <div class="card-body">
        <form action="checkout.php" method="post">
          <div class="mb-3">
            <label for="habitacion" class="form-label">Número de habitación</label>
            <input type="number" class="form-control" id="habitacion" name="habitacion" required>
          </div>
          <button type="submit" class="btn btn-primary">Buscar</button>
        </form>
    </div>
</div>
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
    <table class='table table-striped' border="1">
        <thead>
            <tr>
                <th scope='col'>ID Reserva</th>
                <th scope='col'>RUT Cliente</th>
                <th scope='col'>Fecha de Ingreso</th>
                <th scope='col'>Fecha de Salida</th>
                <th scope='col'>Fecha CheckOut</th>
            </tr>
        </thead>
        <?php while($row = $result->fetch_assoc()): ?>
        <tbody>  
            <tr>
                <td scope='row'><?php echo $row["id"]; ?></td>
                <td><?php echo $row["rut_cliente"]; ?></td>
                <td><?php echo $row["fecha_checkin"]; ?></td>
                <td><?php echo $row["fecha_checkout"]; ?></td>
                <td><form action = "checkout.php" method="POST">
                        <div class="mb-3">
                            <label for="fecha_salida" class="form-label">Fecha de Salida</label>
                            <input type="date" class="form-control" name="fecha_salida" min="<?php echo $row["fecha_checkin"]; ?>" max="<?php echo $row["fecha_checkout"]; ?>" required></p>
                            <input type="hidden" name="reserva_id" value="<?php echo $row["id"]; ?>">
                            <button type='submit' class='btn btn-primary'>Seleccionar</button>
                        </div>
                    </form>
                </td>
            </tr>
        </tbody>
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
                <table class='table table-striped' border='1'>
                    <thead>
                        <tr>
                            <th scope='col'>ID Reserva</th>
                            <th scope='col'>RUT Cliente</th>
                            <th scope='col'>Fecha de Ingreso</th>
                            <th scope='col'>Fecha de Salida</th>
                            <th scope='col'>Total</th>
                            <th scope='col'>Calificacion</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope='row'>$reserva_id</th>
                            <td>$rut_cliente</td>
                            <td>$fecha_checkin</td>
                            <td>$fecha_checkout</td>
                            <td>$total</td>
                            <td><form action = 'checkout.php' method='POST'>
                                    <div class='mb-3'>
                                        <label for='calificacion' class='form-label'>Calificacion</label>
                                        <input type='number' class='form-control' name='calificacion' min='1' max='5' required></p>
                                        <input type='hidden' name='reserva_id' value='$reserva_id'>
                                        <button type='submit' class='btn btn-primary'>Terminar CheckOut</button>
                                    </div>
                                </form>
                            </td>
                        <tr>
                    </tbody>
                <table>";
                    
    }

    $conn->close();
?>


<?php 
    $conn = coneccion();

    if(isset($_POST['calificacion'])){
        $reserva_id = $_POST['reserva_id'];
        $calificacion = $_POST['calificacion'];
        $sql = "UPDATE ReservaHabitacion SET calificacion = $calificacion WHERE id = $reserva_id";
        $result = $conn->query($sql);
        $sql1 = "DELETE FROM ReservaHabitacion WHERE id = $reserva_id";
        $result1 = $conn->query($sql1);
        echo "<h2>CheckOut terminado</h2>";
    }

    $conn->close();
?>



