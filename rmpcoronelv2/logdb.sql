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
