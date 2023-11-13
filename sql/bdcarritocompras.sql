-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 15-10-2018 a las 23:12:45
-- Versión del servidor: 10.1.34-MariaDB
-- Versión de PHP: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

DROP DATABASE bdcarritocompras;
CREATE DATABASE bdcarritocompras;
USE bdcarritocompras;

--
-- Base de datos: `bdcarritocompras`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra`
--

CREATE TABLE `compra` (
  `idCompra` bigint(20) NOT NULL,
  `coFecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `idUsuario` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compraestado`
--

CREATE TABLE `compraEstado` (
  `idCompraEstado` bigint(20) UNSIGNED NOT NULL,
  `idCompra` bigint(11) NOT NULL,
  `idCompraestadoTipo` int(11) NOT NULL,
  `ceFechaIni` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ceFechaFin` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compraestadotipo`
--

CREATE TABLE `compraEstadoTipo` (
  `idCompraEstadoTipo` int(11) NOT NULL,
  `cetDescripcion` varchar(50) NOT NULL,
  `cetDetalle` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `compraestadotipo`
--

INSERT INTO `compraEstadoTipo` (`idCompraEstadoTipo`, `cetDescripcion`, `cetDetalle`) VALUES
(1, 'iniciada', 'cuando el usuario : cliente inicia la compra de uno o mas productos del carrito'),
(2, 'aceptada', 'cuando el usuario administrador da ingreso a uno de las compras en estado = 1 '),
(3, 'enviada', 'cuando el usuario administrador envia a uno de las compras en estado =2 '),
(4, 'cancelada', 'un usuario administrador podra cancelar una compra en cualquier estado y un usuario cliente solo en estado=1 ');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compraitem`
--

