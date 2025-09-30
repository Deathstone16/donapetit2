
-- =============================================================
-- DonAppétit — Esquema de base de datos con CATEGORÍAS
-- Compatibilidad: MySQL 8.0+ / MariaDB 10.4+ (recomendado MySQL 8.0)
-- Juego de caracteres: utf8mb4 / utf8mb4_unicode_ci
-- =============================================================

/* ------------------------------------------------------------------
  1) Creación de base de datos y sesión
------------------------------------------------------------------- */
CREATE DATABASE IF NOT EXISTS donapetit
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE donapetit;

SET NAMES utf8mb4;
SET time_zone = '+00:00';

/* ------------------------------------------------------------------
  2) Tablas principales (idénticas al esquema anterior + categorías)
------------------------------------------------------------------- */

-- 2.1) Usuarios del sistema
CREATE TABLE IF NOT EXISTS usuarios (
  id_usuario        INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nombre            VARCHAR(120)                  NOT NULL,
  email             VARCHAR(160)                  NOT NULL UNIQUE,
  password_hash     VARCHAR(255)                  NOT NULL,
  rol               ENUM('ADMIN','DONANTE','RECEPTOR') NOT NULL DEFAULT 'DONANTE',
  telefono          VARCHAR(30)                   DEFAULT NULL,
  activo            TINYINT(1)                    NOT NULL DEFAULT 1,
  id_organizacion   INT UNSIGNED                  DEFAULT NULL,
  created_at        TIMESTAMP                     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at        TIMESTAMP                     NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX idx_usuarios_rol (rol),
  INDEX idx_usuarios_activo (activo)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2.2) Organizaciones
CREATE TABLE IF NOT EXISTS organizaciones (
  id_organizacion   INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  tipo              ENUM('SUPERMERCADO','COMEDOR','ONG','OTRO') NOT NULL,
  nombre            VARCHAR(160)                  NOT NULL,
  cuit              VARCHAR(20)                   DEFAULT NULL,
  email_contacto    VARCHAR(160)                  DEFAULT NULL,
  telefono          VARCHAR(30)                   DEFAULT NULL,
  latitud           DECIMAL(10,8)                 DEFAULT NULL,
  longitud          DECIMAL(11,8)                 DEFAULT NULL,
  activo            TINYINT(1)                    NOT NULL DEFAULT 1,
  created_at        TIMESTAMP                     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at        TIMESTAMP                     NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX idx_org_tipo (tipo),
  INDEX idx_org_geo (latitud, longitud)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE usuarios
  ADD CONSTRAINT fk_usuarios_organizacion
  FOREIGN KEY (id_organizacion) REFERENCES organizaciones(id_organizacion)
  ON UPDATE CASCADE ON DELETE SET NULL;

-- 2.3) Direcciones
CREATE TABLE IF NOT EXISTS direcciones (
  id_direccion      INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  id_usuario        INT UNSIGNED                  DEFAULT NULL,
  id_organizacion   INT UNSIGNED                  DEFAULT NULL,
  calle             VARCHAR(100)                  NOT NULL,
  numero            VARCHAR(20)                   NOT NULL,
  piso              VARCHAR(10)                   DEFAULT NULL,
  depto             VARCHAR(10)                   DEFAULT NULL,
  entre_calle_1     VARCHAR(100)                  DEFAULT NULL,
  entre_calle_2     VARCHAR(100)                  DEFAULT NULL,
  ciudad            VARCHAR(120)                  DEFAULT NULL,
  provincia         VARCHAR(120)                  DEFAULT NULL,
  codigo_postal     VARCHAR(20)                   DEFAULT NULL,
  observaciones     VARCHAR(255)                  DEFAULT NULL,
  latitud           DECIMAL(10,8)                 DEFAULT NULL,
  longitud          DECIMAL(11,8)                 DEFAULT NULL,
  created_at        TIMESTAMP                     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_dir_usuario
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
    ON UPDATE CASCADE ON DELETE CASCADE,
  CONSTRAINT fk_dir_org
    FOREIGN KEY (id_organizacion) REFERENCES organizaciones(id_organizacion)
    ON UPDATE CASCADE ON DELETE CASCADE,
  INDEX idx_dir_usuario (id_usuario),
  INDEX idx_dir_organizacion (id_organizacion),
  INDEX idx_dir_ciudad (ciudad, provincia)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2.4) *** CATEGORÍAS ***
