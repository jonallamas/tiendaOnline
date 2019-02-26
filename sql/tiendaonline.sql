CREATE TABLE IF NOT EXISTS `tienda_usuarios` (
  `id`              INT NOT NULL AUTO_INCREMENT,
  `tienda_id`      INT DEFAULT NULL,

  `apellido`      VARCHAR(64) DEFAULT NULL,
  `nombre`          VARCHAR(64) DEFAULT NULL,
  `telefono`        INT DEFAULT NULL,
  `correo`          VARCHAR(120) DEFAULT NULL,

  `log_correo`      VARCHAR(120) DEFAULT NULL,
  `log_pass`        VARCHAR(32) DEFAULT NULL,

  `validado`        INT DEFAULT NULL,
  `keymaster`       VARCHAR(32) DEFAULT NULL,

  `estado`          INT DEFAULT NULL,
  `creado`          DATETIME DEFAULT NULL,
  `actualizado`     DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `tienda_productos_categoria` (
  `id`              INT NOT NULL AUTO_INCREMENT,
  `tienda_id`       INT DEFAULT NULL,

  `nombre`          VARCHAR(64) DEFAULT NULL,
  `descripcion`          TEXT DEFAULT NULL,

  `estado`          INT DEFAULT NULL,
  `creado`          DATETIME DEFAULT NULL,
  `actualizado`     DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;

INSERT INTO `tienda_productos_categoria` (`id`, `tienda_id`, `nombre`, `descripcion`, `estado`, `creado`, `actualizado`) VALUES
(1, 1, 'Vaporizador', NULL, 1, '2019-02-24 01:51:00', '2019-02-24 01:51:00'),
(2, 1, 'Atomizador', NULL, 1, '2019-02-24 01:51:00', '2019-02-24 01:51:00');

CREATE TABLE IF NOT EXISTS `tienda_productos` (
  `id`              INT NOT NULL AUTO_INCREMENT,
  `tienda_id`       INT DEFAULT NULL,

  `nombre`          VARCHAR(64) DEFAULT NULL,
  `categoria_id`    INT DEFAULT NULL,
  `precio`          FLOAT(10,2) DEFAULT NULL,

  `estado`          INT DEFAULT NULL,
  `creado`          DATETIME DEFAULT NULL,
  `actualizado`     DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`categoria_id`) REFERENCES `tienda_productos_categoria`(`id`)
) ENGINE = InnoDB;

INSERT INTO `tienda_productos` (`id`, `tienda_id`, `nombre`, `categoria_id`, `precio`, `estado`, `creado`, `actualizado`) VALUES
(1, 1, 'Ammit dual coil', 2, 1800.00, 1, '2019-02-24 01:51:00', '2019-02-24 01:51:00'),
(2, 1, 'Cuboid Tap', 1, 2600.00, 1, '2019-02-24 01:51:00', '2019-02-24 01:51:00');

ALTER TABLE `tienda_usuarios` ADD `tipo_id` INT DEFAULT NULL AFTER `keymaster`;

CREATE TABLE IF NOT EXISTS `tienda_stk_compras` (
  `id`              INT NOT NULL AUTO_INCREMENT,
  `tienda_id`       INT DEFAULT NULL,

  `usuario_id`      INT DEFAULT NULL,
  `cantidad`        FLOAT(10,2) DEFAULT NULL,
  `total`           FLOAT(10,2) DEFAULT NULL,
  `tipo_id`         INT DEFAULT NULL,

  `estado`          INT DEFAULT NULL,
  `creado`          DATETIME DEFAULT NULL,
  `actualizado`     DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `tienda_stk_compras_egreso` (
  `id`              INT NOT NULL AUTO_INCREMENT,
  `tienda_id`       INT DEFAULT NULL,

  `compra_id`       INT DEFAULT NULL,
  `usuario_id`      INT DEFAULT NULL,
  `rowid`           VARCHAR(48) DEFAULT NULL,
  `nombre`          VARCHAR(128) DEFAULT NULL,
  `producto_id`     INT DEFAULT NULL,
  `cantidad`        FLOAT(10,2) DEFAULT NULL,
  `precio`          FLOAT(10,2) DEFAULT NULL,
  `subtotal`        FLOAT(10,2) DEFAULT NULL,

  `estado`          INT DEFAULT NULL,
  `creado`          DATETIME DEFAULT NULL,
  `actualizado`     DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `tienda_clientes_direcciones_envio` (
  `id`              INT NOT NULL AUTO_INCREMENT,
  `tienda_id`       INT DEFAULT NULL,

  `usuario_id`      INT DEFAULT NULL,
  `codigo_postal`   INT DEFAULT NULL,
  
  `calle_nombre`    VARCHAR(64) DEFAULT NULL,
  `calle_numero`    INT DEFAULT NULL,

  `piso`            VARCHAR(16) DEFAULT NULL,
  `departamento`    VARCHAR(16) DEFAULT NULL,

  `estado`          INT DEFAULT NULL,
  `creado`          DATETIME DEFAULT NULL,
  `actualizado`     DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;


-- Ejemplo de prueba

-- CREATE TABLE IF NOT EXISTS `tabla_nombre` (
--   `columna`    VARCHAR(64) DEFAULT NULL,
--   `columna`    DECIMAL(10,2) DEFAULT NULL,
--   `columna`    DATETIME DEFAULT NULL,
--   PRIMARY KEY (`id`),
--   FOREIGN KEY (`columna_id`) REFERENCES `tabla_nombre_referencia`(`id`)
-- ) ENGINE = InnoDB;