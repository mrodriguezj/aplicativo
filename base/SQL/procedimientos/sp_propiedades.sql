DELIMITER $$

CREATE PROCEDURE sp_insertar_propiedad (
    IN p_dimensiones DECIMAL(8,2),
    IN p_precio DECIMAL(10,2),
    IN p_tipo ENUM('premium', 'regular', 'comercial'),
    IN p_disponibilidad ENUM('disponible', 'vendido', 'reservado'),
    IN p_observaciones TEXT
        )
BEGIN
INSERT INTO propiedades (dimensiones, precio, tipo, disponibilidad, observaciones)
VALUES (p_dimensiones, p_precio, p_tipo, p_disponibilidad, p_observaciones);
END $$

DELIMITER ;

--EJEMPLO INSERTAR DATOS
CALL sp_insertar_propiedad(150.75, 250000.00, 'premium', 'disponible', 'Ubicación privilegiada.');
--FIN DE EJEMPLO

DELIMITER $$

CREATE PROCEDURE sp_actualizar_propiedad (
    IN p_id_lote INT,
    IN p_dimensiones DECIMAL(8,2),
    IN p_precio DECIMAL(10,2),
    IN p_tipo ENUM('premium', 'regular', 'comercial'),
    IN p_disponibilidad ENUM('disponible', 'vendido', 'reservado'),
    IN p_observaciones TEXT
        )
BEGIN
UPDATE propiedades
SET dimensiones = p_dimensiones,
    precio = p_precio,
    tipo = p_tipo,
    disponibilidad = p_disponibilidad,
    observaciones = p_observaciones
WHERE id_lote = p_id_lote;
END $$

DELIMITER ;

--EJEMPLO ACTUALIZAR PROPIEDAD
CALL sp_actualizar_propiedad(1, 180.50, 275000.00, 'comercial', 'reservado', 'Cerca de zona comercial.');
--FIN EJEMPLO


--LISTAR PROPIEDADES DISPONIBLES
DELIMITER $$

CREATE PROCEDURE sp_listar_lotes_disponibles()
BEGIN
SELECT
    id_lote,
    CONCAT('Lote ', id_lote) AS lote_info,
    precio
FROM propiedades
WHERE disponibilidad = 'disponible'
ORDER BY id_lote ASC;
END $$

DELIMITER ;


--EJEMPLO DE LISTAR PROPIEDADES DISPONIBLES
CALL sp_listar_lotes_disponibles();
--FIN DE EJEMPLO