CREATE TABLE IF NOT EXISTS categorias (
  id_categoria      INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nombre            VARCHAR(100)                  NOT NULL UNIQUE,
  descripcion       VARCHAR(255)                  DEFAULT NULL,
  slug              VARCHAR(120)                  GENERATED ALWAYS AS (REPLACE(LOWER(nombre), ' ', '-')) STORED,
  created_at        TIMESTAMP                     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_categorias_slug (slug)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2.5) Catálogo opcional de productos (normalizable) + categoría principal
CREATE TABLE IF NOT EXISTS catalogo_productos (
  id_catalogo       INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nombre            VARCHAR(150)                  NOT NULL,
  unidad_sugerida   VARCHAR(60)                   NOT NULL, -- ej: 'kg', 'un', 'lts'
  perecedero        TINYINT(1)                    NOT NULL DEFAULT 1,
  id_categoria      INT UNSIGNED                  DEFAULT NULL, -- categoría principal
  created_at        TIMESTAMP                     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at        TIMESTAMP                     NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY uq_catalogo_nombre (nombre),
  INDEX idx_catalogo_perecedero (perecedero),
  INDEX idx_catalogo_categoria (id_categoria),
  CONSTRAINT fk_catalogo_categoria
    FOREIGN KEY (id_categoria) REFERENCES categorias(id_categoria)
    ON UPDATE CASCADE ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2.6) Productos (tabla usada por ProductoController / Modelo Producto)
CREATE TABLE IF NOT EXISTS productos (
  id_producto       INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nom_producto      VARCHAR(150)                  NOT NULL,
  unidad            VARCHAR(60)                   NOT NULL,
  cantidad          INT UNSIGNED                  DEFAULT NULL,
  fecha_vencimiento DATE                          DEFAULT NULL,
  comentarios       TEXT                          DEFAULT NULL,
  id_catalogo       INT UNSIGNED                  DEFAULT NULL,
  id_categoria      INT UNSIGNED                  DEFAULT NULL, -- si no hay catálogo, puede setearse directo
  id_usuario_donante INT UNSIGNED                 DEFAULT NULL,
  id_organizacion_donante INT UNSIGNED            DEFAULT NULL,
  estado            ENUM('DISPONIBLE','RESERVADO','ENTREGADO','VENCIDO','CANCELADO') NOT NULL DEFAULT 'DISPONIBLE',
  created_at        TIMESTAMP                     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at        TIMESTAMP                     NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX idx_nom_producto (nom_producto),
  INDEX idx_prod_estado (estado),
  INDEX idx_prod_venc (fecha_vencimiento),
  INDEX idx_prod_categoria (id_categoria),
  FULLTEXT INDEX ftx_prod_busqueda (nom_producto, comentarios),
  CONSTRAINT fk_prod_catalogo
    FOREIGN KEY (id_catalogo) REFERENCES catalogo_productos(id_catalogo)
    ON UPDATE CASCADE ON DELETE SET NULL,
  CONSTRAINT fk_prod_categoria
    FOREIGN KEY (id_categoria) REFERENCES categorias(id_categoria)
    ON UPDATE CASCADE ON DELETE SET NULL,
  CONSTRAINT fk_prod_usuario_donante
    FOREIGN KEY (id_usuario_donante) REFERENCES usuarios(id_usuario)
    ON UPDATE CASCADE ON DELETE SET NULL,
  CONSTRAINT fk_prod_org_donante
    FOREIGN KEY (id_organizacion_donante) REFERENCES organizaciones(id_organizacion)
    ON UPDATE CASCADE ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2.6.1) Triggers para derivar categoría desde catálogo si no se envía
