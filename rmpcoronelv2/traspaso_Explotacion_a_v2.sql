USE RMPCORONELv2
GO

-- NUEVAS TABLAS DEL MODULO DE CUOTAS
/*CREATE TABLE zonas_pesca (
	id int IDENTITY(1,1) PRIMARY KEY,
	nombre VARCHAR(30) NOT NULL,
	estado_id int DEFAULT 1 REFERENCES estados(id)
);

CREATE TABLE macro_zonas (
	id int IDENTITY(1,1) PRIMARY KEY,
	nombre VARCHAR(30) NOT NULL,
	estado_id int DEFAULT 1 REFERENCES macro_zonas(id)
);

CREATE TABLE macro_zonas_zonas_pesca (
	macro_zona_id int REFERENCES macro_zonas(id),
	zona_pesca_id int REFERENCES zonas_pesca(id),
	PRIMARY KEY (macro_zona_id, zona_pesca_id)
);

CREATE TABLE tipos_licencia(
	id int IDENTITY(1,1) PRIMARY KEY,
	nombre VARCHAR(30) NOT NULL,
	abreviacion VARCHAR(5) NOT NULL
);

CREATE TABLE licencias(
  id int IDENTITY(1,1) PRIMARY KEY,
  tipo_licencia_id int REFERENCES tipos_licencia(id) NOT NULL,
  modifica_licencia_id int REFERENCES licencias(id) NULL,
  codigo_resolucion varchar(30) NOT NULL,
  fecha_promulgacion date NOT NULL,
  fecha_inicio_vigencia date NOT NULL,
  fecha_termino_vigencia date NOT NULL,
  auxiliar_id int REFERENCES auxiliares(id) NOT NULL, /*Se refiere al titular de la licencia*/
  nave_id int REFERENCES naves(id),
  especie_id int REFERENCES especies(id) NOT NULL,
  estado_id int REFERENCES estados(id) DEFAULT 1,
  adjunto VARCHAR(100) NULL,
  observaciones text NULL,
  creado datetime NOT NULL,
  actualizado datetime NULL,
  usuario_uid VARCHAR(40) REFERENCES usuarios(uid) NOT NULL
);

CREATE TABLE licencias_macro_zonas (
	licencia_id int REFERENCES licencias(id),
	macro_zona_id int REFERENCES macro_zonas(id),
	PRIMARY KEY (licencia_id, macro_zona_id)
);

CREATE TABLE numeraciones (
  id int IDENTITY(1,1) PRIMARY KEY,
  licencia_id int REFERENCES licencias(id) NOT NULL,
  inicio int NOT NULL,
  fin int NOT NULL
);

CREATE TABLE licencias_unidades (
  licencia_id int REFERENCES licencias(id) NOT NULL,
  unidad_id int REFERENCES unidades(id) NOT NULL,
  cantidad float DEFAULT 0,
  PRIMARY KEY (licencia_id, unidad_id)
);

CREATE TABLE decretos (
	id int IDENTITY(1,1) PRIMARY KEY,
	codigo_resolucion VARCHAR(30) NOT NULL,
	fecha_promulgacion date NOT NULL,
	fecha_inicio_vigencia date NOT NULL,
	fecha_termino_vigencia date NOT NULL,
	especie_id int NOT NULL REFERENCES especies(id),
	estado_id int DEFAULT 1 REFERENCES estados(id),
	adjunto text NULL,
	observaciones text NULL,
	creado datetime NOT NULL,
	actualizado datetime NULL,
	usuario_uid VARCHAR(40) NOT NULL REFERENCES usuarios(uid)
);

CREATE TABLE periodos (
	id int IDENTITY(1,1) PRIMARY KEY,
	decreto_id int NOT NULL REFERENCES decretos(id),
	fecha_inicio date NOT NULL,
	fecha_termino date NOT NULL,
	macro_zona_id int NOT NULL REFERENCES macro_zonas(id)
);

CREATE TABLE periodos_unidades (
	periodo_id int REFERENCES periodos(id),
	unidad_id int REFERENCES unidades(id),
	cantidad float DEFAULT 0,
	PRIMARY KEY (periodo_id, unidad_id)
);

