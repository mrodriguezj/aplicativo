--Creación de la tabla de pagos realizados
CREATE TABLE pagos_realizados (
    id_pago INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_cuenta INT UNSIGNED NOT NULL,
    monto_pagado DECIMAL(10,2) NOT NULL,
    fecha_real_pago DATETIME NOT NULL DEFAULT NOW(), --fecha en la que se hace el registro del pago en el aplicativo
    fecha_pago_efectivo DATE NOT NULL, --fecha en la que se recibe el pago
    metodo_pago ENUM('deposito', 'transferencia', 'efectivo') NOT NULL,
    folio_pago VARCHAR(50) DEFAULT NULL,
    comentarios TEXT DEFAULT NULL,
    FOREIGN KEY (id_cuenta) REFERENCES cuentas_por_cobrar(id_cuenta)
);