DELIMITER $$

CREATE TRIGGER trg_prod_set_categoria_ins
BEFORE INSERT ON productos
FOR EACH ROW
BEGIN
  IF NEW.id_categoria IS NULL AND NEW.id_catalogo IS NOT NULL THEN
    SET NEW.id_categoria = (
      SELECT id_categoria FROM catalogo_productos WHERE id_catalogo = NEW.id_catalogo LIMIT 1
    );
  END IF;
END$$

CREATE TRIGGER trg_prod_set_categoria_upd
BEFORE UPDATE ON productos
FOR EACH ROW
BEGIN
  IF NEW.id_catalogo IS NOT NULL AND (NEW.id_categoria IS NULL OR NEW.id_categoria <> OLD.id_categoria) THEN
    SET NEW.id_categoria = (
      SELECT id_categoria FROM catalogo_productos WHERE id_catalogo = NEW.id_catalogo LIMIT 1
    );
  END IF;
END$$

DELIMITER ;

-- 2.7) Solicitudes
CREATE TABLE IF NOT EXISTS solicitudes (
  id_solicitud      INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  id_usuario_receptor INT UNSIGNED                DEFAULT NULL,
  id_organizacion_receptor INT UNSIGNED           DEFAULT NULL,
  id_catalogo       INT UNSIGNED                  DEFAULT NULL,
  nom_producto_solicitado VARCHAR(150)            DEFAULT NULL,
  id_categoria      INT UNSIGNED                  DEFAULT NULL, -- para priorizar por tipo
  unidad            VARCHAR(60)                   NOT NULL,
  cantidad          INT UNSIGNED                  NOT NULL,
  comentarios       TEXT                          DEFAULT NULL,
  estado            ENUM('ABIERTA','ASIGNADA','CERRADA','CANCELADA') NOT NULL DEFAULT 'ABIERTA',
  prioridad         TINYINT UNSIGNED              NOT NULL DEFAULT 3, -- 1 alta, 5 baja
  fecha_limite      DATE                          DEFAULT NULL,
  created_at        TIMESTAMP                     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at        TIMESTAMP                     NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX idx_sol_estado (estado, prioridad),
  INDEX idx_sol_categoria (id_categoria),
  CONSTRAINT fk_sol_usuario_rec
    FOREIGN KEY (id_usuario_receptor) REFERENCES usuarios(id_usuario)
    ON UPDATE CASCADE ON DELETE SET NULL,
  CONSTRAINT fk_sol_org_rec
    FOREIGN KEY (id_organizacion_receptor) REFERENCES organizaciones(id_organizacion)
    ON UPDATE CASCADE ON DELETE SET NULL,
  CONSTRAINT fk_sol_catalogo
    FOREIGN KEY (id_catalogo) REFERENCES catalogo_productos(id_catalogo)
    ON UPDATE CASCADE ON DELETE SET NULL,
  CONSTRAINT fk_sol_categoria
    FOREIGN KEY (id_categoria) REFERENCES categorias(id_categoria)
    ON UPDATE CASCADE ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2.8) Asignaciones
