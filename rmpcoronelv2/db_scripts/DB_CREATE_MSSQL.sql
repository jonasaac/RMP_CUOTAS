USE RMPCORONELv2b;

CREATE TABLE estados (
    id int IDENTITY(1,1) PRIMARY KEY,
    nombre VARCHAR(20) NOT NULL,
    paridad int NOT NULL
);

INSERT INTO estados (nombre, paridad) VALUES ('ACTIVO', 1), ('INACTIVO', 1), ('ABIERTO', 2), ('CERRADO', 2);

CREATE TABLE divisiones (
    id int IDENTITY(1,1) PRIMARY KEY,
    nombre VARCHAR(40) NOT NULL,
    estado_id int DEFAULT 1 REFERENCES estados(id)
);

INSERT INTO divisiones (nombre, estado_id) VALUES ('CAMANCHACA PESCA SUR', 1);

CREATE TABLE recursos (
    id int IDENTITY(1,1) PRIMARY KEY,
    nombre VARCHAR(40) NOT NULL,
    estado_id int DEFAULT 1 REFERENCES estados(id)
);

INSERT INTO recursos (nombre, estado_id) VALUES ('SARDINA', 1), ('JUREL', 1), ('LANGOSTINO', 1);

CREATE TABLE usuarios (
    uid VARCHAR(40) PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    estado_id int DEFAULT 1 REFERENCES estados(id),
    creado DATETIME NULL,
    actualizado DATETIME NULL
);

INSERT INTO usuarios (uid, nombre, estado_id) VALUES ('admin', 'ADMINISTRADOR', 1);

CREATE TABLE grupos (
    id int IDENTITY(1,1) PRIMARY KEY,
    nombre VARCHAR(40) NOT NULL,
    division_id int REFERENCES divisiones(id) NOT NULL,
    recurso_id int REFERENCES recursos(id) NOT NULL,
    estado_id int DEFAULT 1 REFERENCES estados(id)
);

INSERT INTO grupos (nombre, division_id, recurso_id, estado_id) VALUES ('ADMIN SARDINAS', 1, 1, 1);

CREATE TABLE grupos_usuarios (
    grupo_id int FOREIGN KEY REFERENCES grupos(id),
    usuario_uid VARCHAR(40) FOREIGN KEY REFERENCES usuarios(uid),
    PRIMARY KEY (grupo_id, usuario_uid)
);

INSERT INTO grupos_usuarios (grupo_id, usuario_uid) VALUES (1, 'admin');

CREATE TABLE privilegios (
    id int IDENTITY(1,1) PRIMARY KEY,
    nombre varchar(20) NOT NULL
);

INSERT INTO privilegios (nombre) VALUES ('all'), ('admin'), ('marea_view'), ('marea_add'), ('marea_delete'), ('marea_update'), ('marea_lock'), ('marea_ulock'),
                                                            ('recalada_view'), ('recalada_add'), ('recalada_delete'), ('recalada_update'), ('recalada_lock'), ('recalada_ulock'),
                                                            ('descarga_view'), ('descarga_add'), ('descarga_delete'), ('descarga_update'), ('descarga_lock'), ('descarga_ulock'),
                                                            ('guia_view'), ('guia_add'), ('guia_delete'), ('guia_update'), ('guia_lock'), ('guia_ulock'),
                                                            ('folio_view'), ('folio_add'), ('folio_delete'), ('folio_update'), ('folio_lock'), ('folio_ulock'),
                                                            ('calidad_view'), ('calidad_add'), ('calidad_delete'), ('calidad_update'), ('calidad_lock'), ('calidad_ulock');

CREATE TABLE grupos_privilegios (
    grupo_id int REFERENCES grupos(id),
    privilegio_id int REFERENCES privilegios(id),
    PRIMARY KEY (grupo_id, privilegio_id)
);

INSERT INTO grupos_privilegios (grupo_id, privilegio_id) VALUES (1, 1), (1, 2);

CREATE TABLE especies (
    id int IDENTITY(1,1) PRIMARY KEY,
    nombre VARCHAR(40) NOT NULL,
    ltp bit DEFAULT 0 NOT NULL,
    estado_id int DEFAULT 1 REFERENCES estados(id)
);

CREATE TABLE ciudades (
    id int IDENTITY(1,1) PRIMARY KEY,
    nombre VARCHAR(40) NOT NULL,
    estado_id int DEFAULT 1 REFERENCES estados(id)
);

