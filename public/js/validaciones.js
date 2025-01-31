document.addEventListener("DOMContentLoaded", function () {
    const loteInput = document.getElementById("lote");
    const dimensionesInput = document.getElementById("dimensiones");
    const precioInput = document.getElementById("precio");

    function mostrarMensaje(mensaje) {
        document.getElementById("modalMensajeCuerpo").innerText = mensaje;
        let modal = new bootstrap.Modal(document.getElementById("modalMensaje"));
        modal.show();
    }

    // Validar que solo se ingresen números en el input "Lote"
    loteInput.addEventListener("input", function (e) {
        if (!/^\d*$/.test(e.target.value)) {
            e.target.value = e.target.value.replace(/[^0-9]/g, ""); // Elimina caracteres no numéricos
            mostrarMensaje("Solo se permiten números en el campo 'Lote'.");
        }
    });

    // Validar que solo se ingresen números y un solo punto decimal en "Dimensiones"
    dimensionesInput.addEventListener("input", function (e) {
        if (!/^\d*\.?\d*$/.test(e.target.value)) {
            e.target.value = e.target.value.replace(/[^0-9.]/g, ""); // Permite solo números y punto
            if ((e.target.value.match(/\./g) || []).length > 1) {
                e.target.value = e.target.value.replace(/\.+$/, ""); // Elimina punto extra
            }
            mostrarMensaje("Solo se permiten números y un punto decimal en el campo 'Dimensiones'.");
        }
    });

    // Validar que solo se ingresen números y un solo punto decimal en "Precio"
    precioInput.addEventListener("input", function (e) {
        if (!/^\d*\.?\d*$/.test(e.target.value)) {
            e.target.value = e.target.value.replace(/[^0-9.]/g, ""); // Permite solo números y punto
            if ((e.target.value.match(/\./g) || []).length > 1) {
                e.target.value = e.target.value.replace(/\.+$/, ""); // Elimina punto extra
            }
            mostrarMensaje("Solo se permiten números y un punto decimal en el campo 'Precio'.");
        }
    });
});