CREATE TABLE `compraItem` (
  `idCompraItem` bigint(20) UNSIGNED NOT NULL,
  `idProducto` bigint(20) NOT NULL,
  `idCompra` bigint(20) NOT NULL,
  `ciCantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menu`
--

CREATE TABLE `menu` (
  `idMenu` bigint(20) NOT NULL,
  `meNombre` varchar(50) NOT NULL COMMENT 'Nombre del item del menu',
  `meDescripcion` varchar(124) NOT NULL COMMENT 'Descripcion mas detallada del item del menu',
  `idPadre` bigint(20) DEFAULT NULL COMMENT 'Referencia al id del menu que es subitem',
  `meDeshabilitado` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha en la que el menu fue deshabilitado por ultima vez'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `menu`
--

INSERT INTO `menu` (`idMenu`, `meNombre`, `meDescripcion`, `idPadre`, `meDeshabilitado`) VALUES
-- cliente:
(1, 'Productos', '../productos/productos.php', NULL, NULL),
(2, 'Mi Perfil', '../usuarios/perfil.php', NULL, NULL), -- MODIFICADO!!!, Ahora todos los roles tienen acceso a esto
(3, 'Carrito', '../carrito/carrito.php', NULL, NULL),
(4, 'Mis Compras', '../usuarios/compras.php', NULL, NULL),
-- deposito:
(5, 'Gestionar Articulos', '../articulos/gestionarArticulos.php', NULL, NULL),
(6, 'Gestionar Compras', '../compras/gestionarCompras.php', NULL, NULL),
-- admin:
(7, 'Gestionar Usuarios', '../usuarios/usuarios.php', NULL, NULL),
(8, 'Gestionar Roles', '../roles/roles.php', NULL, NULL),
(9, 'Gestionar Menus', '../menus/menus.php', NULL, NULL),
-- Usuario sin rol:
(10, 'Iniciar Sesion', '../acceso/login.php', NULL, NULL),
(11, 'Registrarse', '../acceso/registrarse.php', NULL, NULL),
(12, 'Home', '../home/index.php', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menurol`
--

CREATE TABLE `menuRol` (
  `idMenu` bigint(20) NOT NULL,
  `idRol` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `menurol`
--
INSERT INTO `menuRol` (`idMenu`, `idRol`) VALUES
-- 1 - admin
-- 2 - cliente
-- 3 - deposito
-- Cliente:
(12, 2),
(1, 2),
(3, 2),
(4, 2),
(2, 2),
-- Deposito:
(12, 3),
(5, 3),
(6, 3),
(2, 3), -- Modificado!!!
-- Admin:
(12, 1),
(7, 1),
(8, 1),
(9, 1),
(2, 1); -- Modificado!!!


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `idProducto` bigint(20) NOT NULL,
  `proNombre` varchar(50) NOT NULL, -- !!! MODIFICACDO ANTES ERA: `proNombre` int(11) NOT NULL,
  `proDetalle` varchar(512) NOT NULL,
  `proCantStock` int(11) NOT NULL,
  `proPrecio` int(11) NOT NULL, -- NUEVO!!!
  `proImagen` varchar(200) NOT NULL, -- NUEVO!!!
  `proDeshabilitado` timestamp NULL DEFAULT NULL -- NUEVO!!!
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `producto` (`idProducto`, `proNombre`, `proDetalle`, `proCantStock`, `proPrecio`,`proImagen`, `prodeshabilitado`) VALUES
(1, 'Dulce de leche', 'Marca la serenisima', 10, 1000, 'nombreImagen.extension', null),
(2, 'Cafe', 'Marca cabrales', 10, 10000, 'nombreImagen.extension', null),
(3, 'estoyDeshabilitado', 'No deberia verse', 10000000000000000000, 100000000000000000000, 'deshabilitado', '2023-11-11 21:43:23');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `idRol` bigint(20) NOT NULL,
  `rolDescripcion` varchar(50) NOT NULL
  `rolDeshabilitado` timestamp NULL DEFAULT NULL -- NUEVO!!!

) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`idRol`, `rolDescripcion`,`rolDeshabilitado`) VALUES
(1, 'admin',null),
(2, 'cliente',null),
(3, 'deposito',null);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `idUsuario` bigint(20) NOT NULL,
  `usNombre` varchar(50) NOT NULL,
  `usPass` varchar(50) NOT NULL, -- MODIFICADO!!! ANTES ERA: int(11)
  `usMail` varchar(50) NOT NULL,
  `usDeshabilitado` timestamp NULL DEFAULT NULL 
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idUsuario`, `usNombre`, `usPass`, `usMail`, `usDeshabilitado`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin@admin.com', null),
(2, 'cliente', '4983a0ab83ed86e0e7213c8783940193', 'cliente@cliente.com', null),
(3, 'deposito', 'caaf856169610904e4f188e6ee23e88c', 'deposito@deposito.com', null),
(4, 'deshabilitado', 'add0296c267f58af06b223537e0bff66', 'deshabilitado@deshabilitado.com', '2023-11-11 21:43:23');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuariorol`
--

CREATE TABLE `usuarioRol` (
  `idUsuario` bigint(20) NOT NULL,
  `idRol` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
--
--

INSERT INTO `usuarioRol` (`idUsuario`, `idRol`) VALUES
(4, 1),
(4, 2),
(4, 3),
(1, 1),
(2, 2),
(3, 3);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `compra`
--
ALTER TABLE `compra`
  ADD PRIMARY KEY (`idCompra`),
  ADD UNIQUE KEY `idCompra` (`idCompra`),
  ADD KEY `fkcompra_1` (`idUsuario`);

--
-- Indices de la tabla `compraestado`
--
ALTER TABLE `compraEstado`
  ADD PRIMARY KEY (`idCompraEstado`),
  ADD UNIQUE KEY `idCompraEstado` (`idCompraEstado`),
  ADD KEY `fkcompraEstado_1` (`idCompra`),
  ADD KEY `fkcompraEstado_2` (`idCompraEstadoTipo`);

--
-- Indices de la tabla `compraestadotipo`
--
ALTER TABLE `compraEstadoTipo`
  ADD PRIMARY KEY (`idCompraEstadoTipo`);

--
-- Indices de la tabla `compraitem`
--
ALTER TABLE `compraItem`
  ADD PRIMARY KEY (`idCompraItem`),
  ADD UNIQUE KEY `idCompraItem` (`idCompraItem`),
  ADD KEY `fkcompraItem_1` (`idCompra`),
  ADD KEY `fkcompraItem_2` (`idProducto`);

--
-- Indices de la tabla `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`idMenu`),
  ADD UNIQUE KEY `idMenu` (`idMenu`),
  ADD KEY `fkmenu_1` (`idPadre`);

--
-- Indices de la tabla `menurol`
--
ALTER TABLE `menuRol`
  ADD PRIMARY KEY (`idMenu`,`idRol`),
  ADD KEY `fkmenuRol_2` (`idRol`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`idProducto`),
  ADD UNIQUE KEY `idProducto` (`idProducto`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`idRol`),
  ADD UNIQUE KEY `idRol` (`idRol`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idUsuario`),
  ADD UNIQUE KEY `idUsuario` (`idUsuario`);

--
-- Indices de la tabla `usuariorol`
--
ALTER TABLE `usuarioRol`
  ADD PRIMARY KEY (`idUsuario`,`idRol`),
  ADD KEY `idUsuario` (`idUsuario`),
  ADD KEY `idRol` (`idRol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `compra`
--
ALTER TABLE `compra`
  MODIFY `idCompra` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `compraestado`
--
ALTER TABLE `compraEstado`
  MODIFY `idCompraEstado` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `compraitem`
--
ALTER TABLE `compraItem`
  MODIFY `idCompraItem` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `menu`
--
ALTER TABLE `menu`
  MODIFY `idMenu` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `idProducto` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `idRol` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idUsuario` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `compra`
--
ALTER TABLE `compra`
  ADD CONSTRAINT `fkcompra_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `compraestado`
--
ALTER TABLE `compraEstado`
  ADD CONSTRAINT `fkcompraEstado_1` FOREIGN KEY (`idCompra`) REFERENCES `compra` (`idCompra`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fkcompraEstado_2` FOREIGN KEY (`idCompraEstadoTipo`) REFERENCES `compraEstadoTipo` (`idCompraEstadoTipo`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `compraitem`
--
ALTER TABLE `compraItem`
  ADD CONSTRAINT `fkcompraItem_1` FOREIGN KEY (`idCompra`) REFERENCES `compra` (`idCompra`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fkcompraItem_2` FOREIGN KEY (`idProducto`) REFERENCES `producto` (`idProducto`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `menu`
--
ALTER TABLE `menu`
  ADD CONSTRAINT `fkmenu_1` FOREIGN KEY (`idPadre`) REFERENCES `menu` (`idMenu`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `menurol`
--
ALTER TABLE `menuRol`
  ADD CONSTRAINT `fkmenuRol_1` FOREIGN KEY (`idMenu`) REFERENCES `menu` (`idMenu`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fkmenuRol_2` FOREIGN KEY (`idRol`) REFERENCES `rol` (`idRol`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuariorol`
--
ALTER TABLE `usuarioRol`
  ADD CONSTRAINT `fkmovimiento_1` FOREIGN KEY (`idRol`) REFERENCES `rol` (`idRol`) ON UPDATE CASCADE,
  ADD CONSTRAINT `usuarioRol_ibfk_2` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
