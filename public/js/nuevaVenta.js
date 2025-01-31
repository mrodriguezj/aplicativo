document.addEventListener("DOMContentLoaded", function() {
    const clienteSelect = document.getElementById("id_cliente");
    const loteSelect = document.getElementById("id_lote");
    const precioVentaInput = document.getElementById("precio_venta");
    const tipoVentaSelect = document.getElementById("tipo_venta");
    const seccionContado = document.getElementById("seccion_contado");
    const seccionPagos = document.getElementById("seccion_pagos");
    const btnGuardarVenta = document.getElementById("btnGuardarVenta");

    // Bloqueamos el input de precio para evitar ediciones
    precioVentaInput.disabled = true;

    // Función para mostrar el modal con mensaje
    function mostrarMensaje(mensaje) {
        document.getElementById("modalMensajeCuerpo").innerText = mensaje;
        let modal = new bootstrap.Modal(document.getElementById("modalMensaje"));
        modal.show();
    }

    // Función para cargar lista de lotes disponibles
    function cargarLotes() {
        loteSelect.innerHTML = '<option value="">Seleccione un lote</option>'; // Limpiar lista
        fetch("/api/obtener_lotes.php")
            .then(response => response.json())
            .then(data => {
                data.forEach(lote => {
                    let option = document.createElement("option");
                    option.value = lote.id_lote;
                    option.textContent = lote.lote_info;
                    option.setAttribute("data-precio", lote.precio); // Guardamos el precio en el atributo
                    loteSelect.appendChild(option);
                });
            })
            .catch(() => {
                console.error("Error al cargar la lista de lotes.");
            });
    }

    // Cargar lista de clientes
    fetch("/api/obtener_clientes.php")
        .then(response => response.json())
        .then(data => {
            data.forEach(cliente => {
                let option = document.createElement("option");
                option.value = cliente.id_cliente;
                option.textContent = cliente.nombre_completo;
                clienteSelect.appendChild(option);
            });
        })
        .catch(() => {
            console.error("Error al cargar la lista de clientes.");
        });

    // Cargar lotes disponibles al inicio
    cargarLotes();

    // Cuando se seleccione un lote, actualizar automáticamente el precio
    loteSelect.addEventListener("change", function() {
        let selectedOption = loteSelect.options[loteSelect.selectedIndex];
        let precio = selectedOption.getAttribute("data-precio") || "0.00";
        precioVentaInput.value = precio;
    });

    // Mostrar/ocultar secciones según tipo de venta
    tipoVentaSelect.addEventListener("change", function() {
        seccionContado.style.display = tipoVentaSelect.value === "contado" ? "block" : "none";
        seccionPagos.style.display = tipoVentaSelect.value === "financiamiento" ? "block" : "none";
    });

    // Evento para registrar la venta
    btnGuardarVenta.addEventListener("click", function() {
        let data = {
            id_cliente: clienteSelect.value,
            id_lote: loteSelect.value,
            precio_venta: precioVentaInput.value,
            tipo_venta: tipoVentaSelect.value,
        };

        if (data.tipo_venta === "contado") {
            data.num_pagos_contado = document.getElementById("num_pagos_contado").value;
            data.monto_pago_contado = document.getElementById("monto_pago_contado").value;
            data.fecha_pago_contado = document.getElementById("fecha_pago_contado").value;
        } else if (data.tipo_venta === "financiamiento") {
            data.num_enganche = document.getElementById("num_enganche").value;
            data.monto_enganche = document.getElementById("monto_enganche").value;
            data.fecha_enganche = document.getElementById("fecha_enganche").value;
            data.num_mensualidades = document.getElementById("num_mensualidades").value;
            data.monto_mensualidad = document.getElementById("monto_mensualidad").value;
            data.fecha_mensualidad = document.getElementById("fecha_mensualidad").value;
            data.num_anualidades = document.getElementById("num_anualidades").value;
            data.monto_anualidad = document.getElementById("monto_anualidad").value;
            data.fecha_anualidad = document.getElementById("fecha_anualidad").value;
        }

        fetch("/api/registrar_venta.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(data)
        })
            .then(response => response.json())
            .then(result => {
                mostrarMensaje(result.message);
                if (result.success) {
                    document.getElementById("formVenta").reset();
                    seccionContado.style.display = "none";
                    seccionPagos.style.display = "none";
                    precioVentaInput.value = ""; // Limpiar el precio cuando se resetea
                    cargarLotes(); // Actualizar la lista de lotes disponibles
                }
            })
            .catch(() => {
                mostrarMensaje("Error en la conexión con el servidor.");
            });
    });
});
