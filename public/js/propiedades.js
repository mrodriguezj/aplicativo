document.addEventListener("DOMContentLoaded", function() {
    const loteInput = document.getElementById("lote");
    const btnVer = document.getElementById("btnVer");
    const btnEditar = document.getElementById("btnEditar");
    const btnGuardar = document.getElementById("btnGuardar");
    const btnCancelar = document.getElementById("btnCancelar");

    const inputs = document.querySelectorAll("#formPropiedad input, #formPropiedad textarea, #formPropiedad select");

    function toggleInputs(state) {
        inputs.forEach(input => {
            if (input.id !== "lote") { // Bloqueamos el lote al editar
                input.disabled = state;
            }
        });
    }

    function mostrarMensaje(mensaje) {
        document.getElementById("modalMensajeCuerpo").innerText = mensaje;
        let modal = new bootstrap.Modal(document.getElementById("modalMensaje"));
        modal.show();
    }

    // Buscar propiedad
    btnVer.addEventListener("click", function() {
        let idLote = loteInput.value;
        if (!idLote) {
            mostrarMensaje("Ingrese un número de lote.");
            return;
        }

        fetch(`../../api/obtener_propiedad.php?id_lote=${idLote}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById("dimensiones").value = data.dimensiones;
                    document.getElementById("precio").value = data.precio;
                    document.getElementById("tipo").value = data.tipo;
                    document.getElementById("disponibilidad").value = data.disponibilidad;
                    document.getElementById("observaciones").value = data.observaciones;

                    // Seleccionamos la opción correcta en los select
                    document.getElementById("tipo").value = data.tipo;
                    document.getElementById("disponibilidad").value = data.disponibilidad;

                    btnEditar.disabled = false;
                } else {
                    mostrarMensaje(data.message);
                }
            });
    });

    // Activar edición
    btnEditar.addEventListener("click", function() {
        toggleInputs(false);
        loteInput.disabled = true; // Bloqueamos el input "Lote"
        btnEditar.disabled = true;
        btnGuardar.disabled = false;
        btnCancelar.disabled = false;
    });

    // Cancelar edición
    btnCancelar.addEventListener("click", function() {
        toggleInputs(true);
        loteInput.disabled = false; // Desbloqueamos el input "Lote"
        btnEditar.disabled = false;
        btnGuardar.disabled = true;
        btnCancelar.disabled = true;
    });

    // Guardar cambios
    btnGuardar.addEventListener("click", function() {
        let idLote = loteInput.value;
        let data = {
            id_lote: idLote,
            dimensiones: document.getElementById("dimensiones").value,
            precio: document.getElementById("precio").value,
            tipo: document.getElementById("tipo").value,
            disponibilidad: document.getElementById("disponibilidad").value,
            observaciones: document.getElementById("observaciones").value
        };

        fetch("../../api/actualizar_propiedad.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(data)
        })
            .then(response => response.json())
            .then(result => {
                mostrarMensaje(result.message);
                if (result.success) {
                    toggleInputs(true);
                    loteInput.disabled = false; // Desbloqueamos el input "Lote" después de guardar
                    btnGuardar.disabled = true;
                    btnCancelar.disabled = true;
                }
            });
    });
});
