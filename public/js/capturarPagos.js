document.addEventListener("DOMContentLoaded", function() {
    const btnBuscarLote = document.getElementById("buscarLote");
    const btnRegistrarPago = document.getElementById("btnRegistrarPago");
    const loteInput = document.getElementById("lote");
    const montoPagoInput = document.getElementById("montoPago");
    const metodoPagoInput = document.getElementById("metodoPago");
    const fechaPagoInput = document.getElementById("fechaPagoEfectivo");
    const folioPagoInput = document.getElementById("folioPago");
    const comentariosInput = document.getElementById("comentarios");
    const tablaPagos = document.getElementById("tablaPagos");

    let saldoTotalLote = 0;
    let pagosPendientes = [];

    function buscarPagosPorLote() {
        const idLote = loteInput.value.trim();

        if (!idLote) {
            Swal.fire("Error", "Ingrese un ID de lote válido.", "error");
            return;
        }

        fetch(`../../../api/obtener_pagos_pendientes.php?id_lote=${idLote}`)
            .then(response => response.json())
            .then(data => {
                if (!data.success) {
                    throw new Error(data.message || "Error desconocido al procesar la respuesta.");
                }

                if (data.data.length === 0) {
                    Swal.fire("Aviso", "No hay pagos pendientes para este lote.", "info");
                    tablaPagos.innerHTML = "";
                    return;
                }

                pagosPendientes = data.data;
                saldoTotalLote = pagosPendientes.reduce((total, pago) => total + (parseFloat(pago.monto_pago) - parseFloat(pago.monto_pagado)), 0);
                mostrarPagosPendientes();
            })
            .catch(error => {
                console.error("❌ Error en la solicitud fetch:", error);
                Swal.fire("Error", "No se pudo obtener la información de pagos pendientes.", "error");
            });
    }

    function mostrarPagosPendientes() {
        tablaPagos.innerHTML = "";
        pagosPendientes.forEach(pago => {
            const montoTotal = parseFloat(pago.monto_pago);
            const montoPagado = parseFloat(pago.monto_pagado);
            const saldoPendiente = montoTotal - montoPagado;

            const row = `<tr>
                <td>${pago.id_cuenta}</td>
                <td>${pago.fecha_pago}</td>
                <td>$${montoTotal.toFixed(2)}</td>
                <td>$${montoPagado.toFixed(2)}</td>
                <td>$${saldoPendiente.toFixed(2)}</td>
            </tr>`;
            tablaPagos.innerHTML += row;
        });
    }

    function registrarPago() {
        let montoIngresado = parseFloat(montoPagoInput.value);
        let metodoPago = metodoPagoInput.value;
        let fechaPagoEfectivo = fechaPagoInput.value;
        let folioPago = folioPagoInput.value.trim();
        let comentarios = comentariosInput.value.trim();
        let idLote = loteInput.value.trim();

        if (!montoIngresado || montoIngresado <= 0) {
            Swal.fire("Error", "Ingrese un monto válido.", "error");
            return;
        }
        if (montoIngresado > saldoTotalLote) {
            Swal.fire("Error", `El monto ingresado ($${montoIngresado.toFixed(2)}) excede la deuda total ($${saldoTotalLote.toFixed(2)}).`, "error");
            return;
        }

        Swal.fire({
            title: "Confirmar Pago",
            text: `Está a punto de registrar un pago de $${montoIngresado.toFixed(2)}. ¿Desea continuar?`,
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Sí, registrar",
            cancelButtonText: "Cancelar"
        }).then((result) => {
            if (result.isConfirmed) {
                let data = {
                    id_lote: idLote,
                    monto_pagado: montoIngresado,
                    metodo_pago: metodoPago,
                    fecha_pago_efectivo: fechaPagoEfectivo,
                    folio_pago: folioPago,
                    comentarios: comentarios
                };

                fetch("../../../api/registrar_pago.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify(data)
                })
                    .then(response => response.json())
                    .then(result => {
                        if (result.success) {
                            Swal.fire("Pago Registrado", result.message, "success").then(() => {
                                buscarPagosPorLote(); // Recargar la lista de pagos pendientes
                                montoPagoInput.value = "";
                                metodoPagoInput.value = "deposito";
                                fechaPagoInput.value = "";
                                folioPagoInput.value = "";
                                comentariosInput.value = "";
                            });
                        } else {
                            Swal.fire("Error", result.message, "error");
                        }
                    })
                    .catch(() => {
                        Swal.fire("Error", "Hubo un problema al registrar el pago.", "error");
                    });
            }
        });
    }

    btnBuscarLote.addEventListener("click", buscarPagosPorLote);
    btnRegistrarPago.addEventListener("click", registrarPago);
});
