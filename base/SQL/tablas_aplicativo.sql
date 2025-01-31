-- Creación de la tabla propiedades
CREATE TABLE propiedades (
    id_lote INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,         -- Identificador único del lote
    dimensiones DECIMAL(8,2) NOT NULL,              -- Superficie en metros cuadrados
    precio DECIMAL(10,2) NOT NULL,                  -- Precio actual de la propiedad
    tipo ENUM('premium', 'regular', 'comercial') NOT NULL, -- Clasificación del lote
    disponibilidad ENUM('disponible', 'vendido', 'reservado') NOT NULL, -- Estado del lote
    observaciones TEXT                              -- Detalles adicionales
);

-- Creación de la tabla historial_precios
CREATE TABLE historial_precios (
    id_historial INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,    -- Identificador único del registro
    id_lote INT NOT NULL,                           -- Referencia al lote
    precio_anterior DECIMAL(10,2),                  -- Precio antes del cambio
    precio_nuevo DECIMAL(10,2) NOT NULL,            -- Precio actualizado
    fecha_cambio DATETIME NOT NULL DEFAULT NOW(),   -- Fecha y hora del cambio
    motivo_cambio TEXT,                             -- Observaciones sobre el cambio
    FOREIGN KEY (id_lote) REFERENCES propiedades(id_lote) -- Llave foránea a la tabla propiedades
);

--Creación de la tabla clientes
CREATE TABLE cliente (
    id_cliente INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    apellido_paterno VARCHAR(50) NOT NULL,
    apellido_materno VARCHAR(50),
    correo_electronico VARCHAR(100) NOT NULL UNIQUE,
    telefono CHAR(10) NOT NULL
);

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

--Creación de la tabla de pagos realizados
CREATE TABLE pagos_realizados (
    id_pago INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_cuenta INT UNSIGNED NOT NULL,
    monto_pagado DECIMAL(10,2) NOT NULL,
    fecha_real_pago DATETIME NOT NULL DEFAULT NOW(),
    fecha_pago_efectivo DATE NOT NULL,
    metodo_pago ENUM('deposito', 'transferencia', 'efectivo') NOT NULL,
    folio_pago VARCHAR(50) DEFAULT NULL,
    comentarios TEXT DEFAULT NULL,
    FOREIGN KEY (id_cuenta) REFERENCES cuentas_por_cobrar(id_cuenta)
);

--Creación de la tabla de notificaciones
CREATE TABLE usuarios (
    id SERIAL PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    password_hash TEXT NOT NULL,
    rol VARCHAR(50) CHECK (rol IN ('operativo', 'administrativo')),
    activo BOOLEAN DEFAULT TRUE,
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
