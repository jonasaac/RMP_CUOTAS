CREATE FUNCTION ConvertirFecha( @date DATETIME )
RETURNS VARCHAR(50)
BEGIN
	RETURN (SELECT CAST(DATEPART(dd, @date) AS VARCHAR) +
	'-' +
	SUBSTRING('Ene Feb Mar Abr May Jun Jul Ago Sep Oct Nov Dic ', (DATEPART(m, @date) * 4) - 3, 3) +
	'-' +
	CAST(DATEPART(YYYY, @date) AS VARCHAR) +
	' ' +
	CAST(DATEPART(hh, @date) AS VARCHAR) +
	':' +
	CAST(DATEPART(mi, @date) AS VARCHAR))
END;


/*********************************
**********************************
--- TABLAS ---
**********************************
**********************************/
CREATE TABLE IF NOT EXISTS areas(
	id int AUTO_INCREMENT PRIMARY KEY,
	nombre varchar(20) NOT NULL,
	estado_id int NULL DEFAULT 1 REFERENCES estados(id)
);
/****** Object:  Table areas_auxiliares    Script Date: 29/04/2016 16:46:00 ******/
CREATE TABLE IF NOT EXISTS areas_auxiliares(
	area_id int NOT NULL REFERENCES areas(id),
	auxiliar_id int NOT NULL REFERENCES axuliares(id),
	PRIMARY KEY (area_id, auxiliar_id)
);


/****** Object:  Table areas_camiones    Script Date: 29/04/2016 16:46:00 ******/
CREATE TABLE IF NOT EXISTS areas_camiones(
	area_id int NOT NULL REFERENCES areas(id),
	camion_id int NOT NULL REFERENCES camiones(id),
	PRIMARY KEY (area_id, camion_id)
);


/****** Object:  Table areas_grupos    Script Date: 29/04/2016 16:46:00 ******/
CREATE TABLE IF NOT EXISTS areas_grupos(
	area_id int NOT NULL REFERENCES areas(id),
	grupo_id int NOT NULL REFERENCES grupos(id),
	PRIMARY KEY (area_id, grupo_id)
);


/****** Object:  Table areas_naves    Script Date: 29/04/2016 16:46:00 ******/
CREATE TABLE IF NOT EXISTS areas_naves(
	area_id int NOT NULL REFERENCES areas(id),
	nave_id int NOT NULL REFERENCES naves(id),
	PRIMARY KEY (area_id, nave_id)
);


/****** Object:  Table areas_recintos    Script Date: 29/04/2016 16:46:00 ******/
CREATE TABLE IF NOT EXISTS areas_recintos(
	area_id int NOT NULL REFERENCES areas(id),
	recinto_id int NOT NULL REFERENCES recintos(id),
	PRIMARY KEY (area_id, recinto_id)
);


/****** Object:  Table areas_recursos    Script Date: 29/04/2016 16:46:00 ******/
CREATE TABLE IF NOT EXISTS areas_recursos(
	area_id int NOT NULL REFERENCES areas(id),
	recurso_id int NOT NULL REFERENCES recursos(id),
	PRIMARY KEY (area_id, recurso_id)
);


/****** Object:  Table arte_pesca    Script Date: 29/04/2016 16:46:00 ******/
CREATE TABLE IF NOT EXISTS arte_pesca(
	id int AUTO_INCREMENT PRIMARY KEY,
	nombre varchar(20) NOT NULL,
	recurso_id int NOT NULL REFERENCES recursos(id),
	estado_id int NULL DEFAULT 1 REFERENCES estados(id)
);
/****** Object:  Table auxiliares    Script Date: 29/04/2016 16:46:00 ******/
CREATE TABLE IF NOT EXISTS auxiliares(
	id int AUTO_INCREMENT PRIMARY KEY,
	tipo_entidad smallint NOT NULL,
	division_id int NOT NULL REFERENCES divisiones(id),
	rut varchar(8) NOT NULL,
	verificador char(1) NOT NULL,
	nombre_razon_social varchar(50) NULL,
	nombre varchar(30) NULL,
	apellido_paterno varchar(30) NULL,
	apellido_materno varchar(30) NULL,
	domicilio varchar(200) NOT NULL,
	ciudad_id int NOT NULL REFERENCES ciudades(id),
	estado_id int NULL DEFAULT 1 REFERENCES estados(id),
	chofer boolean NOT NULL,
	armador boolean NOT NULL,
	encargado_planta boolean NOT NULL,
	capitan boolean NOT NULL,
	destinatario boolean NOT NULL,
	representante boolean NOT NULL,
	transporte boolean NOT NULL,
	tcs boolean NOT NULL
);
/****** Object:  Table bodegas    Script Date: 29/04/2016 16:46:00 ******/
CREATE TABLE IF NOT EXISTS bodegas(
	id int AUTO_INCREMENT PRIMARY KEY,
	nave_id int NOT NULL REFERENCES naves(id),
	nro int NOT NULL,
	capacidad decimal(10, 3) NOT NULL
);

