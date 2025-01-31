--Creación de la tabla de ventas
CREATE TABLE ventas (
    id_venta INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_lote INT UNSIGNED NOT NULL,
    id_cliente INT UNSIGNED NOT NULL,
    precio_venta DECIMAL(10,2) NOT NULL,
    fecha_venta DATETIME NOT NULL DEFAULT NOW(),
    tipo_pago ENUM('contado', 'enganche', 'mensualidad', 'anualidad') NOT NULL,
    FOREIGN KEY (id_lote) REFERENCES propiedades(id_lote),
    FOREIGN KEY (id_cliente) REFERENCES cliente(id_cliente)
);

--VENTAS 2.0
CREATE TABLE ventas (
    id_venta INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_lote INT UNSIGNED NOT NULL,
    id_cliente INT UNSIGNED NOT NULL,
    precio_venta DECIMAL(10,2) NOT NULL,
    fecha_venta TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Se asegura compatibilidad
    tipo_venta ENUM('contado', 'financiamiento') NOT NULL, -- Nuevo campo
    tipo_pago ENUM('contado', 'enganche', 'mensualidad', 'anualidad') NOT NULL,
    FOREIGN KEY (id_lote) REFERENCES propiedades(id_lote),
    FOREIGN KEY (id_cliente) REFERENCES cliente(id_cliente)
);