CREATE TABLE IF NOT EXISTS asignaciones (
  id_asignacion     INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  id_producto       INT UNSIGNED                  NOT NULL,
  id_solicitud      INT UNSIGNED                  DEFAULT NULL,
  id_usuario_receptor INT UNSIGNED                DEFAULT NULL,
  id_organizacion_receptor INT UNSIGNED           DEFAULT NULL,
  cantidad_asignada INT UNSIGNED                  NOT NULL,
  estado            ENUM('PENDIENTE','CONFIRMADA','CANCELADA','COMPLETADA') NOT NULL DEFAULT 'PENDIENTE',
  vence_el          DATETIME                      DEFAULT NULL,
  created_at        TIMESTAMP                     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at        TIMESTAMP                     NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_asig_producto
    FOREIGN KEY (id_producto) REFERENCES productos(id_producto)
    ON UPDATE CASCADE ON DELETE CASCADE,
  CONSTRAINT fk_asig_solicitud
    FOREIGN KEY (id_solicitud) REFERENCES solicitudes(id_solicitud)
    ON UPDATE CASCADE ON DELETE SET NULL,
  CONSTRAINT fk_asig_usuario_rec
    FOREIGN KEY (id_usuario_receptor) REFERENCES usuarios(id_usuario)
    ON UPDATE CASCADE ON DELETE SET NULL,
  CONSTRAINT fk_asig_org_rec
    FOREIGN KEY (id_organizacion_receptor) REFERENCES organizaciones(id_organizacion)
    ON UPDATE CASCADE ON DELETE SET NULL,
  INDEX idx_asig_estado (estado),
  CHECK (cantidad_asignada > 0)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2.9) Retiros / Entregas
CREATE TABLE IF NOT EXISTS retiros (
  id_retiro         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  id_asignacion     INT UNSIGNED                  NOT NULL,
  tipo              ENUM('RETIRO','ENTREGA')      NOT NULL DEFAULT 'RETIRO',
  fecha_programada  DATETIME                      NOT NULL,
  fecha_real        DATETIME                      DEFAULT NULL,
  direccion_texto   VARCHAR(255)                  DEFAULT NULL,
  estado            ENUM('PROGRAMADO','EN_CURSO','COMPLETADO','FALLIDO','CANCELADO') NOT NULL DEFAULT 'PROGRAMADO',
  notas             TEXT                          DEFAULT NULL,
  created_at        TIMESTAMP                     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at        TIMESTAMP                     NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_retiro_asignacion
    FOREIGN KEY (id_asignacion) REFERENCES asignaciones(id_asignacion)
    ON UPDATE CASCADE ON DELETE CASCADE,
  INDEX idx_retiro_estado (estado),
  INDEX idx_retiro_programada (fecha_programada)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2.10) Imágenes
CREATE TABLE IF NOT EXISTS imagenes_productos (
  id_imagen         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  id_producto       INT UNSIGNED                  NOT NULL,
  url               VARCHAR(255)                  NOT NULL,
  es_principal      TINYINT(1)                    NOT NULL DEFAULT 0,
  created_at        TIMESTAMP                     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_img_producto
    FOREIGN KEY (id_producto) REFERENCES productos(id_producto)
    ON UPDATE CASCADE ON DELETE CASCADE,
  INDEX idx_img_producto (id_producto, es_principal)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2.11) Notificaciones
CREATE TABLE IF NOT EXISTS notificaciones (
  id_notificacion   BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  id_usuario        INT UNSIGNED                  NOT NULL,
  tipo              VARCHAR(60)                   NOT NULL,
  titulo            VARCHAR(160)                  NOT NULL,
  mensaje           TEXT                          NOT NULL,
  leida             TINYINT(1)                    NOT NULL DEFAULT 0,
  created_at        TIMESTAMP                     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_notif_usuario
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
    ON UPDATE CASCADE ON DELETE CASCADE,
  INDEX idx_notif_usuario_leida (id_usuario, leida),
  INDEX idx_notif_tipo (tipo)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2.12) Auditoría
CREATE TABLE IF NOT EXISTS auditoria_eventos (
  id_evento         BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  entidad           VARCHAR(60)                   NOT NULL,
  id_entidad        BIGINT UNSIGNED               NOT NULL,
  accion            ENUM('CREAR','ACTUALIZAR','BORRAR','ESTADO') NOT NULL,
  id_usuario_actor  INT UNSIGNED                  DEFAULT NULL,
  datos_previos     JSON                          DEFAULT NULL,
  datos_nuevos      JSON                          DEFAULT NULL,
  ip                VARCHAR(45)                   DEFAULT NULL,
  user_agent        VARCHAR(255)                  DEFAULT NULL,
  created_at        TIMESTAMP                     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_auditoria_entidad (entidad, id_entidad),
  CONSTRAINT fk_auditoria_usuario
    FOREIGN KEY (id_usuario_actor) REFERENCES usuarios(id_usuario)
    ON UPDATE CASCADE ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2.13) Password resets