/****** Object:  Table calibres    Script Date: 29/04/2016 16:46:00 ******/
CREATE TABLE IF NOT EXISTS calibres(
	id int AUTO_INCREMENT PRIMARY KEY,
	nombre varchar(20) NOT NULL,
	estado_id int NULL DEFAULT 1 REFERENCES estados(id)
);
/****** Object:  Table camiones    Script Date: 29/04/2016 16:46:00 ******/
CREATE TABLE IF NOT EXISTS camiones(
	id int AUTO_INCREMENT PRIMARY KEY,
	patente varchar(8) NOT NULL,
	transporte_id int NOT NULL REFERENCES transportes(id),
	tipo_camion varchar(40) NOT NULL,
	estado_id int NULL DEFAULT 1 REFERENCES estados(id)
);
/****** Object:  Table ciudades    Script Date: 29/04/2016 16:46:00 ******/
CREATE TABLE IF NOT EXISTS ciudades(
	id int AUTO_INCREMENT PRIMARY KEY,
	nombre varchar(40) NOT NULL,
	estado_id int NULL DEFAULT 1 REFERENCES estados(id)
);
/****** Object:  Table controles_calidad    Script Date: 29/04/2016 16:46:00 ******/
CREATE TABLE IF NOT EXISTS controles_calidad(
	id int AUTO_INCREMENT PRIMARY KEY,
	guia_encabezado_id int NOT NULL REFERENCES guia_encabezados(id),
	tratamiento_id int NULL REFERENCES tratamientos(id),
	tvn varchar(7) NULL,
	agua varchar(7) NULL,
	ph varchar(7) NULL,
	c varchar(7) NULL,
	n_litro varchar(7) NULL,
	talla varchar(7) NULL,
	peso varchar(7) NULL,
	moda varchar(7) NULL,
	cms varchar(7) NULL,
	observaciones text NULL,
	estado_id int NULL DEFAULT 3 REFERENCES estados(id),
	creado datetime NULL,
	actualizado datetime NULL,
	cerrado datetime NULL,
	usuario_uid varchar(40) NULL REFERENCES usuarios(uid)
);
/****** Object:  Table descarga_detalles    Script Date: 29/04/2016 16:46:00 ******/
CREATE TABLE IF NOT EXISTS descarga_detalles(
	id int AUTO_INCREMENT PRIMARY KEY,
	descarga_encabezado_id int NOT NULL REFERENCES descarga_encabezados(id),
	especie_id int NOT NULL REFERENCES especies(id),
	zona_pesca int NOT NULL,
	destinatario_id int NULL REFERENCES auxiliares(id),
	tcs_id int NULL REFERENCES auxiliares(id),
	resolucion varchar(15) NULL
);
/****** Object:  Table descarga_detalles_unidades    Script Date: 29/04/2016 16:46:00 ******/
CREATE TABLE IF NOT EXISTS descarga_detalles_unidades(
	descarga_detalle_id int NOT NULL REFERENCES descarga_detalles(id),
	unidad_id int NOT NULL REFERENCES unidades(id),
	cantidad decimal(10, 6) NULL,
	PRIMARY KEY (descarga_detalle_id, unidad_id)
);


