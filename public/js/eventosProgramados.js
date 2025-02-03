document.addEventListener("DOMContentLoaded", function() {
    const filtroEstado = document.getElementById("filtroEstado");
    const tablaPagos = document.getElementById("tablaPagos");
    const totalPendiente = document.getElementById("totalPendiente");
    const totalPagado = document.getElementById("totalPagado");
    const totalVencido = document.getElementById("totalVencido");

    // Función para formatear números como moneda mexicana
    function formatearMoneda(valor) {
        return new Intl.NumberFormat("es-MX", {
            style: "currency",
            currency: "MXN",
            minimumFractionDigits: 2,
        }).format(valor);
    }

    // Función para cargar los pagos en la tabla
    function cargarPagos(estado = "") {
        let url = `../../../api/obtener_pagos.php`;
        if (estado) url += `?estado=${estado}`;

        fetch(url)
            .then(response => response.json())
            .then(data => {
                tablaPagos.innerHTML = "";
                data.forEach(pago => {
                    let diasAtraso = pago.estado_pago === "vencido" ? `${pago.dias_atraso} días` : "-";

                    let row = `<tr>
                        <td>${pago.id_cuenta}</td>
                        <td>${pago.cliente}</td>
                        <td>${pago.lote}</td>
                        <td>${formatearMoneda(parseFloat(pago.monto_pago))}</td>
                        <td>${formatearMoneda(parseFloat(pago.monto_pagado))}</td>
                        <td>${pago.fecha_pago}</td>
                        <td>${pago.estado_pago}</td>
                        <td>${pago.tipo_cobro}</td>
                        <td>${diasAtraso}</td>
                    </tr>`;
                    tablaPagos.innerHTML += row;
                });
            })
            .catch(() => {
                console.error("Error al cargar los pagos.");
            });
    }

    // Función para cargar la suma total de los pagos por estado
    function cargarSumas() {
        fetch("../../../api/sumar_pagos.php")
            .then(response => response.json())
            .then(data => {
                // Inicializar los valores en 0
                let sumas = { pendiente: 0, pagado: 0, vencido: 0 };

                // Recorrer los datos devueltos y asignarlos a su categoría
                data.forEach(suma => {
                    if (suma.estado_pago in sumas) {
                        sumas[suma.estado_pago] = parseFloat(suma.total_monto);
                    }
                });

                // Actualizar los elementos en la interfaz con formato de moneda
                totalPendiente.textContent = formatearMoneda(sumas.pendiente);
                totalPagado.textContent = formatearMoneda(sumas.pagado);
                totalVencido.textContent = formatearMoneda(sumas.vencido);
            })
            .catch(() => {
                console.error("Error al cargar las sumas.");
            });
    }

    // Cargar datos al inicio
    cargarPagos();
    cargarSumas();

    // Filtrar pagos cuando se seleccione un estado
    filtroEstado.addEventListener("change", function() {
        cargarPagos(filtroEstado.value);
    });
});
