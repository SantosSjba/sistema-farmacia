-- =====================================================
-- SCRIPT DE ACTUALIZACIÓN PARA PRODUCTOS GENERALES
-- Ejecutar este script en phpMyAdmin o tu gestor de BD
-- =====================================================

-- 1. Agregar "No Aplica" a la tabla categoria (Forma Farmacéutica)
INSERT INTO `categoria` (`forma_farmaceutica`, `ff_simplificada`) 
SELECT 'No Aplica', 'N/A' 
WHERE NOT EXISTS (SELECT 1 FROM `categoria` WHERE `forma_farmaceutica` = 'No Aplica');

-- 2. Agregar "No Aplica" a la tabla sintoma
INSERT INTO `sintoma` (`sintoma`, `idsucu_c`) 
SELECT 'No Aplica', 1 
WHERE NOT EXISTS (SELECT 1 FROM `sintoma` WHERE `sintoma` = 'No Aplica');

-- 3. Agregar un "laboratorio" genérico para productos sin laboratorio
INSERT INTO `cliente` (`nombres`, `id_tipo_docu`, `direccion`, `nrodoc`, `tipo`) 
SELECT 'SIN LABORATORIO', 1, 'N/A', '00000000', 'laboratorio' 
WHERE NOT EXISTS (SELECT 1 FROM `cliente` WHERE `nombres` = 'SIN LABORATORIO' AND `tipo` = 'laboratorio');

-- 4. Agregar lote "Sin Lote" para productos sin vencimiento
INSERT INTO `lote` (`numero`, `fecha_vencimiento`, `idsucu_c`) 
SELECT 'SIN LOTE', '2099-12-31', 1 
WHERE NOT EXISTS (SELECT 1 FROM `lote` WHERE `numero` = 'SIN LOTE');

-- =====================================================
-- VERIFICAR QUE SE INSERTARON CORRECTAMENTE:
-- =====================================================
-- SELECT * FROM categoria WHERE forma_farmaceutica = 'No Aplica';
-- SELECT * FROM sintoma WHERE sintoma = 'No Aplica';
-- SELECT * FROM cliente WHERE nombres = 'SIN LABORATORIO';
-- SELECT * FROM lote WHERE numero = 'SIN LOTE';