/****** Object:  Table descarga_encabezados    Script Date: 29/04/2016 16:46:00 ******/
CREATE TABLE IF NOT EXISTS descarga_encabezados(
	id int AUTO_INCREMENT PRIMARY KEY,
	codigo_descarga varchar(10) NOT NULL,
	tipo_descarga_id int NOT NULL REFERENCES tipo_descargas(id),
	movimiento_id int NOT NULL REFERENCES movimientos(id),
	fecha_pesca datetime NULL,
	inicio_desembarque datetime NOT NULL,
	termino_desembarque datetime NOT NULL,
	recalada_id int NOT NULL REFERENCES recaladas(id),
	sin_pesca boolean NULL,
	observaciones text NULL,
	estado_id int NULL DEFAULT 3 REFERENCES estados(id),
	creado datetime NOT NULL,
	actualizado datetime NOT NULL,
	cerrado datetime NULL,
	usuario_uid varchar(40) NULL REFERENCES usuarios(uid),
	latitud varchar(50) NULL,
	longitud varchar(50) NULL,
	fecha_primer_lance datetime NULL,
	zona_primer_lance int NULL
);
/****** Object:  Table divisiones    Script Date: 29/04/2016 16:46:00 ******/
CREATE TABLE IF NOT EXISTS divisiones(
	id int AUTO_INCREMENT PRIMARY KEY,
	nombre varchar(40) NOT NULL,
	estado_id int NULL DEFAULT 1 REFERENCES estados(id)
);
/****** Object:  Table especies    Script Date: 29/04/2016 16:46:00 ******/
CREATE TABLE IF NOT EXISTS especies(
	id int AUTO_INCREMENT PRIMARY KEY,
	nombre varchar(40) NOT NULL,
	ltp boolean NOT NULL,
	estado_id int NULL DEFAULT 1 REFERENCES estados(id)
);
/****** Object:  Table especies_recursos    Script Date: 29/04/2016 16:46:00 ******/
CREATE TABLE IF NOT EXISTS especies_recursos(
	especie_id int NOT NULL REFERENCES especies(id),
	recurso_id int NOT NULL REFERENCES recursos(id),
	PRIMARY KEY(especie_id, recurso_id)
);


/****** Object:  Table estados    Script Date: 29/04/2016 16:46:00 ******/
CREATE TABLE IF NOT EXISTS estados(
	id int AUTO_INCREMENT PRIMARY KEY,
	nombre varchar(20) NOT NULL,
	paridad int NOT NULL
);
/****** Object:  Table folio_detalles    Script Date: 29/04/2016 16:46:00 ******/
CREATE TABLE IF NOT EXISTS folio_detalles(
	id int AUTO_INCREMENT PRIMARY KEY,
	folio_encabezado_id int NOT NULL REFERENCES folio_encabezados(id),
	descarga_detalle_id int NOT NULL REFERENCES descarga_detalles(id),
	secuencial int NOT NULL,
	especie_id int NOT NULL REFERENCES especies(id),
	fecha_produccion date NOT NULL
);

/****** Object:  Table folio_detalles_lote_encabezados    Script Date: 29/04/2016 16:46:00 ******/
CREATE TABLE IF NOT EXISTS folio_detalles_lote_encabezados(
	folio_detalle_id int NOT NULL REFERENCES folio_detalles(id),
	lote_encabezado_id int NOT NULL REFERENCES lote_encabezados(id),
	PRIMARY KEY (folio_detalle_id, lote_encabezado_id)
);


/****** Object:  Table folio_detalles_unidades    Script Date: 29/04/2016 16:46:00 ******/
CREATE TABLE IF NOT EXISTS folio_detalles_unidades(
	folio_detalle_id int NOT NULL REFERENCES folio_detalles(id),
	unidad_id int NOT NULL REFERENCES unidades(id),
	cantidad decimal(10, 6) NULL,
	PRIMARY KEY (folio_detalle_id, unidad_id)
);


/****** Object:  Table folio_encabezados    Script Date: 29/04/2016 16:46:00 ******/
CREATE TABLE IF NOT EXISTS folio_encabezados(
	id int AUTO_INCREMENT PRIMARY KEY,
	recurso_id int NOT NULL REFERENCES recursos(id),
	division_id int NOT NULL REFERENCES divisiones(id),
	nro_folio varchar(6) NOT NULL,
	calibre int NOT NULL,
	fecha_recepcion date NOT NULL,
	observaciones text NULL,
	estado_id int NULL DEFAULT 3 REFERENCES estados(id),
	creado datetime NOT NULL,
	actualizado datetime NOT NULL,
	cerrado datetime NULL,
	usuario_uid varchar(40) NOT NULL REFERENCES usuarios(uid)
);
/****** Object:  Table grupos    Script Date: 29/04/2016 16:46:00 ******/
CREATE TABLE IF NOT EXISTS grupos(
	id int AUTO_INCREMENT PRIMARY KEY,
	nombre varchar(40) NOT NULL,
	division_id int NOT NULL REFERENCES divisiones(id),
	estado_id int NULL DEFAULT 1 REFERENCES estados(id)
);
/****** Object:  Table grupos_privilegios    Script Date: 29/04/2016 16:46:00 ******/
CREATE TABLE IF NOT EXISTS grupos_privilegios(
	grupo_id int NOT NULL REFERENCES grupos(id),
	privilegio_id int NOT NULL REFERENCES privilegios(id),
	PRIMARY KEY (grupo_id, privilegio_id)
);