CREATE TABLE estados_cuota (
	id int IDENTITY(1,1) PRIMARY KEY,
	macro_zona_id int NOT NULL REFERENCES macro_zonas(id),
	fecha_estado date NOT NULL,
	especie_id int NOT NULL REFERENCES especies(id),
	creado datetime NOT NULL,
	actualizado datetime NULL,
	usuario_uid VARCHAR(40) NOT NULL REFERENCES usuarios(uid)
);

CREATE TABLE estados_cuota_unidades (
	estado_cuota_id int REFERENCES estados_cuota(id),
	unidad_id int REFERENCES unidades(id),
	cantidad float DEFAULT 0,
	PRIMARY KEY (estado_cuota_id, unidad_id)
);

CREATE TABLE tipo_operaciones (
	id int IDENTITY(1,1) PRIMARY KEY,
	nombre VARCHAR(30) NOT NULL,
	paridad int NOT NULL
);

CREATE TABLE operaciones (
	id int IDENTITY(1,1) PRIMARY KEY,
	tipo_operacion_id int NOT NULL REFERENCES tipo_operaciones(id),
	fecha_operacion date NOT NULL,
	licencia_id int NOT NULL REFERENCES licencias(id),
	fecha_promulgacion date NOT NULL,
	fecha_inicio date NOT NULL,
	fecha_termino date NOT NULL,
	macro_zona_id int NOT NULL REFERENCES macro_zonas(id),
	adjunto VARCHAR(100) NULL,
	unidad_id int NOT NULL REFERENCES unidades(id),
	cantidad decimal(20, 6) NOT NULL,
	creado datetime NOT NULL,
	actualizado datetime NULL,
	usuario_uid VARCHAR(40) NOT NULL REFERENCES usuarios(uid)
);*/

-- CAMBIOS A TABLAS MODULO RMP
/*ALTER TABLE auxiliares ADD sindicato bit DEFAULT 0;
ALTER TABLE auxiliares ADD titular_licencia BIT DEFAULT 0;
ALTER TABLE naves ADD sindicato_id int REFERENCES auxiliares(id) NULL;
ALTER TABLE descarga_detalles ADD resolucion_id int NULL REFERENCES licencias(id);
ALTER TABLE descarga_detalles ADD zona_pesca_id int NULL REFERENCES zonas_pesca(id);*/

-- NUEVAS UNIDADES MODULO DE CUOTAS
/*INSERT unidades (nombre, abreviacion, [precision], estado_id) VALUES
('PORCENTAJE', '%', '7', '1'),
('UNIDADES MINIMAS DIVISIBLES', 'UMD', '0', '1'),
('UNIDAD MINIMA RESIDUAL', 'UMR', '7', '1');*/

-- NUEVOS PERMISOS DEL MODULO DE CUOTAS
/*INSERT INTO privilegios (nombre) VALUES
('admin_zona_add'),
('admin_zona_edit'),
('admin_zona_delete'),
('admin_tipoOperacion_add'),
('admin_tipoOperacion_edit'),
('admin_tipoOperacion_delete'),
('cuotas_licencia_add'),
('cuotas_licencia_edit'),
('cuotas_licencia_delete'),
('cuotas_decreto_add'),
('cuotas_decreto_edit'),
('cuotas_decreto_delete'),
('cuotas_operacion_add'),
('cuotas_operacion_edit'),
('cuotas_operacion_delete'),
('cuotas_estado_add'),
('cuotas_estado_edit'),
('cuotas_estado_delete');*/

-- NO USADO ACTUALMENTE
/*CREATE TABLE registro_cuotas (
	id int IDENTITY(1,1) PRIMARY KEY,
	periodo int NOT NULL REFERENCES periodos(id),
	unidad int NOT NULL REFERENCES unidades(id),
	cantidad float DEFAULT 0,
	creado datetime NOT NULL,
	actualizado datetime NULL,
	usuario_uid VARCHAR(40) NOT NULL REFERENCES usuarios(uid)
);*/

-- VISTAS PARA OPERACIONES Y LICENCIAS

