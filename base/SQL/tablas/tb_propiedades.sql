-- Creación de la tabla propiedades
CREATE TABLE propiedades (
    id_lote INT UNSIGNED AUTO_INCREMENT PRIMARY KEY, -- Identificador único del lote
    dimensiones DECIMAL(8,2) NOT NULL, -- Superficie en metros cuadrados
    precio DECIMAL(10,2) NOT NULL, -- Precio actual de la propiedad
    tipo ENUM('premium', 'regular', 'comercial') NOT NULL, -- Clasificación del lote
    disponibilidad ENUM('disponible', 'vendido', 'reservado') NOT NULL, -- Estado del lote
    observaciones TEXT -- Detalles adicionales
);