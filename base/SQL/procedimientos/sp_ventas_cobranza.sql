DELIMITER $$

CREATE PROCEDURE sp_registrar_venta (
    IN p_id_cliente INT,
    IN p_id_lote INT,
    IN p_precio_venta DECIMAL(10,2),
    IN p_tipo_venta ENUM('contado', 'financiamiento'),

    -- Datos para pagos de contado
    IN p_num_pagos_contado INT,
    IN p_monto_pago_contado DECIMAL(10,2),
    IN p_fecha_pago_contado DATE,

    -- Datos para enganche
    IN p_num_enganche INT,
    IN p_monto_enganche DECIMAL(10,2),
    IN p_fecha_enganche DATE,

    -- Datos para mensualidades
    IN p_num_mensualidades INT,
    IN p_monto_mensualidad DECIMAL(10,2),
    IN p_fecha_mensualidad DATE,

    -- Datos para anualidades
    IN p_num_anualidades INT,
    IN p_monto_anualidad DECIMAL(10,2),
    IN p_fecha_anualidad DATE
        )
BEGIN
    DECLARE v_id_venta INT;

    -- Insertar la venta en la tabla 'ventas'
INSERT INTO ventas (id_cliente, id_lote, precio_venta, tipo_venta, fecha_venta, tipo_pago)
VALUES (p_id_cliente, p_id_lote, p_precio_venta, p_tipo_venta, NOW(),
        CASE
            WHEN p_tipo_venta = 'contado' THEN 'contado'
            ELSE 'enganche'
            END);

-- Obtener el ID de la venta recién insertada
SET v_id_venta = LAST_INSERT_ID();

    -- Insertar pagos en 'cuentas_por_cobrar' según el tipo de venta
    IF p_tipo_venta = 'contado' THEN
        -- Insertar pagos de contado
        WHILE p_num_pagos_contado > 0 DO
            INSERT INTO cuentas_por_cobrar (id_venta, id_cliente, id_lote, monto_pago, fecha_pago, tipo_cobro, estado_pago)
            VALUES (v_id_venta, p_id_cliente, p_id_lote, p_monto_pago_contado, p_fecha_pago_contado, 'contado', 'pendiente');

            -- Avanzar un mes en la fecha del pago si hay más de un pago
            SET p_fecha_pago_contado = DATE_ADD(p_fecha_pago_contado, INTERVAL 1 MONTH);
            SET p_num_pagos_contado = p_num_pagos_contado - 1;
END WHILE;
ELSE
        -- Insertar pagos de enganche
        WHILE p_num_enganche > 0 DO
            INSERT INTO cuentas_por_cobrar (id_venta, id_cliente, id_lote, monto_pago, fecha_pago, tipo_cobro, estado_pago)
            VALUES (v_id_venta, p_id_cliente, p_id_lote, p_monto_enganche, p_fecha_enganche, 'enganche', 'pendiente');

            -- Avanzar un mes para el siguiente pago
            SET p_fecha_enganche = DATE_ADD(p_fecha_enganche, INTERVAL 1 MONTH);
            SET p_num_enganche = p_num_enganche - 1;
END WHILE;

        -- Insertar pagos de mensualidad
        WHILE p_num_mensualidades > 0 DO
            INSERT INTO cuentas_por_cobrar (id_venta, id_cliente, id_lote, monto_pago, fecha_pago, tipo_cobro, estado_pago)
            VALUES (v_id_venta, p_id_cliente, p_id_lote, p_monto_mensualidad, p_fecha_mensualidad, 'mensualidad', 'pendiente');

            -- Avanzar un mes para la siguiente mensualidad
            SET p_fecha_mensualidad = DATE_ADD(p_fecha_mensualidad, INTERVAL 1 MONTH);
            SET p_num_mensualidades = p_num_mensualidades - 1;
END WHILE;

        -- Insertar pagos de anualidad
        WHILE p_num_anualidades > 0 DO
            INSERT INTO cuentas_por_cobrar (id_venta, id_cliente, id_lote, monto_pago, fecha_pago, tipo_cobro, estado_pago)
            VALUES (v_id_venta, p_id_cliente, p_id_lote, p_monto_anualidad, p_fecha_anualidad, 'anualidad', 'pendiente');

            -- Avanzar un año para la siguiente anualidad
            SET p_fecha_anualidad = DATE_ADD(p_fecha_anualidad, INTERVAL 1 YEAR);
            SET p_num_anualidades = p_num_anualidades - 1;
END WHILE;
END IF;
END $$

DELIMITER ;