/*CREATE VIEW cuota_disponible_por_resolucion
AS
SELECT     LICOP.licencia_id, LICOP.total_licencia AS total_resolucion, LICOP.year_estado, SUM(CASE WHEN DD.id IS NOT NULL THEN DDU.cantidad ELSE 0 END) AS total_captura
FROM         (SELECT     LIC.id AS licencia_id, SUM(CASE WHEN TIOP.paridad = 1 THEN OP.cantidad ELSE - OP.cantidad END) AS total_licencia, YEAR(OP.fecha_inicio)
                                              AS year_estado
                       FROM          dbo.licencias AS LIC INNER JOIN
                                              dbo.operaciones AS OP ON OP.licencia_id = LIC.id INNER JOIN
                                              dbo.tipo_operaciones AS TIOP ON TIOP.id = OP.tipo_operacion_id
                       GROUP BY LIC.id, YEAR(OP.fecha_inicio)) AS LICOP LEFT OUTER JOIN
                      dbo.descarga_detalles AS DD ON DD.resolucion_id = LICOP.licencia_id LEFT OUTER JOIN
                      dbo.descarga_encabezados AS DE ON DE.id = DD.descarga_encabezado_id LEFT OUTER JOIN
                      dbo.descarga_detalles_unidades AS DDU ON DD.id = DDU.descarga_detalle_id
WHERE     (YEAR(DE.inicio_desembarque) = LICOP.year_estado) OR
                      (DD.id IS NULL)
GROUP BY LICOP.licencia_id, LICOP.total_licencia, LICOP.year_estado;*/

/*CREATE VIEW cuota_disponible_por_especie
AS
SELECT     LICOP.especie_id, LICOP.total_licencia AS total_resolucion, LICOP.year_estado, SUM(CASE WHEN DD.id IS NOT NULL THEN DDU.cantidad ELSE 0 END) AS total_captura
FROM         (SELECT     LIC.especie_id, SUM(CASE WHEN TIOP.paridad = 1 THEN OP.cantidad ELSE - OP.cantidad END) AS total_licencia, YEAR(OP.fecha_inicio)
                                              AS year_estado
                       FROM          dbo.licencias AS LIC INNER JOIN
                                              dbo.operaciones AS OP ON OP.licencia_id = LIC.id INNER JOIN
                                              dbo.tipo_operaciones AS TIOP ON TIOP.id = OP.tipo_operacion_id
                       GROUP BY LIC.especie_id, YEAR(OP.fecha_inicio)) AS LICOP LEFT OUTER JOIN
                      dbo.descarga_detalles AS DD ON DD.especie_id = LICOP.especie_id LEFT OUTER JOIN
                      dbo.descarga_encabezados AS DE ON DE.id = DD.descarga_encabezado_id LEFT OUTER JOIN
                      dbo.descarga_detalles_unidades AS DDU ON DD.id = DDU.descarga_detalle_id
WHERE     (YEAR(DE.inicio_desembarque) = LICOP.year_estado) OR
                      (DD.id IS NULL)
GROUP BY LICOP.especie_id, LICOP.total_licencia, LICOP.year_estado;*/

-- TRASPASO DE INFORMACION DESDE Explotacion

