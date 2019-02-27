INSERT INTO estados (nombre, paridad) VALUES ('ACTIVO', 1), ('INACTIVO', 1), ('ABIERTO', 2), ('CERRADO', 2);
INSERT INTO divisiones (nombre, estado_id) VALUES ('CAMANCHACA PESCA SUR', 1);
INSERT INTO usuarios (uid, nombre, estado_id) VALUES ('admin', 'ADMINISTRADOR', 1);
INSERT INTO recursos (nombre, estado_id) VALUES ('SARDINA', 1), ('JUREL', 1), ('LAN;STINO', 1);
INSERT INTO grupos (nombre, division_id, recurso_id, estado_id) VALUES ('ADMIN SARDINAS', 1, 1, 1);
INSERT INTO grupos_usuarios (grupo_id, usuario_uid) VALUES (1, 'admin');
INSERT INTO privilegios (nombre) VALUES ('all'), ('admin'), ('marea_view'), ('marea_add'), ('marea_delete'), ('marea_update'), ('marea_lock'), ('marea_ulock'),
('recalada_view'), ('recalada_add'), ('recalada_delete'), ('recalada_update'), ('recalada_lock'), ('recalada_ulock'),
('descarga_view'), ('descarga_add'), ('descarga_delete'), ('descarga_update'), ('descarga_lock'), ('descarga_ulock'),
('guia_view'), ('guia_add'), ('guia_delete'), ('guia_update'), ('guia_lock'), ('guia_ulock'),
('folio_view'), ('folio_add'), ('folio_delete'), ('folio_update'), ('folio_lock'), ('folio_ulock'),
('calidad_view'), ('calidad_add'), ('calidad_delete'), ('calidad_update'), ('calidad_lock'), ('calidad_ulock');
INSERT INTO grupos_privilegios (grupo_id, privilegio_id) VALUES (1, 1), (1, 2);
INSERT INTO unidades (nombre, abreviacion, estado_id) VALUES ('TONELADAS', 'TON', 1), ('CAJAS', 'CJS', 1);
INSERT INTO recursos_unidades (unidad_id, recurso_id) VALUES (1, 1), -- sardinas con toneladas
(1,2), -- Jureles con toneladas
(1,3), -- Langostinos con toneladas
(2,3); -- Langostinos con Cajas
INSERT INTO regimenes (nombre) VALUES ('INDUSTRIAL'), ('ARTESANAL');
INSERT INTO zona_operaciones (nombre) VALUES ('VALDIVIA'), ('CORONEL'), ('TALCAHUANO'), ('SAN ANTONIO');
INSERT INTO arte_pesca (nombre, recurso_id, estado_id) VALUES ('ARRASTRE LAN;STINOS', 3, 1), ('CERCO SARDINAS', 1, 1);
INSERT INTO movimientos (nombre, tipo) VALUES ('COMPRA', 1), ('CAPTURA', 1), ('VENTA', 2), ('TRASLADO', 2);
INSERT INTO tipo_descargas (nombre) VALUES ('INDUSTRIAL'), ('ARTESANAL'), ('RECIBO');
