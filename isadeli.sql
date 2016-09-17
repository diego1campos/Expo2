-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-08-2016 a las 00:55:35
-- Versión del servidor: 10.1.9-MariaDB
-- Versión de PHP: 5.6.15
create database isadeli;
  use isadeli;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `isadeli`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `inserta_bitacora` (IN `id_empleado` INT, IN `id_tabla` INT, IN `id_tipo_accion` INT, IN `descripcion` VARCHAR(200))  SQL SECURITY INVOKER
BEGIN
DECLARE fecha datetime DEFAULT (select now());
INSERT INTO bitacora
(`id_empleado`,
`id_tabla`,
`id_tipo_accion`,
`descripcion`,
`fecha_ingreso`
)
VALUES (
id_empleado,
id_tabla,
id_tipo_accion,
descripcion,
fecha
 );
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bitacora`
--

CREATE TABLE `bitacora` (
  `id_bitacora` int(11) NOT NULL,
  `id_empleado` int(11) NOT NULL,
  `id_tabla` int(11) NOT NULL,
  `id_tipo_accion` int(11) NOT NULL,
  `descripcion` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `fecha_ingreso` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calificacion_productos`
--

CREATE TABLE `calificacion_productos` (
  `id_calificacion_producto` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `calificacion_producto` decimal(2,1) NOT NULL,
  `fecha_ingreso` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito`
--

CREATE TABLE `carrito` (
  `id_carrito` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_img_producto` int(11) NOT NULL,
  `cantidad_producto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id_categoria` int(11) NOT NULL,
  `categoria` varchar(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id_categoria`, `categoria`) VALUES
(3, 'weqwe');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id_cliente` int(11) NOT NULL,
  `id_tipo_usuario` int(11) NOT NULL,
  `nombres_cliente` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `apellidos_cliente` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `correo` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `usuario` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `clave` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `id_pregunta` int(11) NOT NULL,
  `respuesta` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `img_cliente` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fecha_registro` datetime NOT NULL,
  `estado_sesion` varchar(200) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id_cliente`, `id_tipo_usuario`, `nombres_cliente`, `apellidos_cliente`, `correo`, `usuario`, `clave`, `id_pregunta`, `respuesta`, `img_cliente`, `fecha_registro`, `estado_sesion`) VALUES
(1, 1, 'diego', 'campos', 'hola', 'ouahd', '$2y$10$7644AAdafSpSyP8OnKpIi.kvy.wGHqB/ZgCtOG8xZptwrubM6VTk.', 1, '$2y$10$t0qkcEwOi32aOHRsjYGPAuIIIeskCd1TyPwab6Z3ai0eInU5rLrUK', 'IMG-20140315-00521.jpg', '2016-05-15 09:26:00', '9c8rvsqohdt0f3re6jd9uhd836');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentarios_productos`
--

CREATE TABLE `comentarios_productos` (
  `id_comentario` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `estado_comentario` tinyint(1) NOT NULL,
  `comentario_producto` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `fecha_ingreso` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `comentarios_productos`
--

INSERT INTO `comentarios_productos` (`id_comentario`, `id_cliente`, `id_producto`, `estado_comentario`, `comentario_producto`, `fecha_ingreso`) VALUES
(1, 1, 1, 1, 'axaxax', '2016-07-25 04:33:28');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contactos_empresa`
--

CREATE TABLE `contactos_empresa` (
  `id_contacto_empresa` int(11) NOT NULL,
  `id_tipo_contacto` int(11) NOT NULL,
  `contacto_empresa` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `contactos_empresa`
--

INSERT INTO `contactos_empresa` (`id_contacto_empresa`, `id_tipo_contacto`, `contacto_empresa`) VALUES
(1, 1, '2282-4712'),
(2, 2, 'isadeli_@gmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `datos`
--

CREATE TABLE `datos` (
  `id_dato` int(11) NOT NULL,
  `historia` varchar(2000) COLLATE utf8_unicode_ci NOT NULL,
  `mision` varchar(2000) COLLATE utf8_unicode_ci NOT NULL,
  `vision` varchar(2000) COLLATE utf8_unicode_ci NOT NULL,
  `valores` varchar(2000) COLLATE utf8_unicode_ci NOT NULL,
  `logo` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `direcciones` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `min_pro_pedido` int(11) NOT NULL,
  `cargo_pedidos` decimal(4,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `datos`
--

INSERT INTO `datos` (`id_dato`, `historia`, `mision`, `vision`, `valores`, `logo`, `direcciones`, `min_pro_pedido`, `cargo_pedidos`) VALUES
(1, 'as', 'as', 'a', 'a', 'a', 'a', 1, '7.65');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalles_pedidos`
--

CREATE TABLE `detalles_pedidos` (
  `id_detalles_pedido` int(11) NOT NULL,
  `id_pedido` int(11) NOT NULL,
  `id_img_producto` int(11) NOT NULL,
  `cantidad_producto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `detalles_pedidos`
--

INSERT INTO `detalles_pedidos` (`id_detalles_pedido`, `id_pedido`, `id_img_producto`, `cantidad_producto`) VALUES
(6, 2, 1, 1),
(7, 2, 2, 1),
(8, 2, 3, 1),
(9, 2, 4, 1),
(10, 2, 5, 1),
(11, 3, 2, 10),
(12, 3, 6, 10),
(13, 3, 4, 10),
(14, 3, 3, 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalles_pedidos_local`
--

CREATE TABLE `detalles_pedidos_local` (
  `id_detalles_pedido_local` int(11) NOT NULL,
  `id_pedido_local` int(11) NOT NULL,
  `id_img_producto` int(11) NOT NULL,
  `cantidad_producto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `detalles_pedidos_local`
--

INSERT INTO `detalles_pedidos_local` (`id_detalles_pedido_local`, `id_pedido_local`, `id_img_producto`, `cantidad_producto`) VALUES
(1, 1, 1, 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `direcciones`
--

CREATE TABLE `direcciones` (
  `id_direccion` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `direccion` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `direcciones`
--

INSERT INTO `direcciones` (`id_direccion`, `id_cliente`, `direccion`) VALUES
(6, 1, 'asdasd'),
(7, 1, 'asdasdasd'),
(5, 1, 'col'),
(3, 1, 'Col jamien casa asdasd'),
(4, 1, 'Col. Dolores #33 , casa cionmunla. iansdiasd 464'),
(1, 1, 'col. san pablo, casa 33'),
(8, 1, 'dfdfdffddf'),
(2, 1, 'Ha');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `id_empleado` int(11) NOT NULL,
  `id_tipo_usuario` int(11) NOT NULL,
  `nombres_empleado` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `apellidos_empleado` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `n_documento` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `correo` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `usuario` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `clave` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `id_pregunta` int(11) NOT NULL,
  `respuesta` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `img_empleado` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `fecha_registro` datetime NOT NULL,
  `fecha_nacimiento` datetime NOT NULL,
  `estado_sesion` varchar(200) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`id_empleado`, `id_tipo_usuario`, `nombres_empleado`, `apellidos_empleado`, `n_documento`, `correo`, `usuario`, `clave`, `id_pregunta`, `respuesta`, `img_empleado`, `fecha_registro`, `fecha_nacimiento`, `estado_sesion`) VALUES
(1, 1, 'h', 'f', '121', 'asf', 'asf2', 'afas', 1, 'as', 'IMG-20140315-00521.jpg', '2015-05-22 00:00:00', '2015-04-22 00:00:00', '0'),
(2, 1, 'diego', 'campos', '998766541', 'laura@hotmail.com', 'diego', '$2y$10$jkgkufpEIKyRWDt8KG6V4efcDnnGd.5JoQzq.sGVHjl.vUxlUSuQS', 1, '$2y$10$t0qkcEwOi32aOHRsjYGPAuIIIeskCd1TyPwab6Z3ai0eInU5rLrUK', 'Array', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'oa9uq9o1ja20m9tp4qkvesj6i7');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entregar_pedidos`
--

CREATE TABLE `entregar_pedidos` (
  `id_entrega_pedido` int(11) NOT NULL,
  `id_empleado` int(11) NOT NULL,
  `id_pedido` int(11) NOT NULL,
  `fecha_entrega` datetime NOT NULL,
  `estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `entregar_pedidos`
--

INSERT INTO `entregar_pedidos` (`id_entrega_pedido`, `id_empleado`, `id_pedido`, `fecha_entrega`, `estado`) VALUES
(7, 1, 2, '2016-07-17 11:26:34', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `existencias`
--

CREATE TABLE `existencias` (
  `id_existencia` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `id_presentacion` int(11) NOT NULL,
  `existencias` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `existencias`
--

INSERT INTO `existencias` (`id_existencia`, `id_producto`, `id_presentacion`, `existencias`) VALUES
(4, 1, 2, 60),
(5, 1, 3, 0),
(7, 3, 2, 10),
(8, 3, 3, 10),
(11, 3, 1, 5),
(12, 7, 2, 10),
(13, 7, 1, 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horarios_entrega`
--

CREATE TABLE `horarios_entrega` (
  `id_horario_entrega` int(11) NOT NULL,
  `dia` int(11) NOT NULL,
  `hora_inicial` time NOT NULL,
  `hora_final` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `horarios_entrega`
--

INSERT INTO `horarios_entrega` (`id_horario_entrega`, `dia`, `hora_inicial`, `hora_final`) VALUES
(1, 6, '12:16:14', '12:16:15'),
(2, 7, '22:00:00', '23:59:59'),
(3, 7, '21:11:20', '19:21:36');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `img_productos`
--

CREATE TABLE `img_productos` (
  `id_img_producto` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `id_presentacion` int(11) NOT NULL,
  `imagen_producto` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `img_productos`
--

INSERT INTO `img_productos` (`id_img_producto`, `id_producto`, `id_presentacion`, `imagen_producto`) VALUES
(1, 1, 2, '577ae84403567.png'),
(2, 1, 3, '5778345039b28.png'),
(3, 2, 1, '577ae86739ef8.png'),
(4, 3, 2, '577ae8b7d74ab.png'),
(5, 4, 1, '577ae8f407641.png'),
(6, 5, 2, '577ae91abdc7f.png'),
(7, 6, 1, '57804e0c14fb1.png'),
(8, 7, 1, '57b27b9d5a995.png'),
(10, 7, 1, '57b27edd822d3.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `index_imagenes`
--

CREATE TABLE `index_imagenes` (
  `id_imagen` int(11) NOT NULL,
  `imagen` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `index_imagenes`
--

INSERT INTO `index_imagenes` (`id_imagen`, `imagen`) VALUES
(1, '57ae42a4dc6ef.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id_pedido` int(11) NOT NULL,
  `id_direccion` int(11) NOT NULL,
  `id_horario_entrega` int(11) NOT NULL,
  `fecha_pedido` date NOT NULL,
  `total` decimal(5,2) NOT NULL,
  `estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id_pedido`, `id_direccion`, `id_horario_entrega`, `fecha_pedido`, `total`, `estado`) VALUES
(2, 6, 2, '2016-07-23', '20.88', 1),
(3, 6, 2, '2016-08-20', '111.25', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos_local`
--

CREATE TABLE `pedidos_local` (
  `id_pedido_local` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `total` decimal(5,2) NOT NULL,
  `fecha_pedido` datetime NOT NULL,
  `estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `pedidos_local`
--

INSERT INTO `pedidos_local` (`id_pedido_local`, `id_cliente`, `total`, `fecha_pedido`, `estado`) VALUES
(1, 1, '23.40', '2016-07-16 20:43:04', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `preguntas`
--

CREATE TABLE `preguntas` (
  `id_pregunta` int(11) NOT NULL,
  `pregunta` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `preguntas`
--

INSERT INTO `preguntas` (`id_pregunta`, `pregunta`) VALUES
(1, 'quien eres');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `preguntas_frecuentes`
--

CREATE TABLE `preguntas_frecuentes` (
  `id_pregunta_frecuente` int(11) NOT NULL,
  `pregunta` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `respuesta` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `preguntas_frecuentes`
--

INSERT INTO `preguntas_frecuentes` (`id_pregunta_frecuente`, `pregunta`, `respuesta`) VALUES
(1, 'sas', 'sas'),
(3, 'hgh', 'ghf');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `presentaciones`
--

CREATE TABLE `presentaciones` (
  `id_presentacion` int(11) NOT NULL,
  `presentacion` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `presentaciones`
--

INSERT INTO `presentaciones` (`id_presentacion`, `presentacion`) VALUES
(2, 'normal'),
(1, 'vacio'),
(3, 'wdwd');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id_producto` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `nombre_producto` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `precio_producto` decimal(5,2) NOT NULL,
  `descripcion` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `estado` tinyint(1) NOT NULL,
  `vistas` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_producto`, `id_categoria`, `nombre_producto`, `precio_producto`, `descripcion`, `estado`, `vistas`) VALUES
(1, 2, 'Lomo aguja', '2.34', 'asd', 1, NULL),
(2, 2, 'Chorizo', '2.26', 'asd', 1, NULL),
(3, 2, 'Chuleta', '2.64', 'asd', 1, NULL),
(4, 2, 'Salami', '3.65', 'asd', 1, NULL),
(5, 2, 'Salchicha', '3.12', 'asd', 1, NULL),
(6, 2, 'rr', '1.20', 'asd', 1, NULL),
(7, 3, 'lomo', '1.20', 'Lomo hermoso y preciosooooo', 1, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `redes_sociales`
--

CREATE TABLE `redes_sociales` (
  `id_red_social` int(11) NOT NULL,
  `logo_red_social` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `url_red_social` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `redes_sociales`
--

INSERT INTO `redes_sociales` (`id_red_social`, `logo_red_social`, `url_red_social`) VALUES
(1, 'logo.png', 'https://www.facebook.com/IsaDeliSmokehouse/?fref=ts');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tablas`
--

CREATE TABLE `tablas` (
  `id_tabla` int(11) NOT NULL,
  `tabla` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `terminos_condiciones`
--

CREATE TABLE `terminos_condiciones` (
  `id_termino_condicion` int(11) NOT NULL,
  `termino` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `descripcion` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `terminos_condiciones`
--

INSERT INTO `terminos_condiciones` (`id_termino_condicion`, `termino`, `descripcion`) VALUES
(1, 'asas', 'asas'),
(2, 's', 's');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_acciones`
--

CREATE TABLE `tipos_acciones` (
  `id_tipo_acciones` int(11) NOT NULL,
  `tipo_accion` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_contactos`
--

CREATE TABLE `tipos_contactos` (
  `id_tipo_contacto` int(11) NOT NULL,
  `tipo_contacto` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `tipos_contactos`
--

INSERT INTO `tipos_contactos` (`id_tipo_contacto`, `tipo_contacto`) VALUES
(2, 'correo'),
(1, 'telefono');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_usuarios`
--

CREATE TABLE `tipos_usuarios` (
  `id_tipo_usuario` int(11) NOT NULL,
  `tipo_usuario` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `calificacion_productos` int(11) NOT NULL,
  `categorias` int(11) NOT NULL,
  `clientes` int(11) NOT NULL,
  `comentarios_productos` int(11) NOT NULL,
  `contactos_empresa` int(11) NOT NULL,
  `datos` int(11) NOT NULL,
  `detalles_pedidos` int(11) NOT NULL,
  `detalles_pedidos_local` int(11) NOT NULL,
  `direcciones` int(11) NOT NULL,
  `empleados` int(11) NOT NULL,
  `entregar_pedidos` int(11) NOT NULL,
  `existencias` int(11) NOT NULL,
  `horarios_entrega` int(11) NOT NULL,
  `index_imagenes` int(11) NOT NULL,
  `img_productos` int(11) NOT NULL,
  `pedidos` int(11) NOT NULL,
  `pedidos_local` int(11) NOT NULL,
  `preguntas` int(11) NOT NULL,
  `preguntas_frecuentes` int(11) NOT NULL,
  `presentaciones` int(11) NOT NULL,
  `productos` int(11) NOT NULL,
  `redes_sociales` int(11) NOT NULL,
  `terminos_condiciones` int(11) NOT NULL,
  `tipos_contactos` int(11) NOT NULL,
  `tipos_usuarios` int(11) NOT NULL,
  `valores` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `tipos_usuarios`
--

INSERT INTO `tipos_usuarios` (`id_tipo_usuario`, `tipo_usuario`, `calificacion_productos`, `categorias`, `clientes`, `comentarios_productos`, `contactos_empresa`, `datos`, `detalles_pedidos`, `detalles_pedidos_local`, `direcciones`, `empleados`, `entregar_pedidos`, `existencias`, `horarios_entrega`, `index_imagenes`, `img_productos`, `pedidos`, `pedidos_local`, `preguntas`, `preguntas_frecuentes`, `presentaciones`, `productos`, `redes_sociales`, `terminos_condiciones`, `tipos_contactos`, `tipos_usuarios`, `valores`) VALUES
(1, 'admin', 7, 0, 7, 1, 7, 7, 7, 0, 7, 7, 0, 0, 0, 0, 7, 0, 0, 7, 7, 0, 7, 7, 7, 7, 7, 0),
(2, 'admin2', 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 0),
(4, '7', 0, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4),
(5, 'Holaaa', 7, 7, 7, 7, 4, 4, 8, 0, 4, 4, 4, 8, 0, 4, 4, 4, 0, 4, 8, 0, 4, 4, 4, 4, 8, 0),
(6, 'intento2', 7, 7, 7, 7, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 8, 0, 4, 4, 4, 4, 4, 4),
(7, 'Intento3', 7, 5, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4);

--
-- Estructura de tabla para la tabla `valores`
--

CREATE TABLE `valores` (
  `id_valor` int(11) NOT NULL,
  `valor` varchar(250) NOT NULL,
  `descripcion` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `valores`
--

INSERT INTO `valores` (`id_valor`, `valor`, `descripcion`) VALUES
(1, 'as', 'asa');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `bitacora`
--
ALTER TABLE `bitacora`
  ADD PRIMARY KEY (`id_bitacora`),
  ADD KEY `fk_empleados_bitacora` (`id_empleado`),
  ADD KEY `fk_tablas_bitacora` (`id_tabla`),
  ADD KEY `fk_tipos-acciones_bitacora` (`id_tipo_accion`);

--
-- Indices de la tabla `calificacion_productos`
--
ALTER TABLE `calificacion_productos`
  ADD PRIMARY KEY (`id_calificacion_producto`),
  ADD KEY `fk_clientes_calificacion-productos` (`id_cliente`),
  ADD KEY `fk_productos_calificacion-productos` (`id_producto`);

--
-- Indices de la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD PRIMARY KEY (`id_carrito`),
  ADD UNIQUE KEY `carrito_producto` (`id_cliente`,`id_img_producto`),
  ADD KEY `fk_productos_carrito` (`id_img_producto`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id_categoria`),
  ADD UNIQUE KEY `categoria` (`categoria`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id_cliente`);

--
-- Indices de la tabla `comentarios_productos`
--
ALTER TABLE `comentarios_productos`
  ADD PRIMARY KEY (`id_comentario`),
  ADD KEY `fk_clientes_comentarios-productos` (`id_cliente`),
  ADD KEY `fk_productos_comentarios-productos` (`id_producto`);

--
-- Indices de la tabla `contactos_empresa`
--
ALTER TABLE `contactos_empresa`
  ADD PRIMARY KEY (`id_contacto_empresa`),
  ADD UNIQUE KEY `contacto_empresa` (`contacto_empresa`),
  ADD KEY `fk_tipos-contactos_contactos-empresa` (`id_tipo_contacto`);

--
-- Indices de la tabla `datos`
--
ALTER TABLE `datos`
  ADD PRIMARY KEY (`id_dato`);

--
-- Indices de la tabla `detalles_pedidos`
--
ALTER TABLE `detalles_pedidos`
  ADD PRIMARY KEY (`id_detalles_pedido`),
  ADD UNIQUE KEY `detalle_producto` (`id_pedido`,`id_img_producto`),
  ADD KEY `fk_productos_detalle-pedido` (`id_img_producto`);

--
-- Indices de la tabla `detalles_pedidos_local`
--
ALTER TABLE `detalles_pedidos_local`
  ADD PRIMARY KEY (`id_detalles_pedido_local`),
  ADD UNIQUE KEY `detalle_producto_local` (`id_pedido_local`,`id_img_producto`),
  ADD KEY `fk_productos_detalle-pedido-local` (`id_img_producto`);

--
-- Indices de la tabla `direcciones`
--
ALTER TABLE `direcciones`
  ADD PRIMARY KEY (`id_direccion`),
  ADD UNIQUE KEY `cliente_direccion` (`id_cliente`,`direccion`);

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`id_empleado`),
  ADD UNIQUE KEY `n_documento` (`n_documento`),
  ADD KEY `fk_tipos-usuarios_empleados` (`id_tipo_usuario`);

--
-- Indices de la tabla `entregar_pedidos`
--
ALTER TABLE `entregar_pedidos`
  ADD PRIMARY KEY (`id_entrega_pedido`),
  ADD UNIQUE KEY `empleado-pedido` (`id_empleado`,`id_pedido`) USING BTREE,
  ADD KEY `fk_pedidos_entregar-pedidos` (`id_pedido`),
  ADD KEY `fk_empleados_entregar-pedidos` (`id_empleado`);

--
-- Indices de la tabla `existencias`
--
ALTER TABLE `existencias`
  ADD PRIMARY KEY (`id_existencia`),
  ADD UNIQUE KEY `existencias` (`id_producto`,`id_presentacion`),
  ADD KEY `fk_presentaciones_existencias` (`id_presentacion`);

--
-- Indices de la tabla `horarios_entrega`
--
ALTER TABLE `horarios_entrega`
  ADD PRIMARY KEY (`id_horario_entrega`);

--
-- Indices de la tabla `img_productos`
--
ALTER TABLE `img_productos`
  ADD PRIMARY KEY (`id_img_producto`),
  ADD UNIQUE KEY `imagen_producto` (`imagen_producto`),
  ADD KEY `fk_productos_img-productos` (`id_producto`),
  ADD KEY `fk_presentaciones_img-productos` (`id_presentacion`);

--
-- Indices de la tabla `index_imagenes`
--
ALTER TABLE `index_imagenes`
  ADD PRIMARY KEY (`id_imagen`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id_pedido`),
  ADD KEY `fk_clientes_compras` (`id_direccion`),
  ADD KEY `id_horario_entrega` (`id_horario_entrega`);

--
-- Indices de la tabla `pedidos_local`
--
ALTER TABLE `pedidos_local`
  ADD PRIMARY KEY (`id_pedido_local`);

--
-- Indices de la tabla `preguntas`
--
ALTER TABLE `preguntas`
  ADD PRIMARY KEY (`id_pregunta`),
  ADD UNIQUE KEY `pregunta` (`pregunta`);

--
-- Indices de la tabla `preguntas_frecuentes`
--
ALTER TABLE `preguntas_frecuentes`
  ADD PRIMARY KEY (`id_pregunta_frecuente`),
  ADD UNIQUE KEY `pregunta` (`pregunta`),
  ADD UNIQUE KEY `respuesta` (`respuesta`);

--
-- Indices de la tabla `presentaciones`
--
ALTER TABLE `presentaciones`
  ADD PRIMARY KEY (`id_presentacion`),
  ADD UNIQUE KEY `presentacion` (`presentacion`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_producto`),
  ADD UNIQUE KEY `producto` (`id_categoria`,`nombre_producto`);

--
-- Indices de la tabla `redes_sociales`
--
ALTER TABLE `redes_sociales`
  ADD PRIMARY KEY (`id_red_social`),
  ADD UNIQUE KEY `logo_red_social` (`logo_red_social`),
  ADD UNIQUE KEY `url_red_social` (`url_red_social`);

--
-- Indices de la tabla `tablas`
--
ALTER TABLE `tablas`
  ADD PRIMARY KEY (`id_tabla`);

--
-- Indices de la tabla `terminos_condiciones`
--
ALTER TABLE `terminos_condiciones`
  ADD PRIMARY KEY (`id_termino_condicion`),
  ADD UNIQUE KEY `termino` (`termino`),
  ADD UNIQUE KEY `descripcion` (`descripcion`);

--
-- Indices de la tabla `tipos_acciones`
--
ALTER TABLE `tipos_acciones`
  ADD PRIMARY KEY (`id_tipo_acciones`);

--
-- Indices de la tabla `tipos_contactos`
--
ALTER TABLE `tipos_contactos`
  ADD PRIMARY KEY (`id_tipo_contacto`),
  ADD UNIQUE KEY `tipo_contacto` (`tipo_contacto`);

--
-- Indices de la tabla `tipos_usuarios`
--
ALTER TABLE `tipos_usuarios`
  ADD PRIMARY KEY (`id_tipo_usuario`),
  ADD UNIQUE KEY `tipo_usuario` (`tipo_usuario`);

--
-- Indices de la tabla `valores`
--
ALTER TABLE `valores`
  ADD PRIMARY KEY (`id_valor`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `bitacora`
--
ALTER TABLE `bitacora`
  MODIFY `id_bitacora` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `calificacion_productos`
--
ALTER TABLE `calificacion_productos`
  MODIFY `id_calificacion_producto` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `carrito`
--
ALTER TABLE `carrito`
  MODIFY `id_carrito` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `comentarios_productos`
--
ALTER TABLE `comentarios_productos`
  MODIFY `id_comentario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `contactos_empresa`
--
ALTER TABLE `contactos_empresa`
  MODIFY `id_contacto_empresa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `datos`
--
ALTER TABLE `datos`
  MODIFY `id_dato` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `detalles_pedidos`
--
ALTER TABLE `detalles_pedidos`
  MODIFY `id_detalles_pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT de la tabla `detalles_pedidos_local`
--
ALTER TABLE `detalles_pedidos_local`
  MODIFY `id_detalles_pedido_local` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `direcciones`
--
ALTER TABLE `direcciones`
  MODIFY `id_direccion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `id_empleado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `entregar_pedidos`
--
ALTER TABLE `entregar_pedidos`
  MODIFY `id_entrega_pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT de la tabla `existencias`
--
ALTER TABLE `existencias`
  MODIFY `id_existencia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT de la tabla `horarios_entrega`
--
ALTER TABLE `horarios_entrega`
  MODIFY `id_horario_entrega` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `img_productos`
--
ALTER TABLE `img_productos`
  MODIFY `id_img_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT de la tabla `index_imagenes`
--
ALTER TABLE `index_imagenes`
  MODIFY `id_imagen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id_pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `pedidos_local`
--
ALTER TABLE `pedidos_local`
  MODIFY `id_pedido_local` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `preguntas`
--
ALTER TABLE `preguntas`
  MODIFY `id_pregunta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `preguntas_frecuentes`
--
ALTER TABLE `preguntas_frecuentes`
  MODIFY `id_pregunta_frecuente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `presentaciones`
--
ALTER TABLE `presentaciones`
  MODIFY `id_presentacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT de la tabla `redes_sociales`
--
ALTER TABLE `redes_sociales`
  MODIFY `id_red_social` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `tablas`
--
ALTER TABLE `tablas`
  MODIFY `id_tabla` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `terminos_condiciones`
--
ALTER TABLE `terminos_condiciones`
  MODIFY `id_termino_condicion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `tipos_acciones`
--
ALTER TABLE `tipos_acciones`
  MODIFY `id_tipo_acciones` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `tipos_contactos`
--
ALTER TABLE `tipos_contactos`
  MODIFY `id_tipo_contacto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `tipos_usuarios`
--
ALTER TABLE `tipos_usuarios`
  MODIFY `id_tipo_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `valores`
--
ALTER TABLE `valores`
  MODIFY `id_valor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `bitacora`
--
ALTER TABLE `bitacora`
  ADD CONSTRAINT `fk_empleados_bitacora` FOREIGN KEY (`id_empleado`) REFERENCES `empleados` (`id_empleado`),
  ADD CONSTRAINT `fk_tablas_bitacora` FOREIGN KEY (`id_tabla`) REFERENCES `tablas` (`id_tabla`),
  ADD CONSTRAINT `fk_tipos-acciones_bitacora` FOREIGN KEY (`id_tipo_accion`) REFERENCES `tipos_acciones` (`id_tipo_acciones`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
