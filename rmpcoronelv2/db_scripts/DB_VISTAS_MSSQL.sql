USE RMPCORONELv2c
GO

/*** ESPECIES CON LICENCIAS ***
SELECT DISTINCT especies.id, especies.nombre FROM licencias
INNER JOIN especies ON licencias.especie_id = especies.id*/

/*** CUOTA TOTAL POR LICENCIA ***

SELECT licencias.id, SUM(CASE WHEN paridad = 1 THEN cantidad ELSE -cantidad END)  FROM operaciones
INNER JOIN licencias ON operaciones.licencia_id = licencias.id
INNER JOIN tipo_operaciones ON operaciones.tipo_operacion_id = tipo_operaciones.id
GROUP BY licencias.id*/

/*** CUOTA RESTANTE (TON) POR LICENCIA ***/
SELECT DD.resolucion_id, SUM(DDU.cantidad) as total_captura, sum(CASE WHEN TIOP.paridad = 1 THEN OP.cantidad ELSE -OP.cantidad END) AS restante FROM descarga_detalles DD
INNER JOIN descarga_detalles_unidades DDU ON DD.id = DDU.descarga_detalle_id
INNER JOIN licencias ON licencias.id = DD.resolucion_id
INNER JOIN operaciones OP ON OP.licencia_id = licencias.id
INNER JOIN tipo_operaciones TIOP ON TIOP.id = OP.tipo_operacion_id
WHERE DDU.unidad_id = 1
GROUP BY DD.resolucion_id

/*** CAPTURA POR MES POR ESPECIE ***/
SELECT especies.nombre, YEAR(DE.inicio_desembarque) año, MONTH(DE.inicio_desembarque) mes, SUM(cantidad) total FROM descarga_detalles DD
INNER JOIN descarga_encabezados DE ON DE.id = DD.descarga_encabezado_id
INNER JOIN especies ON especies.id = DD.especie_id
INNER JOIN descarga_detalles_unidades DDU ON DD.id = DDU.descarga_detalle_id
WHERE DDU.unidad_id = 1
GROUP BY especies.id, especies.nombre, MONTH(DE.inicio_desembarque), YEAR(DE.inicio_desembarque)
ORDER BY año ASC, mes ASC