/****** Object:  Table grupos_usuarios    Script Date: 29/04/2016 16:46:00 ******/
CREATE TABLE IF NOT EXISTS grupos_usuarios(
	grupo_id int NOT NULL REFERENCES grupos(id),
	usuario_uid varchar(40) NOT NULL REFERENCES usuarios(uid),
	PRIMARY KEY (grupo_id, usuario_uid)
);

/****** Object:  Table guia_detalles    Script Date: 29/04/2016 16:46:00 ******/
CREATE TABLE IF NOT EXISTS guia_detalles(
	id int AUTO_INCREMENT PRIMARY KEY,
	guia_encabezado_id int NOT NULL REFERENCES guia_encabezados(id),
	descarga_detalle_id int NOT NULL REFERENCES descarga_detalles(id),
	especie_id int NOT NULL REFERENCES especies(id)
);

/****** Object:  Table guia_detalles_unidades    Script Date: 29/04/2016 16:46:00 ******/
CREATE TABLE IF NOT EXISTS guia_detalles_unidades(
	guia_detalle_id int NOT NULL REFERENCES guia_detalles(id),
	unidad_id int NOT NULL REFERENCES unidades(id),
	cantidad decimal(10, 6) NULL,
	PRIMARY KEY (guia_detalle_id, unidad_id)
);


/****** Object:  Table guia_encabezados    Script Date: 29/04/2016 16:46:00 ******/
CREATE TABLE IF NOT EXISTS guia_encabezados(
	id int AUTO_INCREMENT PRIMARY KEY,
	recurso_id int NOT NULL REFERENCES recursos(id),
	division_id int NOT NULL REFERENCES divisiones(id),
	`virtual` boolean NULL,
	nro_guia varchar(50) NULL,
	movimiento_id int NOT NULL REFERENCES movimientos(id),
	origen_id int NOT NULL REFERENCES recintos(id),
	destino_id int NOT NULL REFERENCES recintos(id),
	camion_id int NULL REFERENCES camiones(id),
	chofer_id int NULL REFERENCES auxiliares(id),
	fecha_salida datetime NOT NULL,
	fecha_recepcion datetime NULL,
	observaciones text NULL,
	estado_id int NULL DEFAULT 3 REFERENCES estados(id),
	creado datetime NOT NULL,
	actualizado datetime NOT NULL,
	cerrado datetime NULL,
	usuario_uid varchar(40) NOT NULL REFERENCES usuarios(uid)
);
/****** Object:  Table lote_detalles    Script Date: 29/04/2016 16:46:00 ******/
CREATE TABLE IF NOT EXISTS lote_detalles(
	id int AUTO_INCREMENT PRIMARY KEY,
	lote_encabezado_id int NOT NULL REFERENCES lote_encabezados(id),
	pallet varchar(30) NULL,
	calibre_id int NOT NULL REFERENCES calibres(id)
);
/****** Object:  Table lote_detalles_unidades    Script Date: 29/04/2016 16:46:00 ******/
CREATE TABLE IF NOT EXISTS lote_detalles_unidades(
	lote_detalle_id int NOT NULL REFERENCES lote_detalles(id),
	unidad_id int NOT NULL REFERENCES unidades(id),
	cantidad numeric(10, 3) NULL,
	PRIMARY KEY (lote_detalle_id, unidad_id)
);


/****** Object:  Table lote_encabezados    Script Date: 29/04/2016 16:46:00 ******/
CREATE TABLE IF NOT EXISTS lote_encabezados(
	id int AUTO_INCREMENT PRIMARY KEY,
	recurso_id int NOT NULL REFERENCES recursos(id),
	division_id int NOT NULL REFERENCES divisiones(id),
	lote varchar(15) NOT NULL,
	sub_codigo char(1) NOT NULL,
	observaciones text NULL,
	estado_id int NULL DEFAULT 3 REFERENCES estados(id),
	creado datetime NOT NULL,
	actualizado datetime NOT NULL,
	cerrado datetime NULL,
	usuario_uid varchar(40) NOT NULL REFERENCES usuarios(uid)
);

