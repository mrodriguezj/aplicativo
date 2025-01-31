DELIMITER $$

CREATE PROCEDURE sp_insertar_cliente (
    IN p_nombre VARCHAR(50),
    IN p_apellido_paterno VARCHAR(50),
    IN p_apellido_materno VARCHAR(50),
    IN p_correo_electronico VARCHAR(100),
    IN p_telefono CHAR(10)
)
BEGIN
INSERT INTO cliente (nombre, apellido_paterno, apellido_materno, correo_electronico, telefono)
VALUES (p_nombre, p_apellido_paterno, p_apellido_materno, p_correo_electronico, p_telefono);
END $$

DELIMITER ;

--EJEMPLO DE USO
CALL sp_insertar_cliente('Juan', 'Pérez', 'Gómez', 'juan.perez@example.com', '5544332211');
--FIN DE EJEMPLO

DELIMITER $$

CREATE PROCEDURE sp_actualizar_cliente (
    IN p_id_cliente INT,
    IN p_nombre VARCHAR(50),
    IN p_apellido_paterno VARCHAR(50),
    IN p_apellido_materno VARCHAR(50),
    IN p_correo_electronico VARCHAR(100),
    IN p_telefono CHAR(10)
)
BEGIN
UPDATE cliente
SET nombre = p_nombre,
    apellido_paterno = p_apellido_paterno,
    apellido_materno = p_apellido_materno,
    correo_electronico = p_correo_electronico,
    telefono = p_telefono
WHERE id_cliente = p_id_cliente;
END $$

DELIMITER ;

--EJEMPLO DE USO
CALL sp_actualizar_cliente(1, 'Carlos', 'Ramírez', 'Hernández', 'carlos.ramirez@example.com', '5566778899');
--FIN DE EJEMPLO

DELIMITER $$

--LISTAR CLIENTES
CREATE PROCEDURE sp_listar_clientes()
BEGIN
SELECT
    id_cliente,
    CONCAT(nombre, ' ', apellido_paterno, ' ', COALESCE(apellido_materno, '')) AS nombre_completo
FROM cliente
ORDER BY nombre_completo ASC;
END $$

DELIMITER ;

--EJEMPLO DE USO
CALL sp_listar_clientes();
--FIN DE EJEMPLO