CREATE TABLE auxiliares (
    id int IDENTITY(1,1) PRIMARY KEY,
    tipo_entidad SMALLINT NOT NULL,
    division_id int FOREIGN KEY REFERENCES divisiones(id) NOT NULL,
    rut VARCHAR(8) NOT NULL,
    verificador CHAR(1) NOT NULL,
    nombre_razon_social VARCHAR(50) NULL,
    nombre VARCHAR(30) NULL,
    apellido_paterno VARCHAR(30) NULL,
    apellido_materno VARCHAR(30) NULL,
    domicilio VARCHAR(200) NOT NULL,
    ciudad_id int NOT NULL FOREIGN KEY REFERENCES ciudades(id),
    estado_id int DEFAULT 1 FOREIGN KEY REFERENCES estados(id),
    chofer BIT NOT NULL,
    armador BIT NOT NULL,
    encargado_planta BIT NOT NULL,
    capitan BIT NOT NULL,
    destinatario BIT NOT NULL,
    representante BIT NOT NULL,
    transporte BIT NOT NULL,
    tcs BIT NOT NULL,
    sindicato BIT NOT NULL,
    titular_licencia BIT NOT NULL

);

CREATE TABLE recintos (
    id int IDENTITY(1,1) PRIMARY KEY,
    nombre varchar(40) NOT NULL,
    division_id int FOREIGN KEY REFERENCES divisiones(id) NOT NULL,
    estado_id int DEFAULT 1 REFERENCES estados(id)
);

CREATE TABLE puertos (
    id int PRIMARY KEY REFERENCES recintos(id)
);

CREATE TABLE pontones (
    id int PRIMARY KEY REFERENCES recintos(id),
    puerto_id int NOT NULL REFERENCES puertos(id)
);

CREATE TABLE plantas (
    id int PRIMARY KEY REFERENCES recintos(id),
    codigo int NOT NULL,
    seccion CHAR(1) DEFAULT 'A' NOT NULL,
    UNIQUE (codigo, seccion)
);

CREATE TABLE unidades (
    id int IDENTITY(1,1) PRIMARY KEY,
    nombre VARCHAR(40) NOT NULL,
    abreviacion VARCHAR(4) NULL,
    estado_id int DEFAULT 1 REFERENCES estados(id)
);

INSERT INTO unidades (nombre, abreviacion, estado_id) VALUES ('TONELADAS', 'TON', 1), ('CAJAS', 'CJS', 1);

CREATE TABLE recursos_unidades (
    unidad_id int REFERENCES unidades(id),
    recurso_id int REFERENCES recursos(id),
    PRIMARY KEY (unidad_id, recurso_id)
);

INSERT INTO recursos_unidades (unidad_id, recurso_id) VALUES (1, 1), -- sardinas con toneladas
(1,2), -- Jureles con toneladas
(1,3), -- Langostinos con toneladas
(2,3); -- Langostinos con Cajas

CREATE TABLE regimenes (
    id int IDENTITY PRIMARY KEY,
    nombre varchar(30) NOT NULL
);

INSERT INTO regimenes (nombre) VALUES ('INDUSTRIAL'), ('ARTESANAL');

CREATE TABLE zona_operaciones (
    id INT IDENTITY(1,1) PRIMARY KEY,
    nombre VARCHAR(30) NOT NULL
);

INSERT INTO zona_operaciones (nombre) VALUES ('VALDIVIA'), ('CORONEL'), ('TALCAHUANO'), ('SAN ANTONIO');

CREATE TABLE naves (
    id int IDENTITY(1,1) PRIMARY KEY,
    matricula VARCHAR(20) NOT NULL,
    regimen_id int FOREIGN KEY REFERENCES regimenes(id) NOT NULL,
    division_id int FOREIGN KEY REFERENCES divisiones(id) NOT NULL,
    nombre VARCHAR(40) NOT NULL,
    zona_operacion_id INT FOREIGN KEY REFERENCES zona_operaciones(id),
    registro_pesca VARCHAR(6) NULL,
    senal_distintiva VARCHAR(10) NULL,
    armador_id int FOREIGN KEY REFERENCES auxiliares(id),
    representante_id int FOREIGN KEY REFERENCES auxiliares(id),
    capitan_id int FOREIGN KEY REFERENCES auxiliares(id),
    estado_id int DEFAULT 1 REFERENCES estados(id)
);