/****** Object:  Table mareas1    Script Date: 29/04/2016 16:46:00 ******/
CREATE TABLE IF NOT EXISTS mareas(
	id int AUTO_INCREMENT PRIMARY KEY,
	division_id int NOT NULL REFERENCES divisiones(id),
	recurso_id int NOT NULL REFERENCES recursos(id),
	nave_id int NOT NULL REFERENCES naves(id),
	arte_pesca_id int NOT NULL REFERENCES arte_pesca(id),
	capitan_id int NOT NULL REFERENCES auxiliares(id),
	puerto_id int NOT NULL REFERENCES puertos(id),
	fecha_zarpe datetime NOT NULL,
	observaciones text NULL,
	estado_id int NULL DEFAULT 3 REFERENCES estados(id),
	creado datetime NULL,
	actualizado datetime NULL,
	cerrado datetime NULL,
	usuario_uid varchar(40) NULL REFERENCES usuarios(uid)
);
/****** Object:  Table movimientos    Script Date: 29/04/2016 16:46:00 ******/
CREATE TABLE IF NOT EXISTS movimientos(
	id int AUTO_INCREMENT PRIMARY KEY,
	nombre varchar(20) NOT NULL,
	tipo smallint NOT NULL,
	estado_id int NULL REFERENCES estados(id)
);
/****** Object:  Table naves    Script Date: 29/04/2016 16:46:00 ******/
CREATE TABLE IF NOT EXISTS naves(
	id int AUTO_INCREMENT PRIMARY KEY,
	division_id int NOT NULL REFERENCES divisiones(id),
	matricula varchar(20) NOT NULL,
	regimen_id int NOT NULL REFERENCES regimenes(id),
	nombre varchar(40) NOT NULL,
	zona_operacion_id int NULL REFERENCES zona_operaciones(id),
	registro_pesca varchar(6) NULL,
	senal_distintiva varchar(10) NULL,
	armador_id int NULL REFERENCES auxiliares(id),
	representante_id int NULL REFERENCES axuliares(id),
	capitan_id int NULL REFERENCES auxiliares(id),
	estado_id int NULL DEFAULT 1 REFERENCES estados(id)
);
/****** Object:  Table naves_recursos    Script Date: 29/04/2016 16:46:00 ******/
CREATE TABLE IF NOT EXISTS naves_recursos(
	nave_id int NOT NULL REFERENCES naves(id),
	recurso_id int NOT NULL REFERENCES recursos(id),
	PRIMARY KEY (nave_id, recurso_id)
);


/****** Object:  Table naves_unidades    Script Date: 29/04/2016 16:46:00 ******/
CREATE TABLE IF NOT EXISTS naves_unidades(
	nave_id int NOT NULL REFERENCES naves(id),
	unidad_id int NOT NULL REFERENCES unidades(id),
	capacidad decimal(10, 6) NOT NULL,
	PRIMARY KEY (nave_id, unidad_id)
);


/****** Object:  Table plantas    Script Date: 29/04/2016 16:46:00 ******/
CREATE TABLE IF NOT EXISTS plantas(
	id int PRIMARY KEY,
	codigo int NOT NULL,
	seccion char(1) NOT NULL
);
/****** Object:  Table pontones    Script Date: 29/04/2016 16:46:00 ******/
CREATE TABLE IF NOT EXISTS pontones(
	id int PRIMARY KEY,
	puerto_id int NOT NULL
);

/****** Object:  Table privilegios    Script Date: 29/04/2016 16:46:00 ******/
CREATE TABLE IF NOT EXISTS privilegios(
	id int AUTO_INCREMENT PRIMARY KEY,
	nombre varchar(50) NOT NULL
);
/****** Object:  Table puertos    Script Date: 29/04/2016 16:46:00 ******/
CREATE TABLE IF NOT EXISTS puertos(
	id int PRIMARY KEY
);

