--Creación de la tabla de cobranza
CREATE TABLE cuentas_por_cobrar (
    id_cuenta INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_venta INT UNSIGNED NOT NULL,
    id_lote INT UNSIGNED NOT NULL,
    monto_pago DECIMAL(10,2) NOT NULL,
    monto_pagado DECIMAL(10,2) DEFAULT 0.00,
    fecha_pago DATE NOT NULL,
    estado_pago ENUM('pendiente', 'pagado', 'vencido') DEFAULT 'pendiente',
    FOREIGN KEY (id_venta) REFERENCES ventas(id_venta),
    FOREIGN KEY (id_lote) REFERENCES propiedades(id_lote)
);

--VERSION 2.0
CREATE TABLE cuentas_por_cobrar (
    id_cuenta INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_venta INT UNSIGNED NOT NULL,
    id_cliente INT UNSIGNED NOT NULL, -- Nuevo campo
    id_lote INT UNSIGNED NOT NULL,
    monto_pago DECIMAL(10,2) NOT NULL,
    monto_pagado DECIMAL(10,2) DEFAULT 0.00,
    fecha_pago DATE NOT NULL,
    estado_pago ENUM('pendiente', 'pagado', 'vencido') DEFAULT 'pendiente',
    tipo_cobro ENUM('enganche', 'mensualidad', 'anualidad') NOT NULL, -- Nuevo campo
    FOREIGN KEY (id_venta) REFERENCES ventas(id_venta),
    FOREIGN KEY (id_cliente) REFERENCES cliente(id_cliente), -- Nueva relación
    FOREIGN KEY (id_lote) REFERENCES propiedades(id_lote)
);