CREATE TABLE bodegas (
    id int IDENTITY(1,1) PRIMARY KEY,
    nave_id int FOREIGN KEY REFERENCES naves(id),
    nro int NOT NULL,
    capacidad DECIMAL(10,3) NOT NULL -- en metros cubicos
);

CREATE TABLE naves_recursos (
    nave_id int FOREIGN KEY REFERENCES naves(id),
    recurso_id int FOREIGN KEY REFERENCES recursos(id),
    PRIMARY KEY (nave_id, recurso_id)
);

CREATE TABLE naves_unidades (
    unidad_id int REFERENCES unidades(id),
    nave_id int REFERENCES naves(id),
    PRIMARY KEY (unidad_id, nave_id),
    capacidad DECIMAL(10,3) NOT NULL CHECK (capacidad > 0)
);

CREATE TABLE mareas (
    id int IDENTITY(1,1) PRIMARY KEY,
    division_id int REFERENCES divisiones(id) NOT NULL,
    recurso_id int REFERENCES recursos(id) NOT NULL,
    nave_id int REFERENCES naves(id),
    fecha_zarpe DATETIME NOT NULL,
    capitan_id int FOREIGN KEY REFERENCES auxiliares(id),
    puerto_id int FOREIGN KEY REFERENCES puertos(id),
    estado_id int DEFAULT 1 REFERENCES estados(id),
    observaciones TEXT NULL,
    creado DATETIME NULL,
    actualizado DATETIME NULL,
    cerrado DATETIME NULL,
    usuario_uid VARCHAR(40) FOREIGN KEY REFERENCES usuarios(uid)
);

CREATE TABLE recaladas (
    id int IDENTITY(1,1) PRIMARY KEY,
    fecha DATETIME NOT NULL,
    marea_id int FOREIGN KEY REFERENCES mareas(id),
    ponton_id int REFERENCES pontones(id),
    estado_id int DEFAULT 1 REFERENCES estados(id),
    observaciones TEXT NULL,
    creado DATETIME NULL,
    actualizado DATETIME NULL,
    cerrado DATETIME NULL,
    usuario_uid varchar(40) REFERENCES usuarios(uid)
);

CREATE TABLE arte_pesca (
    id int IDENTITY(1,1) PRIMARY KEY,
    nombre VARCHAR(20) NOT NULL,
    recurso_id int FOREIGN KEY REFERENCES recursos(id),
    estado_id int DEFAULT 1 REFERENCES estados(id)
);

INSERT INTO arte_pesca (nombre, recurso_id, estado_id) VALUES ('ARRASTRE LANGOSTINOS', 3, 1), ('CERCO SARDINAS', 1, 1);

CREATE TABLE movimientos (
    id int IDENTITY(1,1) PRIMARY KEY,
    nombre varchar(20) NOT NULL,
    tipo SMALLINT NOT NULL
);

INSERT INTO movimientos (nombre, tipo) VALUES ('COMPRA', 1), ('CAPTURA', 1), ('VENTA', 2), ('TRASLADO', 2);

CREATE TABLE tipo_descargas (
    id int IDENTITY(1,1) PRIMARY KEY,
    nombre varchar(30) NOT NULL
);

INSERT INTO tipo_descargas (nombre) VALUES ('INDUSTRIAL'), ('ARTESANAL'), ('RECIBO');

CREATE TABLE descarga_encabezados (
    id int IDENTITY(1,1) PRIMARY KEY,
    codigo_descarga VARCHAR(10) NULL,
    tipo_descarga_id int FOREIGN KEY REFERENCES tipo_descargas(id),
    movimiento_id int FOREIGN KEY REFERENCES movimientos(id),
    arte_pesca_id int FOREIGN KEY REFERENCES arte_pesca(id),
    inicio_desembarque DATETIME NULL,
    termino_desembarque DATETIME NOT NULL,
    fecha_pesca DATETIME NOT NULL,
    estado_id int DEFAULT 1 REFERENCES estados(id),
    recalada_id int NOT NULL REFERENCES recaladas(id),
    resolucion int NULL,
    observaciones TEXT NULL,
    sin_pesca BIT NULL,
    creado DATETIME NULL,
    actualizado DATETIME NULL,
    cerrado DATETIME NULL,
    usuario_uid varchar(40) REFERENCES usuarios(uid)
);

CREATE TABLE descarga_detalles (
    id int IDENTITY(1,1) PRIMARY KEY,
    descarga_encabezado_id int FOREIGN KEY REFERENCES descarga_encabezados(id),
    especie_id int FOREIGN KEY REFERENCES especies(id),
    objetivo BIT NOT NULL,
    zona_pesca int NOT NULL,
    destinatario_id int FOREIGN KEY REFERENCES auxiliares(id)
);