/****** Object:  Table recaladas    Script Date: 29/04/2016 16:46:00 ******/
CREATE TABLE IF NOT EXISTS recaladas(
	id int AUTO_INCREMENT PRIMARY KEY,
	marea_id int NOT NULL REFERENCES mareas(id),
	fecha_recalada datetime NOT NULL,
	ponton_id int NOT NULL REFERENCES pontones(id),
	observaciones text NULL,
	estado_id int NULL DEFAULT 3 REFERENCES estados(id),
	creado datetime NULL,
	actualizado datetime NULL,
	cerrado datetime NULL,
	usuario_uid varchar(40) NULL REFERENCES usuarios(uid)
);
/****** Object:  Table recintos    Script Date: 29/04/2016 16:46:00 ******/
CREATE TABLE IF NOT EXISTS recintos(
	id int AUTO_INCREMENT PRIMARY KEY,
	nombre varchar(40) NOT NULL,
	division_id int NOT NULL REFERENCES divisiones(id),
	estado_id int NULL DEFAULT 1 REFERENCES estados(id)
);
/****** Object:  Table recursos    Script Date: 29/04/2016 16:46:00 ******/
CREATE TABLE IF NOT EXISTS recursos(
	id int AUTO_INCREMENT PRIMARY KEY,
	nombre varchar(40) NOT NULL,
	unidad_principal_id int NOT NULL REFERENCES unidades(id),
	estado_id int NULL DEFAULT 1 REFERENCES estados(id)
);
/****** Object:  Table recursos_unidades    Script Date: 29/04/2016 16:46:00 ******/
CREATE TABLE IF NOT EXISTS recursos_unidades(
	recurso_id int NOT NULL REFERENCES recursos(id),
	unidad_id int NOT NULL REFERENCES unidades(id),
	PRIMARY KEY (recurso_id, unidad_id)
);

/****** Object:  Table regimenes    Script Date: 29/04/2016 16:46:00 ******/
CREATE TABLE IF NOT EXISTS regimenes(
	id int AUTO_INCREMENT PRIMARY KEY,
	nombre varchar(30) NOT NULL
);
/****** Object:  Table tipo_descargas    Script Date: 29/04/2016 16:46:00 ******/
CREATE TABLE IF NOT EXISTS tipo_descargas(
	id int AUTO_INCREMENT PRIMARY KEY,
	nombre varchar(30) NOT NULL,
	estado_id int NULL DEFAULT 1 REFERENCES estados(id)
);
/****** Object:  Table tratamientos    Script Date: 29/04/2016 16:46:00 ******/
CREATE TABLE IF NOT EXISTS tratamientos(
	id int AUTO_INCREMENT PRIMARY KEY,
	nombre varchar(30) NOT NULL,
	estado_id int NULL DEFAULT 1 REFERENCES estados(id)
);
/****** Object:  Table unidades    Script Date: 29/04/2016 16:46:00 ******/
CREATE TABLE IF NOT EXISTS unidades(
	id int AUTO_INCREMENT PRIMARY KEY,
	nombre varchar(40) NOT NULL,
	abreviacion varchar(6) NULL,
	`precision` int NOT NULL,
	estado_id int DEFAULT 1 REFERENCES estados(id)
);
/****** Object:  Table usuarios    Script Date: 29/04/2016 16:46:00 ******/
CREATE TABLE IF NOT EXISTS usuarios(
	uid varchar(40) NOT NULL PRIMARY KEY,
	nombre varchar(50) NOT NULL,
	change_log boolean NOT NULL,
	estado_id int NULL DEFAULT 1 REFERENCES estados(id),
	creado datetime NULL,
	actualizado datetime NULL
);
/****** Object:  Table zona_operaciones    Script Date: 29/04/2016 16:46:00 ******/
CREATE TABLE IF NOT EXISTS zona_operaciones(
	id int AUTO_INCREMENT PRIMARY KEY,
	nombre varchar(30) NOT NULL
);
/*************************************************
**************************************************
---- VISTAS ----
**************************************************
**************************************************/
/****** Object:  View guias_sin_calidad    Script Date: 29/04/2016 16:46:00 ******/
CREATE VIEW guias_sin_calidad
AS
SELECT     id, nro_guia, movimiento_id, division_id, recurso_id, origen_id, destino_id, camion_id, chofer_id, fecha_salida, fecha_recepcion, observaciones, estado_id, creado, actualizado, cerrado,
                      usuario_uid, "virtual"
