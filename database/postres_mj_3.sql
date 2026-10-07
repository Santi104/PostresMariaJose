CREATE SCHEMA IF NOT EXISTS `postres_mj`
  DEFAULT CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;
USE `postres_mj`;

CREATE TABLE `usuarios` (
  `id`             INT UNSIGNED    NOT NULL AUTO_INCREMENT,
  `nombre`         VARCHAR(100)    NOT NULL,
  `usuario`        VARCHAR(50)     NOT NULL,
  `correo`         VARCHAR(150)    NOT NULL,
  `password`       VARCHAR(255)    NOT NULL,
  `activo`         TINYINT(1)      NOT NULL DEFAULT 1,
  `remember_token` VARCHAR(100)    NULL DEFAULT NULL,
  `created_at`     TIMESTAMP       NULL DEFAULT NULL,
  `updated_at`     TIMESTAMP       NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `usuarios_usuario_UNIQUE` (`usuario` ASC),
  UNIQUE INDEX `usuarios_correo_UNIQUE` (`correo` ASC)
) ENGINE = InnoDB;

CREATE TABLE `categorias` (
  `id`          INT UNSIGNED   NOT NULL AUTO_INCREMENT,
  `nombre`      VARCHAR(80)    NOT NULL,
  `descripcion` VARCHAR(255)   NULL DEFAULT NULL,
  `activo`      TINYINT(1)     NOT NULL DEFAULT 1,
  `created_at`  TIMESTAMP      NULL DEFAULT NULL,
  `updated_at`  TIMESTAMP      NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `categorias_nombre_UNIQUE` (`nombre` ASC)
) ENGINE = InnoDB;

CREATE TABLE `metodos_pago` (
  `id`                  INT UNSIGNED  NOT NULL AUTO_INCREMENT,
  `nombre`              VARCHAR(50)   NOT NULL,
  `requiere_referencia` TINYINT(1)    NOT NULL DEFAULT 0,
  `activo`              TINYINT(1)    NOT NULL DEFAULT 1,
  `created_at`          TIMESTAMP     NULL DEFAULT NULL,
  `updated_at`          TIMESTAMP     NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `metodos_pago_nombre_UNIQUE` (`nombre` ASC)
) ENGINE = InnoDB;

CREATE TABLE `productos` (
  `id`             INT UNSIGNED    NOT NULL AUTO_INCREMENT,
  `categoria_id`   INT UNSIGNED    NOT NULL,
  `codigo`         VARCHAR(30)     NOT NULL,
  `nombre`         VARCHAR(120)    NOT NULL,
  `descripcion`    VARCHAR(255)    NULL DEFAULT NULL,
  `precio_venta`   DECIMAL(12,2) UNSIGNED NOT NULL,
  `costo_unitario` DECIMAL(12,2) UNSIGNED NOT NULL DEFAULT 0.00,
  `stock_actual`   INT             NOT NULL DEFAULT 0,
  `stock_minimo`   INT UNSIGNED    NOT NULL DEFAULT 0,
  `imagen`         VARCHAR(255)    NULL DEFAULT NULL,
  `activo`         TINYINT(1)      NOT NULL DEFAULT 1,
  `created_at`     TIMESTAMP       NULL DEFAULT NULL,
  `updated_at`     TIMESTAMP       NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `productos_codigo_UNIQUE` (`codigo` ASC),
  INDEX `fk_productos_categorias_idx` (`categoria_id` ASC),
  CONSTRAINT `fk_productos_categorias`
    FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`)
    ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB;

CREATE TABLE `turnos_caja` (
  `id`             INT UNSIGNED   NOT NULL AUTO_INCREMENT,
  `usuario_id`     INT UNSIGNED   NOT NULL,
  `fecha_apertura` DATETIME       NOT NULL,
  `fecha_cierre`   DATETIME       NULL DEFAULT NULL,
  `base_inicial`   DECIMAL(12,2) UNSIGNED NOT NULL DEFAULT 0.00,
  `estado`         ENUM('abierto','cerrado') NOT NULL DEFAULT 'abierto',
  `created_at`     TIMESTAMP      NULL DEFAULT NULL,
  `updated_at`     TIMESTAMP      NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_turnos_caja_usuarios_idx` (`usuario_id` ASC),
  CONSTRAINT `fk_turnos_caja_usuarios`
    FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`)
    ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB;

CREATE TABLE `ventas` (
  `id`               BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `turno_caja_id`    INT UNSIGNED    NOT NULL,
  `usuario_id`       INT UNSIGNED    NOT NULL,
  `numero`           VARCHAR(20)     NOT NULL,
  `fecha`            DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `subtotal`         DECIMAL(12,2) UNSIGNED NOT NULL,
  `descuento`        DECIMAL(12,2) UNSIGNED NOT NULL DEFAULT 0.00,
  `total`            DECIMAL(12,2) UNSIGNED NOT NULL,
  `estado`           ENUM('completada','anulada') NOT NULL DEFAULT 'completada',
  `motivo_anulacion` VARCHAR(255)    NULL DEFAULT NULL,
  `anulada_por`      INT UNSIGNED    NULL DEFAULT NULL,
  `fecha_anulacion`  DATETIME        NULL DEFAULT NULL,
  `created_at`       TIMESTAMP       NULL DEFAULT NULL,
  `updated_at`       TIMESTAMP       NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `ventas_numero_UNIQUE` (`numero` ASC),
  INDEX `fk_ventas_turnos_caja_idx` (`turno_caja_id` ASC),
  INDEX `fk_ventas_usuarios_idx` (`usuario_id` ASC),
  INDEX `fk_ventas_anulada_por_idx` (`anulada_por` ASC),
  INDEX `ventas_fecha_idx` (`fecha` ASC),
  CONSTRAINT `fk_ventas_turnos_caja`
    FOREIGN KEY (`turno_caja_id`) REFERENCES `turnos_caja` (`id`)
    ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `fk_ventas_usuarios`
    FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`)
    ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `fk_ventas_anulada_por`
    FOREIGN KEY (`anulada_por`) REFERENCES `usuarios` (`id`)
    ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB;

