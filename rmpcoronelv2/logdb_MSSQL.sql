23/04/2016 - Se agreg� a la tabla descarga_encabezados zona_primer_lance (int)
27/04/2016 - Se agreg� una tabla "falsa" copia de mareas, la original mareas1 est� en la DB (pero esto lo hice solo para sacar una vista de cuotas que estaba agregando y que me base en la vista de mareas)
14/05/2016 Falt� reportar que se borr� la lista falsa y se cre� una nueva tabla, con prop�sito de pruebas, para el tema de las vistas en control de cuotas

-- pre 21/06
INSERT unidades (nombre, abreviacion, [precision], estado_id) VALUES
('PORCENTAJE', '%', '7', '1'),
('UNIDADES MINIMAS DIVISIBLES', 'UMD', '0', '1'),
('UNIDAD MINIMA RESIDUAL', 'UMR', '7', '1');

CREATE TABLE zonas_pesca (
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

-- cambios auxiliares 21/06
ALTER TABLE auxiliares ADD sindicato bit DEFAULT 0;

-- cambios naves 21/06
ALTER TABLE naves ADD sindicato_id int REFERENCES auxiliares(id) NULL;

-- cambios licencias de pesca 21/06
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
  auxiliar_id int REFERENCES auxiliares(id) NOT NULL, /*Se refiere al dueño*/
  especie_id int REFERENCES especies(id) NOT NULL,
  estado_id int REFERENCES estados(id) DEFAULT 1,
  adjunto VARBINARY(MAX) NULL,
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


ALTER TABLE descarga_detalles ADD resolucion_id int NULL REFERENCES licencias(id);
ALTER TABLE descarga_detalles ADD zona_pesca_id int NULL REFERENCES zonas_pesca(id);

-- decretos de cuotas 23-06-2016

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

-- estado cuotas 23-06-2016
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

-- registros cuota 23-06-2016
-- No usado actualmente
CREATE TABLE registro_cuotas (
	id int IDENTITY(1,1) PRIMARY KEY,
	periodo int NOT NULL REFERENCES periodos(id),
	unidad int NOT NULL REFERENCES unidades(id),
	cantidad float DEFAULT 0,
	creado datetime NOT NULL,
	actualizado datetime NULL,
	usuario_uid VARCHAR(40) NOT NULL REFERENCES usuarios(uid)
);

-- operaciones 23-06-2016

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
	fecha_inicio date NOT NULL,
	fecha_termino date NOT NULL,
	macro_zona_id int NOT NULL REFERENCES macro_zonas(id),
	unidad_id int NOT NULL REFERENCES unidades(id),
	cantidad decimal(10, 6) NOT NULL,
	creado datetime NOT NULL,
	actualizado datetime NULL,
	usuario_uid VARCHAR(40) NOT NULL REFERENCES usuarios(uid)
);

---- cambios generales
-- nuevo tipo de  auxiliar
ALTER TABLE auxiliares ADD titular_licencia BIT DEFAULT 0;
-- fecha_promulgacion_operaciones
ALTER TABLE operaciones ADD fecha_promulgacion DATE NOT NULL; -- en caso de tener datos ingresados deberia ser NULL

-- VISTAS PARA OPERACIONES Y LICENCIAS

CREATE VIEW cuota_disponible_por_resolucion
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
GROUP BY LICOP.licencia_id, LICOP.total_licencia, LICOP.year_estado

CREATE VIEW cuota_disponible_por_especie
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
GROUP BY LICOP.especie_id, LICOP.total_licencia, LICOP.year_estado

-- Cambiar tipo de datos en cantidad operaciones
ALTER TABLE operaciones ALTER COLUMN cantidad decimal(20,6);

-- Nuevos Privilegios

INSERT INTO privilegios (nombre) VALUES
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
('cuotas_estado_delete');

-- Se agrega nave a las licencias

ALTER TABLE licencias ADD nave_id int REFERENCES naves(id);

-- Se agregan un string para ingreso manual de resoluciones y un campo para agregar observaciones
ALTER TABLE operaciones ADD resolucion VARCHAR(20) DEFAULT 0;
ALTER TABLE operaciones ADD observaciones TEXT NULL;

-- Se agrega costo de la licencia
ALTER TABLE licencias ADD costo decimal(20,6) DEFAULT 0;

-- Se agrega una relacion con auxiliar en operaciones
ALTER TABLE operaciones ADD auxiliar_id int REFERENCES auxiliares(id) NULL;

-- Se agrega unidad a los costos de las licencias
ALTER TABLE unidades ADD grupo int DEFAULT 0;
ALTER TABLE licencias ADD costo_unidad_id int DEFAULT 1;