CREATE TABLE IF NOT EXISTS password_resets (
  id_reset          BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  email             VARCHAR(160)                  NOT NULL,
  token_hash        VARCHAR(255)                  NOT NULL,
  expira_el         DATETIME                      NOT NULL,
  usado             TINYINT(1)                    NOT NULL DEFAULT 0,
  created_at        TIMESTAMP                     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_reset_email (email),
  INDEX idx_reset_expira (expira_el)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/* ------------------------------------------------------------------
  3) Vistas útiles (con categoría)
------------------------------------------------------------------- */

-- Productos vigentes con categoría detectada
CREATE OR REPLACE VIEW vw_productos_disponibles AS
SELECT
  p.id_producto,
  p.nom_producto,
  p.unidad,
  p.cantidad,
  p.fecha_vencimiento,
  DATEDIFF(p.fecha_vencimiento, CURRENT_DATE) AS dias_a_vencer,
  p.estado,
  COALESCE(pc.nombre, cc.nombre, 'Sin categoría') AS categoria,
  p.created_at,
  p.updated_at
FROM productos p
LEFT JOIN categorias pc ON p.id_categoria = pc.id_categoria
LEFT JOIN catalogo_productos cp ON p.id_catalogo = cp.id_catalogo
LEFT JOIN categorias cc ON cp.id_categoria = cc.id_categoria
WHERE p.estado IN ('DISPONIBLE','RESERVADO')
  AND (p.fecha_vencimiento IS NULL OR p.fecha_vencimiento >= CURRENT_DATE);

-- Resumen por categoría (productos disponibles)
CREATE OR REPLACE VIEW vw_resumen_por_categoria AS
SELECT
  COALESCE(pc.nombre, cc.nombre, 'Sin categoría') AS categoria,
  COUNT(*)                                        AS productos_registrados,
  SUM(COALESCE(p.cantidad, 0))                    AS unidades_totales
FROM productos p
LEFT JOIN categorias pc ON p.id_categoria = pc.id_categoria
LEFT JOIN catalogo_productos cp ON p.id_catalogo = cp.id_catalogo
LEFT JOIN categorias cc ON cp.id_categoria = cc.id_categoria
WHERE p.estado = 'DISPONIBLE'
GROUP BY categoria
ORDER BY productos_registrados DESC;

-- Resumen simple para dashboard (se mantiene)
CREATE OR REPLACE VIEW vw_dashboard_resumen AS
SELECT
  (SELECT COUNT(*) FROM productos WHERE estado='DISPONIBLE') AS productos_disponibles,
  (SELECT COUNT(*) FROM productos WHERE estado='RESERVADO')  AS productos_reservados,
  (SELECT COUNT(*) FROM productos WHERE estado='ENTREGADO')  AS productos_entregados,
  (SELECT COUNT(*) FROM solicitudes WHERE estado='ABIERTA')  AS solicitudes_abiertas,
  (SELECT COUNT(*) FROM asignaciones WHERE estado='PENDIENTE') AS asignaciones_pendientes;

/* ------------------------------------------------------------------
  4) Evento opcional
------------------------------------------------------------------- */

CREATE EVENT IF NOT EXISTS ev_marcar_vencidos
  ON SCHEDULE EVERY 1 DAY STARTS (CURRENT_DATE + INTERVAL 1 DAY)
  DO
    UPDATE productos
      SET estado = 'VENCIDO'
    WHERE fecha_vencimiento IS NOT NULL
      AND fecha_vencimiento < CURRENT_DATE
      AND estado IN ('DISPONIBLE','RESERVADO');

/* ------------------------------------------------------------------
  5) Seeds (incluye CATEGORÍAS y catálogo mapeado)
------------------------------------------------------------------- */

-- 5.1) Categorías comunes
INSERT INTO categorias (nombre, descripcion)
VALUES
  ('Panificados', 'Pan, pan lactal, facturas, galletas, etc.'),
  ('Lácteos', 'Leche, yogur, queso, manteca, etc.'),
  ('Bebidas', 'Agua, jugos, gaseosas, etc.'),
  ('Enlatados', 'Atún, choclo, arvejas, etc.'),
  ('Pastas', 'Secas o frescas.'),
  ('Arroz y Cereales', 'Arroz, harina de maíz, avena, etc.'),
  ('Legumbres', 'Lentejas, porotos, garbanzos, etc.'),
  ('Carnes', 'Vacuna, pollo, cerdo, etc.'),
  ('Verduras', 'Frescas o procesadas.'),
  ('Frutas', 'Frescas o procesadas.'),
  ('Aceites y Aderezos', 'Aceite, mayonesa, salsa, etc.'),
  ('Higiene', 'Personal y sanitaria.'),
  ('Limpieza', 'Hogar, desinfección.'),
  ('Otros', 'No clasificadas.')