/*SET IDENTITY_INSERT zonas_pesca ON;
INSERT INTO zonas_pesca (id, nombre, estado_id)
SELECT * FROM RMPCORONELvExplotacion.dbo.zonas_pesca;
SET IDENTITY_INSERT zonas_pesca OFF;

SET IDENTITY_INSERT macro_zonas ON;
INSERT INTO macro_zonas (id, nombre, estado_id)
SELECT * FROM RMPCORONELvExplotacion.dbo.macro_zonas;
SET IDENTITY_INSERT macro_zonas OFF;

INSERT INTO macro_zonas_zonas_pesca (macro_zona_id, zona_pesca_id)
SELECT * FROM RMPCORONELvExplotacion.dbo.macro_zonas_zonas_pesca;

SET IDENTITY_INSERT tipos_licencia ON;
INSERT INTO tipos_licencia (id, nombre, abreviacion)
SELECT * FROM RMPCORONELvExplotacion.dbo.tipos_licencia;
SET IDENTITY_INSERT tipos_licencia OFF;

SET IDENTITY_INSERT especies ON;
INSERT INTO especies (id, nombre, ltp, estado_id) VALUES (46, 'SARDINA ESPAÑOLA', 0, 1);
SET IDENTITY_INSERT especies OFF;

SET IDENTITY_INSERT licencias ON;
INSERT INTO licencias (id, tipo_licencia_id, modifica_licencia_id, codigo_resolucion, fecha_promulgacion, fecha_inicio_vigencia, fecha_termino_vigencia, auxiliar_id, especie_id, estado_id, adjunto, observaciones, creado, actualizado, usuario_uid, nave_id)
SELECT * FROM RMPCORONELvExplotacion.dbo.licencias;
SET IDENTITY_INSERT licencias OFF;

INSERT INTO licencias_macro_zonas (licencia_id, macro_zona_id)
SELECT * FROM RMPCORONELvExplotacion.dbo.licencias_macro_zonas;

SET IDENTITY_INSERT numeraciones ON;
INSERT INTO numeraciones (id, licencia_id, inicio, fin)
SELECT * FROM RMPCORONELvExplotacion.dbo.numeraciones;
SET IDENTITY_INSERT numeraciones OFF;

INSERT INTO licencias_unidades (licencia_id, unidad_id, cantidad)
SELECT * FROM RMPCORONELvExplotacion.dbo.licencias_unidades;

SET IDENTITY_INSERT decretos ON;
INSERT INTO decretos (id, codigo_resolucion, fecha_promulgacion, fecha_inicio_vigencia, fecha_termino_vigencia, especie_id, estado_id, adjunto, observaciones, creado, actualizado, usuario_uid)
SELECT * FROM RMPCORONELvExplotacion.dbo.decretos;
SET IDENTITY_INSERT decretos OFF;

SET IDENTITY_INSERT periodos ON;
INSERT INTO periodos (id, decreto_id, fecha_inicio, fecha_termino, macro_zona_id)
SELECT * FROM RMPCORONELvExplotacion.dbo.periodos;
SET IDENTITY_INSERT periodos OFF;

INSERT INTO periodos_unidades (periodo_id, unidad_id, cantidad)
SELECT * FROM RMPCORONELvExplotacion.dbo.periodos_unidades;*/

--SET IDENTITY_INSERT estados_cuota ON;
--INSERT INTO estados_cuota (*)
--SELECT * FROM RMPCORONELvExplotacion.dbo.estados_cuota;
--SET IDENTITY_INSERT estados_cuota OFF;

--INSERT INTO estados_cuotas_unidades (periodo_id, unidad_id, cantidad)
--SELECT * FROM RMPCORONELvExplotacion.dbo.estados_cuotas_unidades;

/*SET IDENTITY_INSERT tipo_operaciones ON;
INSERT INTO tipo_operaciones (id, nombre, paridad)
SELECT * FROM RMPCORONELvExplotacion.dbo.tipo_operaciones;
SET IDENTITY_INSERT tipo_operaciones OFF;

SET IDENTITY_INSERT operaciones ON;
INSERT INTO operaciones (id, tipo_operacion_id, fecha_operacion, licencia_id, fecha_inicio, fecha_termino, macro_zona_id, unidad_id, cantidad, creado, actualizado, usuario_uid, adjunto, fecha_promulgacion)
SELECT * FROM RMPCORONELvExplotacion.dbo.operaciones;
SET IDENTITY_INSERT operaciones OFF;

UPDATE auxiliares
SET sindicato = a2.sindicato,
	titular_licencia = a2.titular_licencia
FROM
	auxiliares AS a1
	INNER JOIN RMPCORONELvExplotacion.dbo.auxiliares AS a2 ON a1.id = a2.id;
	
UPDATE naves
SET sindicato_id = n2.sindicato_id
FROM
	naves AS n1
	INNER JOIN RMPCORONELvExplotacion.dbo.naves AS n2 ON n1.id = n2.id;
	
UPDATE descarga_detalles
SET resolucion_id = dd2.resolucion_id,
	zona_pesca_id = dd2.zona_pesca_id
FROM
	descarga_detalles AS dd1
	INNER JOIN RMPCORONELvExplotacion.dbo.descarga_detalles AS dd2 ON dd1.id = dd2.id;
	
UPDATE descarga_detalles
SET zona_pesca_id = zp.id
FROM descarga_detalles AS dd
	INNER JOIN zonas_pesca AS zp ON dd.zona_pesca = zp.nombre*/