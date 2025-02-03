DELIMITER $$

CREATE EVENT actualizar_pagos_vencidos
ON SCHEDULE EVERY 1 DAY
STARTS TIMESTAMP(CURRENT_DATE, '00:00:00')
DO
BEGIN
UPDATE cuentas_por_cobrar
SET estado_pago = 'vencido'
WHERE estado_pago = 'pendiente' AND fecha_pago < CURDATE();
END $$

DELIMITER ;