CREATE TABLE `detalle_ventas` (
  `id`              BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `venta_id`        BIGINT UNSIGNED NOT NULL,
  `producto_id`     INT UNSIGNED    NOT NULL,
  `cantidad`        INT UNSIGNED    NOT NULL,
  `precio_unitario` DECIMAL(12,2) UNSIGNED NOT NULL,
  `subtotal`        DECIMAL(12,2) UNSIGNED NOT NULL,
  `created_at`      TIMESTAMP       NULL DEFAULT NULL,
  `updated_at`      TIMESTAMP       NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_detalle_ventas_ventas_idx` (`venta_id` ASC),
  INDEX `fk_detalle_ventas_productos_idx` (`producto_id` ASC),
  CONSTRAINT `fk_detalle_ventas_ventas`
    FOREIGN KEY (`venta_id`) REFERENCES `ventas` (`id`)
    ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `fk_detalle_ventas_productos`
    FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`)
    ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB;

CREATE TABLE `venta_pagos` (
  `id`             BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `venta_id`       BIGINT UNSIGNED NOT NULL,
  `metodo_pago_id` INT UNSIGNED    NOT NULL,
  `monto`          DECIMAL(12,2) UNSIGNED NOT NULL,
  `referencia`     VARCHAR(100)    NULL DEFAULT NULL,
  `created_at`     TIMESTAMP       NULL DEFAULT NULL,
  `updated_at`     TIMESTAMP       NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_venta_pagos_ventas_idx` (`venta_id` ASC),
  INDEX `fk_venta_pagos_metodos_pago_idx` (`metodo_pago_id` ASC),
  CONSTRAINT `fk_venta_pagos_ventas`
    FOREIGN KEY (`venta_id`) REFERENCES `ventas` (`id`)
    ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `fk_venta_pagos_metodos_pago`
    FOREIGN KEY (`metodo_pago_id`) REFERENCES `metodos_pago` (`id`)
    ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB;

CREATE TABLE `movimientos_inventario` (
  `id`               BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `producto_id`      INT UNSIGNED    NOT NULL,
  `usuario_id`       INT UNSIGNED    NOT NULL,
  `venta_id`         BIGINT UNSIGNED NULL DEFAULT NULL,
  `tipo`             ENUM('entrada','salida','ajuste','produccion','anulacion') NOT NULL,
  `cantidad`         INT UNSIGNED    NOT NULL,
  `stock_anterior`   INT             NOT NULL,
  `stock_resultante` INT             NOT NULL,
  `motivo`           VARCHAR(255)    NULL DEFAULT NULL,
  `fecha`            DATETIME        NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at`       TIMESTAMP       NULL DEFAULT NULL,
  `updated_at`       TIMESTAMP       NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_movimientos_productos_idx` (`producto_id` ASC),
  INDEX `fk_movimientos_usuarios_idx` (`usuario_id` ASC),
  INDEX `fk_movimientos_ventas_idx` (`venta_id` ASC),
  INDEX `movimientos_fecha_idx` (`fecha` ASC),
  CONSTRAINT `fk_movimientos_productos`
    FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`)
    ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `fk_movimientos_usuarios`
    FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`)
    ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `fk_movimientos_ventas`
    FOREIGN KEY (`venta_id`) REFERENCES `ventas` (`id`)
    ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB;

CREATE TABLE `arqueos` (
  `id`              INT UNSIGNED   NOT NULL AUTO_INCREMENT,
  `turno_caja_id`   INT UNSIGNED   NOT NULL,
  `usuario_id`      INT UNSIGNED   NOT NULL,
  `total_esperado`  DECIMAL(12,2) UNSIGNED NOT NULL,
  `total_declarado` DECIMAL(12,2) UNSIGNED NOT NULL,
  `diferencia`      DECIMAL(12,2)  NOT NULL,
  `observaciones`   TEXT           NULL DEFAULT NULL,
  `fecha`           DATETIME       NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at`      TIMESTAMP      NULL DEFAULT NULL,
  `updated_at`      TIMESTAMP      NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `arqueos_turno_UNIQUE` (`turno_caja_id` ASC),
  INDEX `fk_arqueos_usuarios_idx` (`usuario_id` ASC),
  CONSTRAINT `fk_arqueos_turnos_caja`
    FOREIGN KEY (`turno_caja_id`) REFERENCES `turnos_caja` (`id`)
    ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `fk_arqueos_usuarios`
    FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`)
    ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB;
