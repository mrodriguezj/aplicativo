<?php
$conexion_path = "../../config/conexion.php";

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
    <title>Gestión de Propiedades</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <!--<link rel="stylesheet" href="../css/estilos.css"> -->
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center">Gestión de Propiedades</h2>

    <form id="formPropiedad">
        <div class="mb-3">
            <label for="lote" class="form-label">Lote</label>
            <input type="number" id="lote" class="form-control" placeholder="Ingrese ID del lote">
        </div>

        <div class="mb-3">
            <label for="dimensiones" class="form-label">Dimensiones</label>
            <input type="text" id="dimensiones" class="form-control" disabled>
        </div>

        <div class="mb-3">
            <label for="precio" class="form-label">Precio</label>
            <input type="text" id="precio" class="form-control" disabled>
        </div>

        <div class="mb-3">
            <label for="tipo" class="form-label">Tipo</label>
            <select id="tipo" class="form-control" disabled>
                <option value="premium">Premium</option>
                <option value="regular">Regular</option>
                <option value="comercial">Comercial</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="disponibilidad" class="form-label">Disponibilidad</label>
            <select id="disponibilidad" class="form-control" disabled>
                <option value="disponible">Disponible</option>
                <option value="vendido">Vendido</option>
                <option value="reservado">Reservado</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="observaciones" class="form-label">Observaciones</label>
            <textarea id="observaciones" class="form-control" disabled></textarea>
        </div>

        <!-- Botones -->
        <button type="button" id="btnVer" class="btn btn-primary">Ver</button>
        <button type="button" id="btnEditar" class="btn btn-warning" disabled>Editar</button>
        <button type="button" id="btnGuardar" class="btn btn-success" disabled>Guardar</button>
        <button type="button" id="btnCancelar" class="btn btn-danger" disabled>Cancelar</button>
    </form>
</div>

<!-- Bootstrap JS -->
<script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../js/propiedades.js"></script>
<script src="../js/validaciones.js"></script>



<!-- Modal para mostrar mensajes -->
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


</body>
</html>
