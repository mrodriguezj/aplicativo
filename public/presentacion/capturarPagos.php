<?php require_once "../../config/conexion.php"; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Capturar Pagos</title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<div class="container mt-4">
    <h2 class="text-center mb-4">Capturar Pago por Lote</h2>

    <!-- 🔹 Buscar Lote -->
    <div class="mb-3">
        <label for="lote" class="form-label">Buscar Lote:</label>
        <div class="input-group">
            <input type="text" id="lote" class="form-control" placeholder="Ingrese el ID o número del lote">
            <button id="buscarLote" class="btn btn-primary">Buscar</button>
        </div>
    </div>

    <!-- 🔹 Tabla de Pagos Pendientes -->
    <h3 class="mt-4">Pagos Pendientes</h3>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
            <tr>
                <th>ID Cuenta</th>
                <th>Fecha Pago</th>
                <th>Monto Total</th>
                <th>Monto Pagado</th>
                <th>Saldo Pendiente</th>
            </tr>
            </thead>
            <tbody id="tablaPagos">
            <!-- Se llenará con JS -->
            </tbody>
        </table>
    </div>

    <!-- 🔹 Formulario de Captura de Pago -->
    <h3 class="mt-4">Registrar Pago</h3>
    <div class="card p-4 shadow-sm">
        <form id="formCapturarPago">
            <div class="row">
                <div class="col-md-6">
                    <label for="montoPago" class="form-label">Monto a Pagar:</label>
                    <input type="number" id="montoPago" class="form-control" step="0.01" required>
                </div>

                <div class="col-md-6">
                    <label for="metodoPago" class="form-label">Método de Pago:</label>
                    <select id="metodoPago" class="form-select">
                        <option value="deposito">Depósito</option>
                        <option value="transferencia">Transferencia</option>
                        <option value="efectivo">Efectivo</option>
                    </select>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-6">
                    <label for="fechaPagoEfectivo" class="form-label">Fecha de Pago:</label>
                    <input type="date" id="fechaPagoEfectivo" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label for="folioPago" class="form-label">Folio (opcional):</label>
                    <input type="text" id="folioPago" class="form-control">
                </div>
            </div>

            <div class="mt-3">
                <label for="comentarios" class="form-label">Comentarios:</label>
                <textarea id="comentarios" class="form-control"></textarea>
            </div>

            <div class="text-center mt-4">
                <button type="button" id="btnRegistrarPago" class="btn btn-success btn-lg">Registrar Pago</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="../js/capturarPagos.js"></script>
</body>
</html>
