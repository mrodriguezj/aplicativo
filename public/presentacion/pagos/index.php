<?php
$conexion_path = "../../../config/conexion.php";

if (file_exists($conexion_path)) {
    require_once $conexion_path;
} else {
    die("Error: No se encontraron las credenciales de conexión.");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventos Programados</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
    <!--<link rel="stylesheet" href="../../css/estilos.css">-->
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center">Eventos Programados</h2>

    <!-- Filtro de estado -->
    <div class="mb-3">
        <label for="filtroEstado" class="form-label">Filtrar por Estado</label>
        <select id="filtroEstado" class="form-control">
            <option value="">Todos</option>
            <option value="pendiente">Pendientes</option>
            <option value="pagado">Pagados</option>
            <option value="vencido">Vencidos</option>
        </select>
    </div>
    <!-- Resumen de Sumas -->
    <div class="row text-center my-4">
        <div class="col-md-4">
            <h5>Total Pendiente</h5>
            <p class="fw-bold text-warning" id="totalPendiente">$0.00</p>
        </div>
        <div class="col-md-4">
            <h5>Total Pagado</h5>
            <p class="fw-bold text-success" id="totalPagado">$0.00</p>
        </div>
        <div class="col-md-4">
            <h5>Total Vencido</h5>
            <p class="fw-bold text-danger" id="totalVencido">$0.00</p>
        </div>
    </div>


    <!-- Tabla de Pagos -->
    <table class="table table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>Cliente</th>
            <th>Lote</th>
            <th>Monto Pago</th>
            <th>Monto Pagado</th>
            <th>Fecha Pago</th>
            <th>Estado</th>
            <th>Tipo Cobro</th>
        </tr>
        </thead>
        <tbody id="tablaPagos">
        <!-- Los datos se llenarán dinámicamente -->
        </tbody>
    </table>
</div>

<!-- Bootstrap JS -->
<script src="../../bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../../js/eventosProgramados.js"></script>

</body>
</html>