FROM         guia_encabezados AS GuiaEncabezados
WHERE     (id NOT IN
                          (SELECT     guia_encabezado_id
                            FROM          controles_calidad AS ControlesCalidad)) AND (origen_id <> 28) AND (YEAR(fecha_recepcion) > 2015) AND ("virtual" <> 1)


/****** Object:  View guias_con_calidad    Script Date: 29/04/2016 16:46:00 ******/

CREATE VIEW guias_con_calidad
AS
SELECT     id, nro_guia, movimiento_id, division_id, recurso_id, origen_id, destino_id, camion_id, chofer_id, fecha_salida, fecha_recepcion, observaciones, estado_id, creado,
                      actualizado, cerrado, usuario_uid, "virtual"
FROM         guia_encabezados AS GuiaEncabezados
WHERE     (id NOT IN
                          (SELECT     id
                            FROM          guias_sin_calidad))


/****** Object:  View descargas_disponibles    Script Date: 29/04/2016 16:46:00 ******/
CREATE OR REPLACE ALGORITHM = TEMPTABLE VIEW descargas_disponibles
AS
SELECT *
FROM   descarga_encabezados DE
WHERE  DE.inicio_desembarque >= '01-01-2016' AND DE.id IN
	(SELECT DISTINCT id
	  FROM  (SELECT     DD.descarga_encabezado_id id, ROUND((DDU.cantidad - SUM(GDU.cantidad)), 4) disponible
	                           FROM          descarga_detalles DD, descarga_detalles_unidades DDU, guia_detalles GD, guia_detalles_unidades GDU
	                           WHERE      GD.descarga_detalle_id = DD.id AND DDU.unidad_id = GDU.unidad_id AND GDU.guia_detalle_id = GD.id AND DDU.descarga_detalle_id = DD.id
	                           GROUP BY DD.descarga_encabezado_id, DD.id, DDU.cantidad) AS DDis
	    WHERE     DDis.disponible > 0
	UNION
	SELECT DISTINCT DD.descarga_encabezado_id id
	 FROM            descarga_detalles DD
	 WHERE           DD.id NOT IN (SELECT GD.descarga_detalle_id id
	                               FROM guia_detalles GD)
UNION
SELECT DISTINCT DD.descarga_encabezado_id id
 FROM         descarga_detalles DD, guia_detalles GD, guia_encabezados GE
 WHERE     GE.estado_id = 3 AND GE.id = GD.guia_encabezado_id AND GD.descarga_detalle_id = DD.id)


/****** Object:  View descargas_disponibles_folios    Script Date: 29/04/2016 16:46:00 ******/
CREATE OR REPLACE ALGORITHM = TEMPTABLE VIEW descargas_disponibles_folios
AS
SELECT     DE.*
FROM         descarga_encabezados DE INNER JOIN
                      recaladas R ON R.id = DE.recalada_id INNER JOIN
                      mareas M ON M.id = R.marea_id
WHERE     DE.inicio_desembarque >= '01-01-2016' AND M.recurso_id = 2 AND DE.id IN
                          (SELECT DISTINCT id
                              FROM         (SELECT     DD.descarga_encabezado_id id, Round((DDU.cantidad - Sum(FDU.cantidad)), 4) disponible
                                                     FROM          descarga_detalles DD INNER JOIN
                                                                            descarga_detalles_unidades DDU ON DD.id = DDU.descarga_detalle_id INNER JOIN
                                                                            folio_detalles FD ON DD.id = FD.descarga_detalle_id INNER JOIN
                                                                            folio_detalles_unidades FDU ON FD.id = FDU.folio_detalle_id
                                                     WHERE      DDU.unidad_id = FDU.unidad_id AND DD.destinatario_id = 95
                                                     GROUP BY DD.descarga_encabezado_id, DD.id, DDU.cantidad) AS DDis
                              WHERE     DDis.disponible > 0
                      UNION
                      SELECT DISTINCT DD.descarga_encabezado_id id
                       FROM         descarga_detalles DD
                       WHERE     DD.id NOT IN
                                                  (SELECT     FD.descarga_detalle_id id
                                                    FROM          folio_detalles FD) AND DD.destinatario_id = 95
UNION
SELECT DISTINCT DD.descarga_encabezado_id id
 FROM         descarga_detalles DD INNER JOIN
                        folio_detalles FD ON FD.descarga_detalle_id = DD.id INNER JOIN
                        folio_encabezados FE ON FE.id = FD.folio_encabezado_id
 WHERE     FE.estado_id = 3)
