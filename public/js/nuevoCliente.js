document.addEventListener("DOMContentLoaded", function() {
    const btnGuardar = document.getElementById("btnGuardar");

    function mostrarMensaje(mensaje) {
        document.getElementById("modalMensajeCuerpo").innerText = mensaje;
        let modal = new bootstrap.Modal(document.getElementById("modalMensaje"));
        modal.show();
    }

    btnGuardar.addEventListener("click", function() {
        let nombre = document.getElementById("nombre").value.trim();
        let apellido_paterno = document.getElementById("apellido_paterno").value.trim();
        let apellido_materno = document.getElementById("apellido_materno").value.trim();
        let correo = document.getElementById("correo").value.trim();
        let telefono = document.getElementById("telefono").value.trim();

        // Validaciones básicas
        if (!nombre || !apellido_paterno || !correo || !telefono) {
            mostrarMensaje("Por favor, complete los campos obligatorios.");
            return;
        }

        if (!/^[\w.-]+@[\w.-]+\.\w+$/.test(correo)) {
            mostrarMensaje("Ingrese un correo electrónico válido.");
            return;
        }

        if (!/^\d{10}$/.test(telefono)) {
            mostrarMensaje("El teléfono debe contener exactamente 10 dígitos.");
            return;
        }

        // Enviar datos al servidor
        let data = {
            nombre,
            apellido_paterno,
            apellido_materno,
            correo_electronico: correo,
            telefono
        };

        fetch("../../../api/agregar_cliente.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(data)
        })
            .then(response => response.json())
            .then(result => {
                mostrarMensaje(result.message);
                if (result.success) {
                    document.getElementById("formCliente").reset();
                }
            })
            .catch(() => {
                mostrarMensaje("Error en la conexión con el servidor.");
            });
    });
});
