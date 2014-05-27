-- phpMyAdmin SQL Dump
-- version 2.10.2
-- http://www.phpmyadmin.net
-- 
-- Servidor: localhost
-- Tiempo de generación: 05-09-2013 a las 20:56:21
-- Versión del servidor: 5.0.45
-- Versión de PHP: 5.2.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- Base de datos: `comasd`
-- 

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `abono_reserva`
-- 

CREATE TABLE `abono_reserva` (
  `id_abono_reserva` int(11) NOT NULL auto_increment,
  `id_enc_reservacion` int(11) default NULL,
  `abono_res` decimal(8,0) default NULL,
  `fecha_abono_res` date default NULL,
  PRIMARY KEY  (`id_abono_reserva`),
  KEY `FK_RELATIONSHIP_31` (`id_enc_reservacion`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabla de abono de reservacion' AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `abono_reserva`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `accesos`
-- 

CREATE TABLE `accesos` (
  `id_acceso` int(11) NOT NULL auto_increment,
  `id_rol` int(11) default NULL,
  PRIMARY KEY  (`id_acceso`),
  KEY `FK_RELATIONSHIP_33` (`id_rol`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabla de accesos' AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `accesos`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `backups`
-- 

CREATE TABLE `backups` (
  `id` int(11) NOT NULL auto_increment,
  `nombre` varchar(50) collate utf8_bin NOT NULL,
  `fechahora` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=12 ;

-- 
-- Volcar la base de datos para la tabla `backups`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `clientes`
-- 

CREATE TABLE `clientes` (
  `id_cliente` int(11) NOT NULL auto_increment,
  `nom_cliente` varchar(50) NOT NULL,
  `ape_cliente` varchar(50) default NULL,
  `dir_cliente` varchar(100) default NULL,
  `dui_cliente` varchar(10) default NULL,
  `tel_cliente` varchar(9) default NULL,
  `email_cliente` varchar(100) default NULL,
  `fecha_ingreso` date NOT NULL,
  `recomendo` varchar(100) default NULL,
  `lugar_trabajo` varchar(100) default NULL,
  `tel_trabajo` varchar(9) default NULL,
  `observacion` varchar(500) default NULL,
  `cliente_pref` tinyint(1) default NULL,
  `cod_cliente_pref` varchar(9) default NULL,
  PRIMARY KEY  (`id_cliente`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabla de clientes' AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `clientes`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `clientes_abonos`
-- 

CREATE TABLE `clientes_abonos` (
  `id` int(11) NOT NULL auto_increment,
  `id_cliente` int(11) NOT NULL,
  `id_empleado` int(11) NOT NULL,
  `cantidad` float(10,2) NOT NULL,
  `tipo` int(1) NOT NULL,
  `fecha` date NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `clientes_abonos`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `configuracion`
-- 

CREATE TABLE `configuracion` (
  `id_configuracion` int(11) NOT NULL auto_increment,
  `nombre_configuracion` varchar(50) NOT NULL,
  `valor_configuracion` varchar(100) default NULL,
  `propietario` varchar(50) NOT NULL,
  `descrip_empresa` varchar(50) NOT NULL,
  `dir_empresa` varchar(200) NOT NULL,
  `tel_empresa` varchar(9) NOT NULL,
  `email_empresa` varchar(50) NOT NULL,
  `nit` varchar(14) NOT NULL,
  `nrc` varchar(7) NOT NULL,
  PRIMARY KEY  (`id_configuracion`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Tabla de configuración' AUTO_INCREMENT=2 ;

-- 
-- Volcar la base de datos para la tabla `configuracion`
-- 

INSERT INTO `configuracion` VALUES (1, 'NOMBRE_SITIO', 'Control System', '----------------------', '----------------------', '----------------------', '---------', '----------------------', '--------------', '-------');

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `creditos`
-- 

CREATE TABLE `creditos` (
  `id_credito` int(11) NOT NULL auto_increment,
  `fecha_cre` date NOT NULL,
  `saldo_anterior` decimal(8,0) default NULL,
  `saldo_nuevo` decimal(8,0) default NULL,
  PRIMARY KEY  (`id_credito`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabla de creditos' AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `creditos`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `departamentos`
-- 

CREATE TABLE `departamentos` (
  `id_depto` int(11) NOT NULL auto_increment,
  `nom_depto` varchar(50) NOT NULL,
  PRIMARY KEY  (`id_depto`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabla de departamentos' AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `departamentos`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `det_compras`
-- 

CREATE TABLE `det_compras` (
  `id_det_compra` int(11) NOT NULL auto_increment,
  `id_enc_compra` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `descrip_compra` varchar(100) NOT NULL,
  `precio_compra` float(10,2) NOT NULL,
  `cant_compra` decimal(8,0) default NULL,
  PRIMARY KEY  (`id_det_compra`),
  KEY `FK_RELATIONSHIP_2` (`id_enc_compra`),
  KEY `FK_RELATIONSHIP_3` (`id_producto`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabla de detalle de la compra' AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `det_compras`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `det_otros_egresos`
-- 

CREATE TABLE `det_otros_egresos` (
  `id_det_otros_egresos` int(11) NOT NULL auto_increment,
  `id_enc_otros_egresos` int(11) default NULL,
  `id_producto` int(11) NOT NULL,
  `cant_egreso` decimal(8,0) NOT NULL,
  `precio_egreso` decimal(8,2) default NULL,
  PRIMARY KEY  (`id_det_otros_egresos`),
  KEY `FK_RELATIONSHIP_26` (`id_enc_otros_egresos`),
  KEY `FK_RELATIONSHIP_43` (`id_producto`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabla de otros egresos' AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `det_otros_egresos`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `det_otros_ingresos`
-- 

CREATE TABLE `det_otros_ingresos` (
  `id_otros_ingresos` int(11) NOT NULL auto_increment,
  `id_enc_otros_ingresos` int(11) default NULL,
  `id_producto` int(11) NOT NULL,
  `nom_ingreso` varchar(50) NOT NULL,
  `DESCRIP_INGRESO` varchar(50) default NULL,
  `CANT_INGRESO` decimal(8,0) NOT NULL,
  `PRECIO_INGRESO` decimal(8,2) default NULL,
  `FRECHA_INGRESO` date NOT NULL,
  PRIMARY KEY  (`id_otros_ingresos`),
  KEY `FK_RELATIONSHIP_36` (`id_enc_otros_ingresos`),
  KEY `FK_RELATIONSHIP_42` (`id_producto`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='detalle otros ingresos' AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `det_otros_ingresos`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `det_proveedor`
-- 

CREATE TABLE `det_proveedor` (
  `id_det_proveedor` int(11) NOT NULL auto_increment,
  `id_producto` int(11) default NULL,
  `id_proveedor` int(11) default NULL,
  `descripcion` varchar(100) default NULL,
  PRIMARY KEY  (`id_det_proveedor`),
  KEY `FK_RELATIONSHIP_23` (`id_producto`),
  KEY `FK_RELATIONSHIP_24` (`id_proveedor`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabla de detalle de proveedores' AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `det_proveedor`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `det_reservacion`
-- 

CREATE TABLE `det_reservacion` (
  `id_det_reservacion` int(11) NOT NULL auto_increment,
  `id_producto` int(11) default NULL,
  `id_enc_reservacion` int(11) default NULL,
  `descrip_reser` varchar(50) NOT NULL,
  `precio` float(10,2) NOT NULL,
  `descuento` float(10,2) NOT NULL,
  `cantidad` int(11) default NULL,
  PRIMARY KEY  (`id_det_reservacion`),
  KEY `FK_RELATIONSHIP_27` (`id_producto`),
  KEY `FK_RELATIONSHIP_28` (`id_enc_reservacion`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabla de det_reservacion' AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `det_reservacion`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `det_ventas`
-- 

CREATE TABLE `det_ventas` (
  `id_det_venta` int(11) NOT NULL auto_increment,
  `id_enc_venta` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `descrip_venta` varchar(100) NOT NULL,
  `cant_venta` int(10) default NULL,
  `precio_uni_venta` float(10,2) NOT NULL,
  `precio_venta` float(10,2) NOT NULL,
  `descuento` float(10,2) NOT NULL,
  `total_venta` float(10,2) NOT NULL,
  PRIMARY KEY  (`id_det_venta`),
  KEY `FK_RELATIONSHIP_10` (`id_enc_venta`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabla de detalle de ventas' AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `det_ventas`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `empleados`
-- 

CREATE TABLE `empleados` (
  `id_empleado` int(11) NOT NULL auto_increment,
  `id_rol` int(11) NOT NULL,
  `id_depto` int(11) NOT NULL,
  `nom_empleado` varchar(50) NOT NULL,
  `ape_empleado` varchar(50) NOT NULL,
  `tel_empleado` varchar(9) NOT NULL,
  `dui_empleado` varchar(10) NOT NULL,
  `dire_empleado` varchar(100) NOT NULL,
  PRIMARY KEY  (`id_empleado`),
  KEY `FK_RELATIONSHIP_12` (`id_depto`),
  KEY `FK_RELATIONSHIP_34` (`id_rol`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabla de empleados' AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `empleados`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `enc_compras`
-- 

CREATE TABLE `enc_compras` (
  `id_enc_compra` int(11) NOT NULL auto_increment,
  `id_proveedor` int(11) NOT NULL,
  `id_empleado` int(11) default NULL,
  `fecha_compra` date NOT NULL,
  `num_compra` varchar(10) NOT NULL,
  PRIMARY KEY  (`id_enc_compra`),
  KEY `FK_RELATIONSHIP_25` (`id_empleado`),
  KEY `FK_RELATIONSHIP_9` (`id_proveedor`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabla del encabezado de compras' AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `enc_compras`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `enc_otros_egresos`
-- 

CREATE TABLE `enc_otros_egresos` (
  `id_enc_otros_egresos` int(11) NOT NULL auto_increment,
  `descrip_egreso` varchar(50) default NULL,
  `num_factura` varchar(50) NOT NULL,
  `fecha_egreso` date NOT NULL,
  `monto` float(10,2) NOT NULL,
  PRIMARY KEY  (`id_enc_otros_egresos`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Tabla de encabezado de otros egresos' AUTO_INCREMENT=2 ;

-- 
-- Volcar la base de datos para la tabla `enc_otros_egresos`
-- 

INSERT INTO `enc_otros_egresos` VALUES (1, 'Cambio de talla', 'F000001', '2013-08-09', 10.00);

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `enc_otros_ingresos`
-- 

CREATE TABLE `enc_otros_ingresos` (
  `id_enc_otros_ingresos` int(11) NOT NULL auto_increment,
  `descrip_ingreso` varchar(50) default NULL,
  `fecha_ingreso` date NOT NULL,
  PRIMARY KEY  (`id_enc_otros_ingresos`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabla de encabezado de otros egresos' AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `enc_otros_ingresos`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `enc_reservacion`
-- 

CREATE TABLE `enc_reservacion` (
  `id_enc_reservacion` int(11) NOT NULL auto_increment,
  `id_empleado` int(11) default NULL,
  `id_cliente` int(11) NOT NULL,
  `numero` varchar(20) NOT NULL,
  `fecha_reservacion` date default NULL,
  `saldo` float(10,2) default NULL,
  `generado` char(2) NOT NULL default 'No',
  PRIMARY KEY  (`id_enc_reservacion`),
  KEY `FK_RELATIONSHIP_29` (`id_empleado`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabla de enc_reservacion' AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `enc_reservacion`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `enc_reservacion_abonos`
-- 

CREATE TABLE `enc_reservacion_abonos` (
  `id` int(11) NOT NULL auto_increment,
  `id_enc_reservacion` int(11) NOT NULL,
  `id_empleado` int(11) NOT NULL,
  `cantidad` float(10,2) NOT NULL,
  `fecha` date NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- 
-- Volcar la base de datos para la tabla `enc_reservacion_abonos`
-- 

INSERT INTO `enc_reservacion_abonos` VALUES (1, 1, 1, 10.00, '2013-08-21');
INSERT INTO `enc_reservacion_abonos` VALUES (2, 1, 1, 12.32, '2013-08-21');

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `enc_ventas`
-- 

CREATE TABLE `enc_ventas` (
  `id_enc_venta` int(11) NOT NULL auto_increment,
  `id_credito` int(11) default NULL,
  `id_cliente` int(11) NOT NULL,
  `id_empleado` int(11) NOT NULL,
  `fecha_venta` date NOT NULL,
  `num_factu_venta` varchar(50) NOT NULL,
  `condicion_pago` int(1) NOT NULL,
  `monto` decimal(10,2) NOT NULL,
  PRIMARY KEY  (`id_enc_venta`),
  KEY `FK_RELATIONSHIP_21` (`id_credito`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabla del encabezado de ventas' AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `enc_ventas`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `inventario`
-- 

CREATE TABLE `inventario` (
  `id_inventario` int(11) NOT NULL auto_increment,
  `id_otros_ingresos` int(11) default NULL,
  `id_det_otros_egresos` int(11) default NULL,
  `id_det_compra` int(11) default NULL,
  `id_det_venta` int(11) default NULL,
  `saldo_existente` int(10) default NULL,
  `cant_entrada` int(10) NOT NULL,
  `cant_salida` int(10) default NULL,
  `fecha_movimiento` date NOT NULL,
  PRIMARY KEY  (`id_inventario`),
  KEY `FK_RELATIONSHIP_38` (`id_otros_ingresos`),
  KEY `FK_RELATIONSHIP_39` (`id_det_otros_egresos`),
  KEY `FK_RELATIONSHIP_40` (`id_det_compra`),
  KEY `FK_RELATIONSHIP_41` (`id_det_venta`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='detalle de inventario' AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `inventario`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `marcas`
-- 

CREATE TABLE `marcas` (
  `id_marca` int(11) NOT NULL auto_increment,
  `nom_marca` varchar(50) NOT NULL,
  PRIMARY KEY  (`id_marca`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabla de marcas' AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `marcas`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `modulos`
-- 

CREATE TABLE `modulos` (
  `id_modulo` int(11) NOT NULL auto_increment,
  `nombre_modulo` varchar(50) default NULL,
  `orden` int(11) NOT NULL,
  PRIMARY KEY  (`id_modulo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='tabla de modulos: sirve para colocar los campos de modulos e' AUTO_INCREMENT=10 ;

-- 
-- Volcar la base de datos para la tabla `modulos`
-- 

INSERT INTO `modulos` VALUES (1, 'Inicio', 1);
INSERT INTO `modulos` VALUES (2, 'Registros', 2);
INSERT INTO `modulos` VALUES (3, 'Créditos', 3);
INSERT INTO `modulos` VALUES (4, 'Reservaciones', 4);
INSERT INTO `modulos` VALUES (5, 'Facturación', 5);
INSERT INTO `modulos` VALUES (6, 'Inventario', 6);
INSERT INTO `modulos` VALUES (7, 'Seguridad', 8);
INSERT INTO `modulos` VALUES (9, 'Reportes', 7);

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `productos`
-- 

CREATE TABLE `productos` (
  `id_producto` int(11) NOT NULL auto_increment,
  `id_marca` int(11) NOT NULL,
  `id_depto` int(11) NOT NULL,
  `id_inventario` int(11) default NULL,
  `cod_producto` varchar(20) default NULL,
  `nom_producto` varchar(50) NOT NULL,
  `fecha_pedido` date NOT NULL,
  `precio1` decimal(8,2) default NULL,
  `precio2` decimal(8,2) default NULL,
  `precio3` decimal(8,2) NOT NULL,
  `costo_producto` decimal(8,2) NOT NULL,
  `existencia` int(10) NOT NULL,
  `descrip_corta` varchar(25) default NULL,
  `descrip_larga` varchar(50) default NULL,
  PRIMARY KEY  (`id_producto`),
  KEY `FK_RELATIONSHIP_11` (`id_depto`),
  KEY `FK_RELATIONSHIP_37` (`id_inventario`),
  KEY `FK_RELATIONSHIP_5` (`id_marca`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabla de productos' AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `productos`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `proveedores`
-- 

CREATE TABLE `proveedores` (
  `id_proveedor` int(11) NOT NULL auto_increment,
  `nom_proveedor` varchar(50) NOT NULL,
  `tel_proveedor` varchar(9) default NULL,
  `dir_proveedor` varchar(100) NOT NULL,
  `email_proveedor` varchar(50) default NULL,
  `nom_contacto` varchar(25) default NULL,
  `tel_contacto` varchar(9) default NULL,
  PRIMARY KEY  (`id_proveedor`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabla de proveedores' AUTO_INCREMENT=1 ;

-- 
-- Volcar la base de datos para la tabla `proveedores`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `roles`
-- 

CREATE TABLE `roles` (
  `id_rol` int(11) NOT NULL auto_increment,
  `nom_cargo` varchar(50) NOT NULL,
  PRIMARY KEY  (`id_rol`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Tabla de roles' AUTO_INCREMENT=5 ;

-- 
-- Volcar la base de datos para la tabla `roles`
-- 

INSERT INTO `roles` VALUES (1, 'Administrador');
INSERT INTO `roles` VALUES (2, 'Empleado');
INSERT INTO `roles` VALUES (3, 'Cajero');
INSERT INTO `roles` VALUES (4, 'Contador');

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `secciones`
-- 

CREATE TABLE `secciones` (
  `id_seccion` int(11) NOT NULL auto_increment,
  `id_modulo` int(11) default NULL,
  `nombre_seccion` varchar(100) default NULL,
  `url_seccion` varchar(200) default NULL,
  `icono` varchar(20) NOT NULL,
  `visible` int(1) NOT NULL,
  PRIMARY KEY  (`id_seccion`),
  KEY `FK_RELATIONSHIP_46` (`id_modulo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='tabla secciones conecta con modulos' AUTO_INCREMENT=24 ;

-- 
-- Volcar la base de datos para la tabla `secciones`
-- 

INSERT INTO `secciones` VALUES (2, 7, 'Backup', 'backup', '', 0);
INSERT INTO `secciones` VALUES (3, 3, 'Clientes', 'clientes', 'client.png', 1);
INSERT INTO `secciones` VALUES (4, 2, 'Marcas', 'marcas', '', 0);
INSERT INTO `secciones` VALUES (5, 1, 'Empresa', 'empresa', 'empresa.png', 1);
INSERT INTO `secciones` VALUES (6, 2, 'Empleados', 'empleados', 'empleado.png', 0);
INSERT INTO `secciones` VALUES (7, 2, 'Productos', 'productos', 'product.png', 1);
INSERT INTO `secciones` VALUES (8, 2, 'Proveedores', 'proveedores', '', 0);
INSERT INTO `secciones` VALUES (9, 2, 'Departamentos', 'departamentos', '', 0);
INSERT INTO `secciones` VALUES (10, 2, 'Cargos', 'roles', '', 0);
INSERT INTO `secciones` VALUES (12, 4, 'Reservación', 'reservaciones', 'reservacion.png', 1);
INSERT INTO `secciones` VALUES (13, 7, 'Usuarios', 'cuentas', 'user.png', 1);
INSERT INTO `secciones` VALUES (14, 5, 'Facturar', 'facturas', 'doc.png', 1);
INSERT INTO `secciones` VALUES (16, 6, 'Compras', 'compras', '', 0);
INSERT INTO `secciones` VALUES (19, 9, 'Productos existencia', 'reportes/productos_existencia', '', 0);
INSERT INTO `secciones` VALUES (20, 9, 'Ventas', 'reportes/ventas', '', 0);
INSERT INTO `secciones` VALUES (21, 9, 'Compras', 'reportes/compras', '', 0);
INSERT INTO `secciones` VALUES (22, 9, 'Reservaciones', 'reportes/reservaciones', '', 0);
INSERT INTO `secciones` VALUES (23, 9, 'Clientes', 'reportes/clientes', '', 0);

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `usuarios`
-- 

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL auto_increment,
  `id_rol` int(11) default NULL,
  `nom_usuario` varchar(100) default NULL,
  `nick_usuario` varchar(20) NOT NULL,
  `clave_usuario` varchar(10) NOT NULL,
  `email_usuario` varchar(100) default NULL,
  `nivel_usuario` int(11) default NULL,
  PRIMARY KEY  (`id_usuario`),
  KEY `FK_RELATIONSHIP_32` (`id_rol`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Tabla de usuarios' AUTO_INCREMENT=4 ;

-- 
-- Volcar la base de datos para la tabla `usuarios`
-- 

INSERT INTO `usuarios` VALUES (2, NULL, 'Administrador', 'admin', '123', 'admin@hotmail.com', 1);

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `usuarios_secciones`
-- 

CREATE TABLE `usuarios_secciones` (
  `id_usuario` int(11) NOT NULL,
  `id_seccion` int(11) NOT NULL,
  KEY `Index 1` (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 
-- Volcar la base de datos para la tabla `usuarios_secciones`
-- 

INSERT INTO `usuarios_secciones` VALUES (2, 13);
INSERT INTO `usuarios_secciones` VALUES (2, 2);
INSERT INTO `usuarios_secciones` VALUES (2, 14);
INSERT INTO `usuarios_secciones` VALUES (2, 3);
INSERT INTO `usuarios_secciones` VALUES (2, 5);
INSERT INTO `usuarios_secciones` VALUES (2, 4);
INSERT INTO `usuarios_secciones` VALUES (2, 6);
INSERT INTO `usuarios_secciones` VALUES (2, 7);
INSERT INTO `usuarios_secciones` VALUES (2, 8);
INSERT INTO `usuarios_secciones` VALUES (2, 9);
INSERT INTO `usuarios_secciones` VALUES (2, 10);
INSERT INTO `usuarios_secciones` VALUES (2, 12);
INSERT INTO `usuarios_secciones` VALUES (2, 16);
INSERT INTO `usuarios_secciones` VALUES (2, 17);
INSERT INTO `usuarios_secciones` VALUES (2, 18);
INSERT INTO `usuarios_secciones` VALUES (2, 19);

-- 
-- Filtros para las tablas descargadas (dump)
-- 

-- 
-- Filtros para la tabla `abono_reserva`
-- 
ALTER TABLE `abono_reserva`
  ADD CONSTRAINT `FK_RELATIONSHIP_31` FOREIGN KEY (`id_enc_reservacion`) REFERENCES `enc_reservacion` (`id_enc_reservacion`);

-- 
-- Filtros para la tabla `accesos`
-- 
ALTER TABLE `accesos`
  ADD CONSTRAINT `FK_RELATIONSHIP_33` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id_rol`);

-- 
-- Filtros para la tabla `det_compras`
-- 
ALTER TABLE `det_compras`
  ADD CONSTRAINT `FK_RELATIONSHIP_2` FOREIGN KEY (`id_enc_compra`) REFERENCES `enc_compras` (`id_enc_compra`),
  ADD CONSTRAINT `FK_RELATIONSHIP_3` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`);

-- 
-- Filtros para la tabla `det_otros_egresos`
-- 
ALTER TABLE `det_otros_egresos`
  ADD CONSTRAINT `FK_RELATIONSHIP_26` FOREIGN KEY (`id_enc_otros_egresos`) REFERENCES `enc_otros_egresos` (`id_enc_otros_egresos`),
  ADD CONSTRAINT `FK_RELATIONSHIP_43` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`);

-- 
-- Filtros para la tabla `det_otros_ingresos`
-- 
ALTER TABLE `det_otros_ingresos`
  ADD CONSTRAINT `FK_RELATIONSHIP_36` FOREIGN KEY (`id_enc_otros_ingresos`) REFERENCES `enc_otros_ingresos` (`id_enc_otros_ingresos`),
  ADD CONSTRAINT `FK_RELATIONSHIP_42` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`);

-- 
-- Filtros para la tabla `det_proveedor`
-- 
ALTER TABLE `det_proveedor`
  ADD CONSTRAINT `FK_RELATIONSHIP_23` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`),
  ADD CONSTRAINT `FK_RELATIONSHIP_24` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedores` (`id_proveedor`);

-- 
-- Filtros para la tabla `det_reservacion`
-- 
ALTER TABLE `det_reservacion`
  ADD CONSTRAINT `FK_RELATIONSHIP_27` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`),
  ADD CONSTRAINT `FK_RELATIONSHIP_28` FOREIGN KEY (`id_enc_reservacion`) REFERENCES `enc_reservacion` (`id_enc_reservacion`);

-- 
-- Filtros para la tabla `det_ventas`
-- 
ALTER TABLE `det_ventas`
  ADD CONSTRAINT `FK_RELATIONSHIP_10` FOREIGN KEY (`id_enc_venta`) REFERENCES `enc_ventas` (`id_enc_venta`);

-- 
-- Filtros para la tabla `empleados`
-- 
ALTER TABLE `empleados`
  ADD CONSTRAINT `FK_RELATIONSHIP_12` FOREIGN KEY (`id_depto`) REFERENCES `departamentos` (`id_depto`),
  ADD CONSTRAINT `FK_RELATIONSHIP_34` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id_rol`);

-- 
-- Filtros para la tabla `enc_compras`
-- 
ALTER TABLE `enc_compras`
  ADD CONSTRAINT `FK_RELATIONSHIP_25` FOREIGN KEY (`id_empleado`) REFERENCES `empleados` (`id_empleado`),
  ADD CONSTRAINT `FK_RELATIONSHIP_9` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedores` (`id_proveedor`);

-- 
-- Filtros para la tabla `enc_reservacion`
-- 
ALTER TABLE `enc_reservacion`
  ADD CONSTRAINT `FK_RELATIONSHIP_29` FOREIGN KEY (`id_empleado`) REFERENCES `empleados` (`id_empleado`);

-- 
-- Filtros para la tabla `enc_ventas`
-- 
ALTER TABLE `enc_ventas`
  ADD CONSTRAINT `FK_RELATIONSHIP_21` FOREIGN KEY (`id_credito`) REFERENCES `creditos` (`id_credito`);

-- 
-- Filtros para la tabla `inventario`
-- 
ALTER TABLE `inventario`
  ADD CONSTRAINT `FK_RELATIONSHIP_38` FOREIGN KEY (`id_otros_ingresos`) REFERENCES `det_otros_ingresos` (`id_otros_ingresos`),
  ADD CONSTRAINT `FK_RELATIONSHIP_39` FOREIGN KEY (`id_det_otros_egresos`) REFERENCES `det_otros_egresos` (`id_det_otros_egresos`),
  ADD CONSTRAINT `FK_RELATIONSHIP_40` FOREIGN KEY (`id_det_compra`) REFERENCES `det_compras` (`id_det_compra`),
  ADD CONSTRAINT `FK_RELATIONSHIP_41` FOREIGN KEY (`id_det_venta`) REFERENCES `det_ventas` (`id_det_venta`);

-- 
-- Filtros para la tabla `productos`
-- 
ALTER TABLE `productos`
  ADD CONSTRAINT `FK_RELATIONSHIP_11` FOREIGN KEY (`id_depto`) REFERENCES `departamentos` (`id_depto`),
  ADD CONSTRAINT `FK_RELATIONSHIP_37` FOREIGN KEY (`id_inventario`) REFERENCES `inventario` (`id_inventario`),
  ADD CONSTRAINT `FK_RELATIONSHIP_5` FOREIGN KEY (`id_marca`) REFERENCES `marcas` (`id_marca`);

-- 
-- Filtros para la tabla `secciones`
-- 
ALTER TABLE `secciones`
  ADD CONSTRAINT `FK_RELATIONSHIP_46` FOREIGN KEY (`id_modulo`) REFERENCES `modulos` (`id_modulo`);

-- 
-- Filtros para la tabla `usuarios`
-- 
ALTER TABLE `usuarios`
  ADD CONSTRAINT `FK_RELATIONSHIP_32` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id_rol`);

-- 
-- Filtros para la tabla `usuarios_secciones`
-- 
ALTER TABLE `usuarios_secciones`
  ADD CONSTRAINT `FK_usuarios_secciones_usuarios` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;
