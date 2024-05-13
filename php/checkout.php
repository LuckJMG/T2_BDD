<html>
<head>
	<title>Checkout</title>
</head>
<body>
	<a href="/">Home</a>

    <?php
    require 'funciones.php';
    // Verificar si se ha enviado el número de habitación
    if(isset($_POST['habitacion'])){
    
    $conn = coneccion();
    // Obtener el número de habitación enviado por el formulario
    $numero_habitacion = $_POST['habitacion'];

    // Consulta para obtener las fechas mínimas y máximas para el número de habitación especificado
    $sql = "SELECT fecha_checkin AS fecha_minima, fecha_checkout AS fecha_maxima FROM ReservaHabitacion WHERE numero_habitacion = $numero_habitacion";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $fecha_minima = $row["fecha_minima"];
        $fecha_maxima = $row["fecha_maxima"];
    } else {
        echo "No se encontraron resultados para el número de habitación proporcionado.";
    }

    $conn->close();
}
?>

<h1>Checkout</h1>

<form action="checkout.php" method="post">
    Número de habitación: <input type="number" name="habitacion" required><br>
    <?php if(isset($fecha_minima) && isset($fecha_maxima)): ?>
        Fecha de salida: <input type="date" name="fecha_salida" min="<?php echo $fecha_minima; ?>" max="<?php echo $fecha_maxima; ?>" required><br>
    <?php endif; ?>
    <input type="submit">
</form>
