-- Crea la base y la usa
CREATE DATABASE IF NOT EXISTS donappetit
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_general_ci;
USE donappetit;

-- Para recrear sin conflictos de FKs
SET FOREIGN_KEY_CHECKS = 0;

-- Drops opcionales (recrear desde cero)
DROP TABLE IF EXISTS stock_productos_donacion;
DROP TABLE IF EXISTS estadistica;
DROP TABLE IF EXISTS stock_productos;
DROP TABLE IF EXISTS solicitudes;
DROP TABLE IF EXISTS donacion;
DROP TABLE IF EXISTS cargar_productos;
DROP TABLE IF EXISTS imagenes_productos;
DROP TABLE IF EXISTS retiros;
DROP TABLE IF EXISTS direcciones;
DROP TABLE IF EXISTS receptor;
DROP TABLE IF EXISTS donante;
DROP TABLE IF EXISTS codigo_verificacion;
DROP TABLE IF EXISTS productos;
DROP TABLE IF EXISTS unidades;
DROP TABLE IF EXISTS categorias;
DROP TABLE IF EXISTS usuarios;

-- ============================================================
-- TABLAS
-- ============================================================

-- usuarios
CREATE TABLE usuarios (
  id_usuario     INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador único.',
  `Nombre`       VARCHAR(255) NOT NULL COMMENT 'Nombre completo.',
  `Email`        VARCHAR(255) NOT NULL COMMENT 'Único. Para login.',
  `Contraseña`   VARCHAR(255) NOT NULL COMMENT 'Hash de contraseña.',
  rol            VARCHAR(50)  NOT NULL COMMENT 'donante | receptor | admin',
  telefono       VARCHAR(50)  NOT NULL COMMENT 'Teléfono del usuario.',
  Latitud        DECIMAL(10,8) NOT NULL COMMENT 'Latitud GPS.',
  Longitud       DECIMAL(11,8) NOT NULL COMMENT 'Longitud GPS.',
  activo         VARCHAR(1)   NOT NULL COMMENT '1/0 activo/inactivo.',
  PRIMARY KEY (id_usuario),
  UNIQUE KEY uq_usuarios_email (`Email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- categorias
CREATE TABLE categorias (
  id_categoria INT(11) NOT NULL AUTO_INCREMENT,
  nombre       VARCHAR(100) NOT NULL COMMENT 'Nombre de la categoría.',
  PRIMARY KEY (id_categoria),
  UNIQUE KEY uq_categorias_nombre (nombre)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- unidades (predefinidas: kg, g, lts, etc.)
CREATE TABLE unidades (
  id_unidad     INT(11) NOT NULL AUTO_INCREMENT,
  nombre_unidad VARCHAR(50) NOT NULL COMMENT 'Kilogramo, Gramo, Litro, etc.',
  abreviatura   VARCHAR(10) NOT NULL COMMENT 'kg, g, lts, ml, etc.',
  estado        TINYINT(1) NOT NULL COMMENT '1=activo, 0=inactivo',
  PRIMARY KEY (id_unidad),
  UNIQUE KEY uq_unidades_nombre (nombre_unidad),
  UNIQUE KEY uq_unidades_abrev  (abreviatura)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- productos
CREATE TABLE productos (
  id_productos INT(11) NOT NULL AUTO_INCREMENT COMMENT 'ID producto.',
  create_at    DATETIME NOT NULL COMMENT 'Creación.',
  update_at    DATETIME NOT NULL COMMENT 'Última mod.',
  comentario   VARCHAR(255) NOT NULL COMMENT 'Marca, empaque, etc.',
  PRIMARY KEY (id_productos)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- donante (1:1 con usuarios)
CREATE TABLE donante (
  id_usu_donante INT(11) NOT NULL COMMENT 'FK usuarios.id_usuario',
  nom_comercial  VARCHAR(255) NOT NULL COMMENT 'Nombre comercial.',
  CUIT           VARCHAR(20) NOT NULL COMMENT 'CUIT.',
  PRIMARY KEY (id_usu_donante),
  CONSTRAINT fk_donante_usuario
    FOREIGN KEY (id_usu_donante) REFERENCES usuarios(id_usuario)
    ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- receptor (1:1 con usuarios)
CREATE TABLE receptor (
  id_usu_receptor INT(11) NOT NULL COMMENT 'FK usuarios.id_usuario',
  num_renacom     VARCHAR(50) NOT NULL,
  nom_institucion VARCHAR(255) NOT NULL,
  responsable     VARCHAR(50) NOT NULL,
  PRIMARY KEY (id_usu_receptor),
  CONSTRAINT fk_receptor_usuario
    FOREIGN KEY (id_usu_receptor) REFERENCES usuarios(id_usuario)
    ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- direcciones
CREATE TABLE direcciones (
  id_direccion      INT(11) NOT NULL AUTO_INCREMENT,
  id_usuario_direcc INT(11) NOT NULL COMMENT 'FK usuarios.id_usuario',
  nom_calle         VARCHAR(50) NOT NULL,
  num_calle         INT(11) NOT NULL,
  PRIMARY KEY (id_direccion),
  KEY idx_dir_usuario (id_usuario_direcc),
  CONSTRAINT fk_dir_usuario
    FOREIGN KEY (id_usuario_direcc) REFERENCES usuarios(id_usuario)
    ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- retiros
CREATE TABLE retiros (
  id_retiro        INT(11) NOT NULL AUTO_INCREMENT,
  fecha_programada DATETIME NOT NULL,
  fecha_retiro     DATETIME NOT NULL,
  estado           TINYINT(1) NOT NULL COMMENT '1=entregado, 0=no',
  id_direcciones   INT(11) NOT NULL COMMENT 'FK direcciones.id_direccion',
  detalles         VARCHAR(255) NOT NULL,
  create_at        DATETIME NOT NULL,
  delete_at        DATETIME NOT NULL,
  PRIMARY KEY (id_retiro),
  KEY idx_retiro_direccion (id_direcciones),
  CONSTRAINT fk_retiro_direccion
    FOREIGN KEY (id_direcciones) REFERENCES direcciones(id_direccion)
    ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- donacion
CREATE TABLE donacion (
  id_donacion     INT(11) NOT NULL AUTO_INCREMENT,
  id_productos    INT(11) NOT NULL COMMENT 'FK productos.id_productos',
  cantidad_donado INT(11) NOT NULL,
  create_at       DATETIME NOT NULL,
  id_retiros      INT(11) NOT NULL COMMENT 'FK retiros.id_retiro',
  update_at       DATETIME NOT NULL,
  PRIMARY KEY (id_donacion),
  KEY idx_donacion_producto (id_productos),
  KEY idx_donacion_retiro (id_retiros),
  CONSTRAINT fk_donacion_producto
    FOREIGN KEY (id_productos) REFERENCES productos(id_productos)
    ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT fk_donacion_retiro
    FOREIGN KEY (id_retiros) REFERENCES retiros(id_retiro)
    ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- solicitudes
CREATE TABLE solicitudes (
  id_solicitud        INT(11) NOT NULL AUTO_INCREMENT,
  id_donante          INT(11) NOT NULL COMMENT 'FK donante.id_usu_donante',
  id_productos        INT(11) NOT NULL COMMENT 'FK productos.id_productos',
  cantidad_solicitada INT(11) NOT NULL,
  create_at           DATETIME NOT NULL,
  estado              TINYINT(1) NOT NULL,
  PRIMARY KEY (id_solicitud),
  KEY idx_sol_donante (id_donante),
  KEY idx_sol_producto (id_productos),
  CONSTRAINT fk_sol_donante
    FOREIGN KEY (id_donante) REFERENCES donante(id_usu_donante)
    ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT fk_sol_producto
    FOREIGN KEY (id_productos) REFERENCES productos(id_productos)
    ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- stock_productos
CREATE TABLE stock_productos (
  id_stock    INT(11) NOT NULL AUTO_INCREMENT,
  id_donante  INT(11) NOT NULL COMMENT 'FK donante.id_usu_donante',
  cantidad    INT(11) NOT NULL COMMENT 'Cantidad en stock',
  id_producto INT(11) NOT NULL COMMENT 'FK productos.id_productos',
  create_at   DATETIME NOT NULL,
  update_at   DATETIME NOT NULL,
  PRIMARY KEY (id_stock),
  KEY idx_stock_donante (id_donante),
  KEY idx_stock_producto (id_producto),
  CONSTRAINT fk_stock_donante
    FOREIGN KEY (id_donante) REFERENCES donante(id_usu_donante)
    ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT fk_stock_producto
    FOREIGN KEY (id_producto) REFERENCES productos(id_productos)
    ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- stock_productos_donacion (relación entre stock y donación x producto)
CREATE TABLE stock_productos_donacion (
  id_stock_productos_donaciones INT(11) NOT NULL AUTO_INCREMENT,
  id_producto                   INT(11) NOT NULL COMMENT 'FK productos.id_productos',
  stock_productos               INT(11) NOT NULL COMMENT 'FK stock_productos.id_stock',
  PRIMARY KEY (id_stock_productos_donaciones),
  KEY idx_spd_producto (id_producto),
  KEY idx_spd_stock (stock_productos),
  CONSTRAINT fk_spd_producto
    FOREIGN KEY (id_producto) REFERENCES productos(id_productos)
    ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT fk_spd_stock
    FOREIGN KEY (stock_productos) REFERENCES stock_productos(id_stock)
    ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- imagenes_productos
CREATE TABLE imagenes_productos (
  id_imagenes  INT(11) NOT NULL AUTO_INCREMENT,
  id_productos INT(11) NOT NULL COMMENT 'FK productos.id_productos',
  url          VARCHAR(2083) NOT NULL,
  create_at    DATETIME NOT NULL,
  update_at    DATETIME NOT NULL,
  PRIMARY KEY (id_imagenes),
  KEY idx_img_producto (id_productos),
  CONSTRAINT fk_img_producto
    FOREIGN KEY (id_productos) REFERENCES productos(id_productos)
    ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- cargar_productos
CREATE TABLE cargar_productos (
  id_carga      INT(11) NOT NULL AUTO_INCREMENT,
  id_productos  INT(11) NOT NULL COMMENT 'FK productos.id_productos',
  id_unidades   INT(11) NOT NULL COMMENT 'FK unidades.id_unidad',
  id_categorias INT(11) NOT NULL COMMENT 'FK categorias.id_categoria',
  PRIMARY KEY (id_carga),
  KEY idx_carga_producto (id_productos),
  KEY idx_carga_unidad (id_unidades),
  KEY idx_carga_categoria (id_categorias),
  CONSTRAINT fk_carga_producto
    FOREIGN KEY (id_productos) REFERENCES productos(id_productos)
    ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT fk_carga_unidad
    FOREIGN KEY (id_unidades) REFERENCES unidades(id_unidad)
    ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT fk_carga_categoria
    FOREIGN KEY (id_categorias) REFERENCES categorias(id_categoria)
    ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- estadistica
CREATE TABLE estadistica (
  id_estadistica     INT(11) NOT NULL AUTO_INCREMENT,
  id_donacion        INT(11) NOT NULL COMMENT 'FK donacion.id_donacion',
  total_donado       INT(11) NOT NULL,
  frecuencia_mensual INT(11) NOT NULL,
  frecuencia_anual   INT(11) NOT NULL,
  PRIMARY KEY (id_estadistica),
  KEY idx_estad_donacion (id_donacion),
  CONSTRAINT fk_estad_donacion
    FOREIGN KEY (id_donacion) REFERENCES donacion(id_donacion)
    ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- codigo_verificacion
CREATE TABLE codigo_verificacion (
  id_cod           INT(11) NOT NULL AUTO_INCREMENT,
  id_usuario       INT(11) NOT NULL COMMENT 'FK usuarios.id_usuario',
  fecha_expiracion DATETIME NOT NULL,
  activo           VARCHAR(1) NOT NULL,
  PRIMARY KEY (id_cod),
  KEY idx_cod_usuario (id_usuario),
  CONSTRAINT fk_codigo_usuario
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
    ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ============================================================
-- SEED DATA (idempotente)
-- ============================================================

-- Unidades predefinidas
INSERT INTO unidades (nombre_unidad, abreviatura, estado) VALUES
  ('Kilogramo', 'kg', 1),
  ('Gramo',     'g',  1),
  ('Litro',     'lts',1),
  ('Mililitro', 'ml', 1),
  ('Unidad',    'u',  1),
  ('Paquete',   'pack', 1)
ON DUPLICATE KEY UPDATE
  abreviatura = VALUES(abreviatura),
  estado      = VALUES(estado);

-- Categorías ejemplo
INSERT INTO categorias (nombre) VALUES
  ('Panificados'),
  ('Lácteos'),
  ('Bebidas'),
  ('Frutas'),
  ('Verduras'),
  ('Almacén'),
  ('Carnes'),
  ('Enlatados'),
  ('Granos y Cereales')
ON DUPLICATE KEY UPDATE
  nombre = VALUES(nombre);

-- Volver a activar checks de FK
SET FOREIGN_KEY_CHECKS = 1;