ON DUPLICATE KEY UPDATE descripcion = VALUES(descripcion);

-- 5.2) Organizaciones de ejemplo
INSERT INTO organizaciones (tipo, nombre, email_contacto, telefono, activo)
VALUES
  ('SUPERMERCADO', 'Super DonAppétit', 'contacto@super.com', '+54 362 4000000', 1),
  ('COMEDOR',      'Comedor Esperanza', 'hola@comedor.org', '+54 362 4111111', 1)
ON DUPLICATE KEY UPDATE nombre = VALUES(nombre);

-- 5.3) Usuario admin (reemplazar hash por uno real)
INSERT INTO usuarios (nombre, email, password_hash, rol, activo, id_organizacion)
VALUES ('Admin', 'admin@donappetit.local', '$2y$10$REEMPLAZAR_HASH_BCRYPT', 'ADMIN', 1, NULL)
ON DUPLICATE KEY UPDATE nombre = VALUES(nombre);

-- 5.4) Catálogo base con categoría
INSERT INTO catalogo_productos (nombre, unidad_sugerida, perecedero, id_categoria)
VALUES
  ('Leche', 'lts', 1, (SELECT id_categoria FROM categorias WHERE nombre='Lácteos' LIMIT 1)),
  ('Arroz', 'kg', 0, (SELECT id_categoria FROM categorias WHERE nombre='Arroz y Cereales' LIMIT 1)),
  ('Pan', 'un', 1, (SELECT id_categoria FROM categorias WHERE nombre='Panificados' LIMIT 1)),
  ('Fideos', 'kg', 0, (SELECT id_categoria FROM categorias WHERE nombre='Pastas' LIMIT 1)),
  ('Lentejas', 'kg', 0, (SELECT id_categoria FROM categorias WHERE nombre='Legumbres' LIMIT 1)),
  ('Aceite', 'lts', 0, (SELECT id_categoria FROM categorias WHERE nombre='Aceites y Aderezos' LIMIT 1)),
  ('Queso', 'kg', 1, (SELECT id_categoria FROM categorias WHERE nombre='Lácteos' LIMIT 1))
ON DUPLICATE KEY UPDATE unidad_sugerida = VALUES(unidad_sugerida),
                        id_categoria = VALUES(id_categoria);

-- 5.5) Producto de ejemplo con categoría (usando catálogo)
INSERT INTO productos (nom_producto, unidad, cantidad, fecha_vencimiento, comentarios, estado, id_catalogo)
VALUES ('Leche entera', 'lts', 10, DATE_ADD(CURRENT_DATE, INTERVAL 15 DAY), 'Pack cerrado', 'DISPONIBLE',
        (SELECT id_catalogo FROM catalogo_productos WHERE nombre='Leche' LIMIT 1));