CREATE TABLE descarga_detalles_unidades (
    descarga_detalle_id int NOT NULL FOREIGN KEY REFERENCES descarga_detalles(id),
    unidad_id int NOT NULL FOREIGN KEY REFERENCES unidades(id),
    cantidad numeric(10, 3) NOT NULL CHECK(cantidad > 0),
    PRIMARY KEY(descarga_detalle_id, unidad_id)
);

CREATE TABLE transportes (
    id int IDENTITY(1,1) PRIMARY KEY,
    nombre VARCHAR(40) NOT NULL,
    estado_id int DEFAULT 1 REFERENCES estados(id)
);

CREATE TABLE camiones (
    id int IDENTITY(1,1) PRIMARY KEY,
    patente VARCHAR(8) NOT NULL,
    transporte_id int FOREIGN KEY REFERENCES transportes(id),
    tipo_camion VARCHAR(40) NOT NULL,
    estado_id int DEFAULT 1 REFERENCES estados(id)
);

CREATE TABLE guia_encabezados (
    id int IDENTITY(1,1) PRIMARY KEY,
    virtual BIT NOT NULL,
    nro_guia int NOT NULL,
    movimiento_id int REFERENCES movimientos(id),
    division_id int REFERENCES divisiones(id) NOT NULL,
    recurso_id int REFERENCES recursos(id) NOT NULL,
    origen_id int FOREIGN KEY REFERENCES recintos(id),
    destino_id int FOREIGN KEY REFERENCES recintos(id),
    camion_id int FOREIGN KEY REFERENCES camiones(id),
    chofer_id int FOREIGN KEY REFERENCES auxiliares(id),
    fecha_salida DATETIME NOT NULL,
    fecha_recepcion DATETIME NULL,
    observaciones TEXT NULL,
    estado_id int DEFAULT 1 REFERENCES estados(id),
    creado DATETIME NULL,
    actualizado DATETIME NULL,
    cerrado DATETIME NULL,
    usuario_uid VARCHAR(40) REFERENCES usuarios(uid)
);

CREATE TABLE guia_detalles (
    id int IDENTITY(1,1) PRIMARY KEY,
    guia_encabezado_id int NOT NULL,
    descarga_detalle_id int REFERENCES descarga_detalles(id),
    especie_id int FOREIGN KEY REFERENCES especies(id),
);

CREATE TABLE guia_detalles_unidades (
    guia_detalle_id int NOT NULL FOREIGN KEY REFERENCES guia_detalles(id),
    unidad_id int NOT NULL FOREIGN KEY REFERENCES unidades(id),
    cantidad numeric(10,3) NOT NULL CHECK(cantidad > 0),
    PRIMARY KEY (guia_detalle_id, unidad_id)
);

CREATE TABLE descargas_guias (
    descarga_detalle_id int FOREIGN KEY REFERENCES descarga_detalles(id),
    guia_detalle_id int FOREIGN KEY REFERENCES guia_detalles(id),
    PRIMARY KEY (descarga_detalle_id, guia_detalle_id)
);

CREATE TABLE tratamientos (
    id int IDENTITY(1,1) PRIMARY KEY,
    nombre VARCHAR(30) NOT NULL,
    estado_id int DEFAULT 1 FOREIGN KEY REFERENCES estados(id)
);

-- TODO: INSERT INTO tratamientos (nombre) VALUES (...);

CREATE TABLE controles_calidad (
    id int IDENTITY(1,1) PRIMARY KEY,
    guia_encabezado_id int FOREIGN KEY REFERENCES guia_encabezados(id),
    tratamiento_id int FOREIGN KEY REFERENCES tratamientos(id),
    TVN DECIMAL(10, 4),
    agua DECIMAL(10,4),
    ph SMALLINT,
    c DECIMAL(10,4),
    n_litro SMALLINT,
    talla SMALLINT,
    peso SMALLINT,
    moda SMALLINT,
    cms SMALLINT,
    observaciones TEXT NULL,
    estado_id INT NOT NULL FOREIGN KEY REFERENCES estados(id),
    creado DATETIME NULL,
    actualizado DATETIME NULL,
    cerrado DATETIME NULL,
    usuario_uid varchar(40) REFERENCES usuarios(uid)
);
