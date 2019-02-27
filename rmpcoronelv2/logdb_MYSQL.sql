-- zonas de pesca

CREATE TABLE IF NOT EXISTS zonas_pesca (
	id int AUTO_INCREMENT PRIMARY KEY,
	nombre VARCHAR(30) NOT NULL,
	estado_id int DEFAULT 1 REFERENCES estados(id)
);

CREATE TABLE IF NOT EXISTS macro_zonas (
	id int AUTO_INCREMENT PRIMARY KEY,
	nombre VARCHAR(30) NOT NULL,
	estado_id int DEFAULT 1 REFERENCES macro_zonas(id)
);

CREATE TABLE IF NOT EXISTS macro_zonas_zonas_pesca (
	macro_zona_id int REFERENCES macro_zonas(id),
	zona_pesca_id int REFERENCES zonas_pesca(id),
	PRIMARY KEY (macro_zona_id, zona_pesca_id)
);

-- cambios auxiliares 21/06
ALTER TABLE auxiliares ADD COLUMN sindicato boolean DEFAULT false;

-- cambios naves 21/06
ALTER TABLE naves ADD COLUMN sindicato_id int REFERENCES auxiliares(id);

-- cambios licencias de pesca 21/06
CREATE TABLE IF NOT EXISTS tipos_licencia(
	id int AUTO_INCREMENT PRIMARY KEY,
	nombre VARCHAR(50) NOT NULL,
	abreviacion VARCHAR(5) NOT NULL
);

CREATE TABLE licencias(
  id int AUTO_INCREMENT PRIMARY KEY,
  tipo_licencia_id int NOT NULL REFERENCES tipos_licencia(id),
  modifica_licencia_id int NULL REFERENCES licencias(id),
  codigo_resolucion varchar(30) NOT NULL,
  fecha_promulgacion date NOT NULL,
  fecha_inicio_vigencia date NOT NULL,
  fecha_termino_vigencia date NOT NULL,
  auxiliar_id int NOT NULL REFERENCES auxiliares(id), /*Se refiere al dueño*/
  especie_id int NOT NULL REFERENCES especies(id),
  estado_id int DEFAULT 1 REFERENCES estados(id),
  adjunto text NULL,
  observaciones text NULL,
  creado datetime NOT NULL,
  actualizado datetime NULL,
  usuario_uid VARCHAR(40) NOT NULL REFERENCES usuarios(uid)
);

CREATE TABLE licencias_macro_zonas (
	licencia_id int REFERENCES licencias(id),
	macro_zona_id int REFERENCES macro_zonas(id),
	PRIMARY KEY (licencia_id, macro_zona_id)
);

CREATE TABLE numeraciones (
  id int AUTO_INCREMENT PRIMARY KEY,
  licencia_id int NOT NULL REFERENCES licencias(id),
  inicio int NOT NULL,
  fin int NOT NULL
);

CREATE TABLE licencias_unidades (
  licencia_id int NOT NULL REFERENCES licencias(id),
  unidad_id int NOT NULL REFERENCES unidades(id),
  cantidad float DEFAULT 0,
  PRIMARY KEY (licencia_id, unidad_id)
);

INSERT INTO tipos_licencia (nombre, abreviacion) VALUES
('LICENCIA TRANSABLE DE PESCA TIPO A', 'LTPA'),
('LICENCIA TRANSABLE DE PESCA TIPO B', 'LTPB'),
('PERMISO ESPECIAL DE PESCA', 'PEP'),
('RAE', 'RAE');

INSERT INTO unidades (nombre, abreviacion, `precision`) VALUES
('Porcentaje', '%', 7),
('UNIDADES MINIMAS DIVISIBLES', 'UMD', 0),
('UNIDAD MINIMA RESIDUAL', 'UMR', 7);

-- decretos de cuotas 23-06-2016

CREATE TABLE IF NOT EXISTS decretos (
	id int AUTO_INCREMENT PRIMARY KEY,
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

CREATE TABLE IF NOT EXISTS periodos (
	id int AUTO_INCREMENT PRIMARY KEY,
	decreto_id int NOT NULL REFERENCES decretos(id),
	fecha_inicio date NOT NULL,
	fecha_termino date NOT NULL,
	macro_zona_id int NOT NULL REFERENCES macro_zonas(id)
);

CREATE TABLE IF NOT EXISTS periodos_unidades (
	periodo_id int REFERENCES periodos(id),
	unidad_id int REFERENCES unidades(id),
	cantidad float DEFAULT 0,
	PRIMARY KEY (periodo_id, unidad_id)
);

-- estado cuotas 23-06-2016
CREATE TABLE IF NOT EXISTS estados_cuota (
	id int AUTO_INCREMENT PRIMARY KEY,
	macro_zona_id int NOT NULL REFERENCES macro_zonas(id),
	fecha_estado date NOT NULL,
	especie_id int NOT NULL REFERENCES especies(id),
	creado datetime NOT NULL,
	actualizado datetime NULL,
	usuario_uid VARCHAR(40) NOT NULL REFERENCES usuarios(uid)
);

CREATE TABLE IF NOT EXISTS estados_cuota_unidades (
	estado_cuota_id int REFERENCES estados_cuota(id),
	unidad_id int REFERENCES unidades(id),
	cantidad float DEFAULT 0,
	PRIMARY KEY (estado_cuota_id, unidad_id)
);

-- registros cuota 23-06-2016

CREATE TABLE IF NOT EXISTS registro_cuotas (
	id int AUTO_INCREMENT PRIMARY KEY,
	periodo int NOT NULL REFERENCES periodos(id),
	unidad int NOT NULL REFERENCES unidades(id),
	cantidad float DEFAULT 0,
	creado datetime NOT NULL,
	actualizado datetime NULL,
	usuario_uid VARCHAR(40) NOT NULL REFERENCES usuarios(uid)
);

-- operaciones 23-06-2016

CREATE TABLE tipo_operaciones (
	id int AUTO_INCREMENT PRIMARY KEY,
	nombre VARCHAR(30),
	paridad int NOT NULL
);

CREATE TABLE operaciones (
	id int AUTO_INCREMENT PRIMARY KEY,
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
ALTER TABLE auxiliares ADD COLUMN titular_licencia boolena DEFAULT false;
-- fecha_promulgacion_operaciones
ALTER TABLE operaciones ADD COLUMN fecha_promulgacion date NOT NULL; -- en caso de tener datos ingresados deberia ser NULL
