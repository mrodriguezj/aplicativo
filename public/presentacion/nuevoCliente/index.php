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
    <title>Nuevo Cliente</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/estilos.css">
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center">Registro de Nuevo Cliente</h2>

    <form id="formCliente">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" id="nombre" class="form-control" placeholder="Ingrese nombre">
        </div>

        <div class="mb-3">
            <label for="apellido_paterno" class="form-label">Apellido Paterno</label>
            <input type="text" id="apellido_paterno" class="form-control" placeholder="Ingrese apellido paterno">
        </div>

        <div class="mb-3">
            <label for="apellido_materno" class="form-label">Apellido Materno</label>
            <input type="text" id="apellido_materno" class="form-control" placeholder="Ingrese apellido materno (opcional)">
        </div>

        <div class="mb-3">
            <label for="correo" class="form-label">Correo Electrónico</label>
            <input type="email" id="correo" class="form-control" placeholder="Ingrese correo electrónico">
        </div>

        <div class="mb-3">
            <label for="telefono" class="form-label">Teléfono</label>
            <input type="text" id="telefono" class="form-control" placeholder="Ingrese teléfono (10 dígitos)">
        </div>

        <!-- Botón para enviar -->
        <button type="button" id="btnGuardar" class="btn btn-success w-100">Guardar Cliente</button>
    </form>
</div>

<!-- Modal de Mensaje -->
<div class="modal fade" id="modalMensaje" tabindex="-1" aria-labelledby="modalMensajeLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalMensajeLabel">Mensaje</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body" id="modalMensajeCuerpo">
                <!-- Aquí se mostrará el mensaje -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="../../bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../../js/nuevoCliente.js"></script>

</body>
</html>
