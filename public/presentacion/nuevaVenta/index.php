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
    <title>Registro de Venta</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/estilos.css">
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center">Registro de Venta</h2>

    <form id="formVenta">
        <div class="mb-3">
            <label for="id_cliente" class="form-label">Cliente</label>
            <select id="id_cliente" class="form-control">
                <option value="">Seleccione un cliente</option>
                <!-- Los clientes se llenarán dinámicamente -->
            </select>
        </div>

        <div class="mb-3">
            <label for="id_lote" class="form-label">Lote</label>
            <select id="id_lote" class="form-control">
                <option value="">Seleccione un lote</option>
            </select>
        </div>


        <div class="mb-3">
            <label for="precio_venta" class="form-label">Precio de Venta</label>
            <input type="text" id="precio_venta" class="form-control" placeholder="Seleccione un lote" disabled>
        </div>


        <div class="mb-3">
            <label for="tipo_venta" class="form-label">Tipo de Venta</label>
            <select id="tipo_venta" class="form-control">
                <option value="">Seleccione...</option>
                <option value="contado">Contado</option>
                <option value="financiamiento">Financiamiento</option>
            </select>
        </div>

        <!-- Sección de pagos en "Contado" -->
        <div id="seccion_contado" style="display: none;">
            <h4>Detalles de Pago Contado</h4>

            <div class="mb-3">
                <label for="num_pagos_contado" class="form-label">Número de Pagos</label>
                <input type="number" id="num_pagos_contado" class="form-control" min="1" value="1">
            </div>

            <div class="mb-3">
                <label for="monto_pago_contado" class="form-label">Monto por Pago</label>
                <input type="text" id="monto_pago_contado" class="form-control">
            </div>

            <div class="mb-3">
                <label for="fecha_pago_contado" class="form-label">Fecha Inicial del Pago</label>
                <input type="date" id="fecha_pago_contado" class="form-control">
            </div>
        </div>

        <!-- Sección de pagos en "Financiamiento" -->
        <div id="seccion_pagos" style="display: none;">
            <h4>Detalles de Pago Financiamiento</h4>

            <div class="mb-3">
                <label for="num_enganche" class="form-label">Cantidad de Enganches</label>
                <input type="number" id="num_enganche" class="form-control" min="0" value="0">
            </div>

            <div class="mb-3">
                <label for="monto_enganche" class="form-label">Monto por Enganche</label>
                <input type="text" id="monto_enganche" class="form-control">
            </div>

            <div class="mb-3">
                <label for="fecha_enganche" class="form-label">Fecha Inicial del Enganche</label>
                <input type="date" id="fecha_enganche" class="form-control">
            </div>

            <div class="mb-3">
                <label for="num_mensualidades" class="form-label">Cantidad de Mensualidades</label>
                <input type="number" id="num_mensualidades" class="form-control" min="0" value="0">
            </div>

            <div class="mb-3">
                <label for="monto_mensualidad" class="form-label">Monto por Mensualidad</label>
                <input type="text" id="monto_mensualidad" class="form-control">
            </div>

            <div class="mb-3">
                <label for="fecha_mensualidad" class="form-label">Fecha Inicial de la Mensualidad</label>
                <input type="date" id="fecha_mensualidad" class="form-control">
            </div>

            <div class="mb-3">
                <label for="num_anualidades" class="form-label">Cantidad de Anualidades</label>
                <input type="number" id="num_anualidades" class="form-control" min="0" value="0">
            </div>

            <div class="mb-3">
                <label for="monto_anualidad" class="form-label">Monto por Anualidad</label>
                <input type="text" id="monto_anualidad" class="form-control">
            </div>

            <div class="mb-3">
                <label for="fecha_anualidad" class="form-label">Fecha Inicial de la Anualidad</label>
                <input type="date" id="fecha_anualidad" class="form-control">
            </div>
        </div>

        <!-- Botón para registrar la venta -->
        <button type="button" id="btnGuardarVenta" class="btn btn-success w-100">Registrar Venta</button>
    </form>
</div>

<!-- Bootstrap JS -->
<script src="../../bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../../js/nuevaVenta.js"></script>

<!-- Modal de Confirmación -->
<div class="modal fade" id="modalMensaje" tabindex="-1" aria-labelledby="modalMensajeLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalMensajeLabel">Mensaje del sistema</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body" id="modalMensajeCuerpo">
                <!-- Aquí se mostrará el mensaje dinámicamente -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>


</body>
</html>
