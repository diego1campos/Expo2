-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 17-09-2016 a las 03:30:44
-- Versión del servidor: 5.5.49-0ubuntu0.14.04.1
-- Versión de PHP: 5.5.9-1ubuntu4.17

create database isadeli;

use isadeli;

--Usuario
CREATE USER 'isadeli'@'localhost' IDENTIFIED BY '123456';


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
-- Estructura Stand-in para la vista `bita`
--
CREATE TABLE `bita` (
`id_tabla` int(11)
,`id_tipo_acciones` int(11)
,`nombre_empleado` varchar(401)
,`tabla` varchar(30)
,`tipo_accion` varchar(20)
,`descripcion` varchar(200)
,`fecha_ingreso` datetime
);

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

--
-- Volcado de datos para la tabla `bitacora`
--

INSERT INTO `bitacora` (`id_bitacora`, `id_empleado`, `id_tabla`, `id_tipo_accion`, `descripcion`, `fecha_ingreso`) VALUES
(1, 1, 14, 1, 'INSERT INTO presentaciones (presentacion) values(?)', '2016-09-15 01:26:33'),
(2, 1, 15, 1, 'insert into productos (nombre_producto, precio_producto, id_categoria, descripcion, estado) values ( ?, ?, ?, ?, ? );', '2016-09-15 01:27:46'),
(3, 1, 10, 1, 'insert into img_productos (id_producto, id_presentacion, imagen_producto) values (?, ?, ?);', '2016-09-15 01:27:46'),
(4, 1, 9, 1, 'INSERT INTO existencias( id_producto, id_presentacion, existencias ) values(?, ?, ?)', '2016-09-15 01:32:10'),
(5, 1, 4, 2, 'UPDATE datos SET mision = ?, vision = ?, historia = ? WHERE id_dato = ?', '2016-09-15 16:59:31'),
(6, 1, 4, 2, 'UPDATE datos SET mision = ?, vision = ?, historia = ? WHERE id_dato = ?', '2016-09-15 17:02:03'),
(7, 1, 4, 2, 'UPDATE datos SET mision = ?, vision = ?, historia = ? WHERE id_dato = ?', '2016-09-15 17:04:33'),
(8, 1, 4, 2, 'UPDATE datos SET mision = ?, vision = ?, historia = ? WHERE id_dato = ?', '2016-09-15 17:05:27'),
(9, 1, 4, 2, 'UPDATE datos SET mision = ?, vision = ?, historia = ? WHERE id_dato = ?', '2016-09-15 17:16:46'),
(10, 1, 17, 1, 'INSERT INTO terminos_condiciones(termino,descripcion) values(?, ?)', '2016-09-15 17:26:19'),
(11, 1, 17, 3, 'delete from terminos_condiciones where id_termino_condicion=?;', '2016-09-15 17:26:23'),
(12, 1, 1, 2, 'UPDATE datos set min_pro_pedido=? where id_dato=?', '2016-09-15 17:31:10'),
(13, 1, 1, 2, 'UPDATE datos set max_dias_pedido=? where id_dato=?', '2016-09-15 17:32:58'),
(14, 1, 1, 2, 'UPDATE datos set cargo_pedidos=? where id_dato=?', '2016-09-15 17:41:04'),
(15, 1, 1, 2, 'UPDATE datos set max_dias_pedido=? where id_dato=?', '2016-09-15 18:18:19'),
(16, 1, 1, 2, 'UPDATE datos set max_dias_pedido=? where id_dato=?', '2016-09-15 18:18:27'),
(17, 1, 1, 2, 'UPDATE datos set max_dias_pedido=? where id_dato=?', '2016-09-15 18:19:17'),
(18, 1, 1, 2, 'UPDATE datos set max_dias_pedido=? where id_dato=?', '2016-09-15 18:20:07'),
(19, 1, 1, 2, 'UPDATE datos set max_dias_pedido=? where id_dato=?', '2016-09-15 18:26:08'),
(20, 1, 1, 2, 'UPDATE datos set max_dias_pedido=? where id_dato=?', '2016-09-15 18:26:16'),
(21, 1, 1, 2, 'UPDATE datos set cargo_pedidos=? where id_dato=?', '2016-09-15 18:26:36'),
(22, 1, 1, 2, 'UPDATE datos set cargo_pedidos=? where id_dato=?', '2016-09-15 18:26:56'),
(23, 1, 1, 2, 'UPDATE datos set max_dias_pedido=? where id_dato=?', '2016-09-15 18:33:57'),
(24, 1, 1, 2, 'UPDATE datos set max_dias_pedido=? where id_dato=?', '2016-09-15 18:34:40'),
(25, 1, 1, 2, 'UPDATE datos set max_dias_pedido=? where id_dato=?', '2016-09-15 18:35:10'),
(26, 1, 1, 2, 'UPDATE datos set max_dias_pedido=? where id_dato=?', '2016-09-15 18:35:22'),
(27, 1, 1, 2, 'UPDATE datos set min_pro_pedido=? where id_dato=?', '2016-09-15 18:38:19'),
(28, 1, 1, 2, 'UPDATE datos set max_dias_pedido=? where id_dato=?', '2016-09-15 18:40:31'),
(29, 1, 1, 2, 'UPDATE datos set cargo_pedidos=? where id_dato=?', '2016-09-15 18:40:43'),
(30, 1, 1, 2, 'UPDATE datos set min_pro_pedido=? where id_dato=?', '2016-09-15 18:40:58'),
(31, 1, 4, 2, 'UPDATE datos SET mision = ?, vision = ?, historia = ? WHERE id_dato = ?', '2016-09-16 17:00:16'),
(32, 1, 4, 2, 'UPDATE datos SET mision = ?, vision = ?, historia = ? WHERE id_dato = ?', '2016-09-16 17:01:11'),
(33, 1, 4, 2, 'UPDATE datos SET mision = ?, vision = ?, historia = ? WHERE id_dato = ?', '2016-09-16 17:02:09'),
(34, 1, 4, 2, 'UPDATE datos SET mision = ?, vision = ?, historia = ? WHERE id_dato = ?', '2016-09-16 17:04:22'),
(35, 1, 4, 2, 'UPDATE datos SET mision = ?, vision = ?, historia = ? WHERE id_dato = ?', '2016-09-16 17:04:27'),
(36, 1, 21, 1, 'INSERT INTO index_imagenes(imagen) values(?)', '2016-09-16 17:36:33'),
(37, 1, 21, 1, 'INSERT INTO index_imagenes(imagen) values(?)', '2016-09-16 17:37:18'),
(38, 1, 21, 3, 'delete from index_imagenes where id_imagen=?;', '2016-09-16 17:38:27'),
(39, 1, 21, 3, 'delete from index_imagenes where id_imagen=?;', '2016-09-16 17:38:33'),
(40, 1, 21, 1, 'INSERT INTO index_imagenes(imagen) values(?)', '2016-09-16 17:38:57'),
(41, 1, 21, 1, 'INSERT INTO index_imagenes(imagen) values(?)', '2016-09-16 17:42:31'),
(42, 1, 21, 1, 'INSERT INTO index_imagenes(imagen) values(?)', '2016-09-16 17:43:01'),
(43, 1, 21, 3, 'delete from index_imagenes where id_imagen=?;', '2016-09-16 17:59:25'),
(44, 1, 21, 1, 'INSERT INTO index_imagenes(imagen) values(?)', '2016-09-16 18:06:12'),
(45, 1, 15, 1, 'insert into productos (nombre_producto, precio_producto, id_categoria, descripcion, estado, vistas) values ( ?, ?, ?, ?, ?, 0 );', '2016-09-16 20:07:51'),
(46, 1, 10, 1, 'insert into img_productos (id_producto, id_presentacion, imagen_producto) values (?, ?, ?);', '2016-09-16 20:07:51'),
(47, 1, 15, 1, 'insert into productos (nombre_producto, precio_producto, id_categoria, descripcion, estado, vistas) values ( ?, ?, ?, ?, ?, 0 );', '2016-09-16 20:09:38'),
(48, 1, 10, 1, 'insert into img_productos (id_producto, id_presentacion, imagen_producto) values (?, ?, ?);', '2016-09-16 20:09:38');

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

--
-- Volcado de datos para la tabla `carrito`
--

INSERT INTO `carrito` (`id_carrito`, `id_cliente`, `id_img_producto`, `cantidad_producto`) VALUES
(1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id_categoria` int(11) NOT NULL,
  `categoria` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `imagen_categoria` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id_categoria`, `categoria`, `imagen_categoria`) VALUES
(1, 'res', '57d9f8227a8cd.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id_cliente` int(11) NOT NULL,
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

INSERT INTO `clientes` (`id_cliente`, `nombres_cliente`, `apellidos_cliente`, `correo`, `usuario`, `clave`, `id_pregunta`, `respuesta`, `img_cliente`, `fecha_registro`, `estado_sesion`) VALUES
(1, 'diego', 'campos', 'diego@gmail.com', 'diego', '$2y$10$6ITJj6qxLq7JDzKsClrDhe8Rnddjp56hW9Ah60MQdCToStwUZhEky', 1, '$2y$10$oOQyapmf/UmazBACMi6Cher1BYG4d7H3jGZ6RFGQyfx6jyOX1DIyK', '57d9f94bd0b61.png', '0000-00-00 00:00:00', 'fs05dmlrs908fg0kmhmmf17hp0'),
(2, 'ax', 'ax', 'diegoo@gmail.com', 'diegoo', '$2y$10$t18REKz61meA1Q8ZUc.BZuJ5ndiq3wXdmybudWTsAVfqoWqU4Znoi', 1, '$2y$10$GdRxYzP1yLujtmSx7suZO.vIFpi8B7Y3rsjehLTmdWCMUeDxj/l0y', '57d9fdf09a46f.png', '0000-00-00 00:00:00', 'me80cr0i6ftci9dhm6ap9kapr3');

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contactos_empresa`
--

CREATE TABLE `contactos_empresa` (
  `id_contacto_empresa` int(11) NOT NULL,
  `id_tipo_contacto` int(11) NOT NULL,
  `contacto_empresa` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
  `cargo_pedidos` decimal(4,2) NOT NULL,
  `max_dias_pedido` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `datos`
--

INSERT INTO `datos` (`id_dato`, `historia`, `mision`, `vision`, `valores`, `logo`, `direcciones`, `min_pro_pedido`, `cargo_pedidos`, `max_dias_pedido`) VALUES
(1, 'San Salvador es la capital de la República de El Salvador y la cabecera del departamento y municipio \r\nhomónimos.3 Como capital de la nación, alberga las sedes del Gobierno y el Consejo de Ministros de El Salvador, Asamblea Legislativa, Corte Suprema de Justicia y demás instituciones y organismos del Estado, así como la residencia oficial del Presidente de la República. Es la mayor ciudad del país desde el punto de vista económico y demográfico, y asiento de las principales industrias y empresas de servicios de El Salvador.', 'aasb', '     gn', 'a', 'a', 'a', 3, '2.00', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalles_pedidos`
--

CREATE TABLE `detalles_pedidos` (
  `id_detalles_pedido` int(11) NOT NULL,
  `id_pedido` int(11) NOT NULL,
  `id_img_producto` int(11) NOT NULL,
  `precio_producto` decimal(5,2) NOT NULL,
  `cantidad_producto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `detalles_pedidos`
--

INSERT INTO `detalles_pedidos` (`id_detalles_pedido`, `id_pedido`, `id_img_producto`, `precio_producto`, `cantidad_producto`) VALUES
(1, 1, 1, '5.00', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalles_pedidos_local`
--

CREATE TABLE `detalles_pedidos_local` (
  `id_detalles_pedido_local` int(11) NOT NULL,
  `id_pedido_local` int(11) NOT NULL,
  `id_img_producto` int(11) NOT NULL,
  `precio_producto` decimal(5,2) NOT NULL,
  `cantidad_producto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `detalles_pedidos_local`
--

INSERT INTO `detalles_pedidos_local` (`id_detalles_pedido_local`, `id_pedido_local`, `id_img_producto`, `precio_producto`, `cantidad_producto`) VALUES
(1, 1, 1, '5.00', 10);

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
(1, 1, 'col san pablo D');

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
  `fecha_nacimiento` date NOT NULL,
  `estado` tinyint(1) NOT NULL,
  `estado_sesion` varchar(200) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`id_empleado`, `id_tipo_usuario`, `nombres_empleado`, `apellidos_empleado`, `n_documento`, `correo`, `usuario`, `clave`, `id_pregunta`, `respuesta`, `img_empleado`, `fecha_registro`, `fecha_nacimiento`, `estado`, `estado_sesion`) VALUES
(1, 1, 'diego', 'campos', '888888888', 'asd@gmail.com', 'diego', '$2y$10$W0PI/rE/ZGm3FZqTiufZIOySHC57k7v36RpDni2.oHgVdVMov/33i', 1, '$2y$10$uTum5jCbPZD9xuCszZqqyunU.BVwi2cPWoZLS092uyrL9L1ri6baO', '57d9f7ecb5d7b.png', '2016-09-15 01:22:53', '1998-01-01', 0, 'om61kusp8v4vtqngcfqutq1m86');

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
(1, 1, 1, 88);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horarios_entrega`
--

CREATE TABLE `horarios_entrega` (
  `id_horario_entrega` int(11) NOT NULL,
  `dia` int(11) NOT NULL,
  `hora_inicial` time NOT NULL,
  `hora_final` time NOT NULL,
  `estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `horarios_entrega`
--

INSERT INTO `horarios_entrega` (`id_horario_entrega`, `dia`, `hora_inicial`, `hora_final`) VALUES
(1, 5, '17:00:00', '23:00:00');

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
(1, 1, 1, '57d9f912c8ae5.png'),
(2, 2, 1, '57dc511713f0c.png'),
(3, 3, 1, '57dc51829d6d1.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `index_imagenes`
--

CREATE TABLE `index_imagenes` (
  `id_imagen` int(11) NOT NULL,
  `imagen` varchar(250) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `index_imagenes`
--

INSERT INTO `index_imagenes` (`id_imagen`, `imagen`) VALUES
(4, '57dc2f07eb1d1.png'),
(5, '57dc2f25c1490.png'),
(6, '57dc349461420.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id_pedido` int(11) NOT NULL,
  `id_direccion` int(11) NOT NULL,
  `id_horario_entrega` int(11) NOT NULL,
  `fecha_pedido` datetime NOT NULL,
  `total` decimal(5,2) NOT NULL,
  `estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id_pedido`, `id_direccion`, `id_horario_entrega`, `fecha_pedido`, `total`, `estado`) VALUES
(1, 1, 1, '2016-09-15 00:00:00', '4.30', 0);

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
(1, 1, '23.00', '2016-09-14 19:47:17', 0);

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
(1, 'Pregunta por defecto');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `preguntas_frecuentes`
--

CREATE TABLE `preguntas_frecuentes` (
  `id_pregunta_frecuente` int(11) NOT NULL,
  `pregunta` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `respuesta` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
(1, 'normal');

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
(1, 1, 'lomo aguja', '2.30', 'asd', 1, 5),
(2, 1, 'Costilla de cabran', '12.00', 'sasds', 1, 1),
(3, 1, 'costilla de cerdo', '20.00', 'asasa', 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `redes_sociales`
--

CREATE TABLE `redes_sociales` (
  `id_red_social` int(11) NOT NULL,
  `logo_red_social` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `url_red_social` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tablas`
--

CREATE TABLE `tablas` (
  `id_tabla` int(11) NOT NULL,
  `tabla` varchar(30) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `tablas`
--

INSERT INTO `tablas` (`id_tabla`, `tabla`) VALUES
(1, 'categorias'),
(2, 'clientes'),
(3, 'contactos_empresa'),
(4, 'datos'),
(5, 'detalles_pedidos'),
(6, 'direcciones'),
(7, 'empleados'),
(8, 'entregar_pedidos'),
(9, 'existencias'),
(10, 'img_productos'),
(11, 'pedidos'),
(12, 'preguntas'),
(13, 'preguntas_frecuentes'),
(14, 'presentaciones'),
(15, 'productos'),
(16, 'redes_sociales'),
(17, 'terminos_condiciones'),
(18, 'tipos_contactos'),
(19, 'tipos_usuarios'),
(20, 'horarios_entrega'),
(21, 'pedidos_local'),
(22, 'detalles_pedidos_local'),
(23, 'carrito'),
(24, 'comentarios_productos'),
(25, 'valores'),
(26, 'index_imagenes');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `terminos_condiciones`
--

CREATE TABLE `terminos_condiciones` (
  `id_termino_condicion` int(11) NOT NULL,
  `termino` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `descripcion` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_acciones`
--

CREATE TABLE `tipos_acciones` (
  `id_tipo_acciones` int(11) NOT NULL,
  `tipo_accion` varchar(20) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `tipos_acciones`
--

INSERT INTO `tipos_acciones` (`id_tipo_acciones`, `tipo_accion`) VALUES
(1, 'Agregar'),
(2, 'Editar'),
(3, 'Eliminar');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_contactos`
--

CREATE TABLE `tipos_contactos` (
  `id_tipo_contacto` int(11) NOT NULL,
  `tipo_contacto` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_usuarios`
--

CREATE TABLE `tipos_usuarios` (
  `id_tipo_usuario` int(11) NOT NULL,
  `tipo_usuario` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `calificacion_productos` int(11) NOT NULL,
  `categorias` int(11) NOT NULL,
  `clientes` tinyint(1) NOT NULL,
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
  `valores` int(11) NOT NULL,
  `backup` int(11) NOT NULL,
  `bitacora` tinyint(1) NOT NULL,
  `graficos_reportes` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `tipos_usuarios`
--

INSERT INTO `tipos_usuarios` (`id_tipo_usuario`, `tipo_usuario`, `calificacion_productos`, `categorias`, `clientes`, `comentarios_productos`, `contactos_empresa`, `datos`, `detalles_pedidos`, `detalles_pedidos_local`, `direcciones`, `empleados`, `entregar_pedidos`, `existencias`, `horarios_entrega`, `index_imagenes`, `img_productos`, `pedidos`, `pedidos_local`, `preguntas`, `preguntas_frecuentes`, `presentaciones`, `productos`, `redes_sociales`, `terminos_condiciones`, `tipos_contactos`, `tipos_usuarios`, `valores`, `backup`, `bitacora`, `graficos_reportes`) VALUES
(1, 'admin', 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 8, 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `valores`
--

CREATE TABLE `valores` (
  `id_valor` int(11) NOT NULL,
  `valor` varchar(250) CHARACTER SET latin1 NOT NULL,
  `descripcion` varchar(250) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura para la vista `bita`
--
DROP TABLE IF EXISTS `bita`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `bita`  AS  select `b`.`id_tabla` AS `id_tabla`,`a`.`id_tipo_acciones` AS `id_tipo_acciones`,concat(`e`.`nombres_empleado`,' ',`e`.`apellidos_empleado`) AS `nombre_empleado`,`t`.`tabla` AS `tabla`,`a`.`tipo_accion` AS `tipo_accion`,`b`.`descripcion` AS `descripcion`,`b`.`fecha_ingreso` AS `fecha_ingreso` from (((`empleados` `e` join `tablas` `t`) join `tipos_acciones` `a`) join `bitacora` `b`) where ((`b`.`id_empleado` = `e`.`id_empleado`) and (`b`.`id_tabla` = `t`.`id_tabla`) and (`b`.`id_tipo_accion` = `a`.`id_tipo_acciones`)) ;

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
  ADD PRIMARY KEY (`id_cliente`),
  ADD UNIQUE KEY `usuario` (`usuario`),
  ADD UNIQUE KEY `correo` (`correo`),
  ADD KEY `fk_preguntas_clientes` (`id_pregunta`);

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
  ADD KEY `fk_img-productos_detalle-pedido` (`id_img_producto`),
  ADD KEY `fk_pedidos_detalle-pedido-local` (`id_pedido`);

--
-- Indices de la tabla `detalles_pedidos_local`
--
ALTER TABLE `detalles_pedidos_local`
  ADD PRIMARY KEY (`id_detalles_pedido_local`),
  ADD UNIQUE KEY `detalle_producto_local` (`id_pedido_local`,`id_img_producto`),
  ADD KEY `fk_img-productos_detalle-pedido-local` (`id_img_producto`),
  ADD KEY `fk_pedidos-local_detalle-pedido-local` (`id_pedido_local`);

--
-- Indices de la tabla `direcciones`
--
ALTER TABLE `direcciones`
  ADD PRIMARY KEY (`id_direccion`),
  ADD UNIQUE KEY `cliente_direccion` (`id_cliente`,`direccion`),
  ADD KEY `fk_clientes_direcciones` (`id_cliente`);

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`id_empleado`),
  ADD UNIQUE KEY `n_documento` (`n_documento`),
  ADD UNIQUE KEY `usuario` (`usuario`),
  ADD UNIQUE KEY `correo` (`correo`),
  ADD KEY `fk_tipos-usuarios_empleados` (`id_tipo_usuario`),
  ADD KEY `fk_preguntas_empleados` (`id_pregunta`);

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
  ADD KEY `fk_presentaciones_existencias` (`id_presentacion`),
  ADD KEY `fk_productos_existencias` (`id_producto`);

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
  ADD KEY `fk_direcciones_pedidos` (`id_direccion`),
  ADD KEY `fk_horarios-entrega_pedidos` (`id_horario_entrega`);

--
-- Indices de la tabla `pedidos_local`
--
ALTER TABLE `pedidos_local`
  ADD PRIMARY KEY (`id_pedido_local`),
  ADD KEY `fk_clientes_pedidos-local` (`id_cliente`);

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
  ADD UNIQUE KEY `producto` (`id_categoria`,`nombre_producto`),
  ADD KEY `fk_categorias_productos` (`id_categoria`);

--
-- Indices de la tabla `redes_sociales`
--
ALTER TABLE `redes_sociales`
  ADD PRIMARY KEY (`id_red_social`),
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
  ADD PRIMARY KEY (`id_valor`),
  ADD UNIQUE KEY `valor` (`valor`),
  ADD UNIQUE KEY `descripcion` (`descripcion`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `bitacora`
--
ALTER TABLE `bitacora`
  MODIFY `id_bitacora` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;
--
-- AUTO_INCREMENT de la tabla `calificacion_productos`
--
ALTER TABLE `calificacion_productos`
  MODIFY `id_calificacion_producto` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `carrito`
--
ALTER TABLE `carrito`
  MODIFY `id_carrito` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `comentarios_productos`
--
ALTER TABLE `comentarios_productos`
  MODIFY `id_comentario` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `contactos_empresa`
--
ALTER TABLE `contactos_empresa`
  MODIFY `id_contacto_empresa` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `datos`
--
ALTER TABLE `datos`
  MODIFY `id_dato` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `detalles_pedidos`
--
ALTER TABLE `detalles_pedidos`
  MODIFY `id_detalles_pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `detalles_pedidos_local`
--
ALTER TABLE `detalles_pedidos_local`
  MODIFY `id_detalles_pedido_local` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `direcciones`
--
ALTER TABLE `direcciones`
  MODIFY `id_direccion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `id_empleado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `entregar_pedidos`
--
ALTER TABLE `entregar_pedidos`
  MODIFY `id_entrega_pedido` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `existencias`
--
ALTER TABLE `existencias`
  MODIFY `id_existencia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `horarios_entrega`
--
ALTER TABLE `horarios_entrega`
  MODIFY `id_horario_entrega` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `img_productos`
--
ALTER TABLE `img_productos`
  MODIFY `id_img_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `index_imagenes`
--
ALTER TABLE `index_imagenes`
  MODIFY `id_imagen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id_pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
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
  MODIFY `id_pregunta_frecuente` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `presentaciones`
--
ALTER TABLE `presentaciones`
  MODIFY `id_presentacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `redes_sociales`
--
ALTER TABLE `redes_sociales`
  MODIFY `id_red_social` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `tablas`
--
ALTER TABLE `tablas`
  MODIFY `id_tabla` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT de la tabla `terminos_condiciones`
--
ALTER TABLE `terminos_condiciones`
  MODIFY `id_termino_condicion` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `tipos_acciones`
--
ALTER TABLE `tipos_acciones`
  MODIFY `id_tipo_acciones` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `tipos_contactos`
--
ALTER TABLE `tipos_contactos`
  MODIFY `id_tipo_contacto` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `tipos_usuarios`
--
ALTER TABLE `tipos_usuarios`
  MODIFY `id_tipo_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `valores`
--
ALTER TABLE `valores`
  MODIFY `id_valor` int(11) NOT NULL AUTO_INCREMENT;
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

--
-- Filtros para la tabla `calificacion_productos`
--
ALTER TABLE `calificacion_productos`
  ADD CONSTRAINT `fk_clientes_calificacion-productos` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_cliente`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_productos_calificacion-productos` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`) ON DELETE CASCADE;

--
-- Filtros para la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD CONSTRAINT `fk_clientes_carrito` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_cliente`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_img-productos_carrito` FOREIGN KEY (`id_img_producto`) REFERENCES `img_productos` (`id_img_producto`) ON DELETE CASCADE;

--
-- Filtros para la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD CONSTRAINT `fk_preguntas_clientes` FOREIGN KEY (`id_pregunta`) REFERENCES `preguntas` (`id_pregunta`);

--
-- Filtros para la tabla `comentarios_productos`
--
ALTER TABLE `comentarios_productos`
  ADD CONSTRAINT `fk_clientes_comentarios-productos` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_cliente`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_productos_comentarios-productos` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`) ON DELETE CASCADE;

--
-- Filtros para la tabla `contactos_empresa`
--
ALTER TABLE `contactos_empresa`
  ADD CONSTRAINT `fk_tipos-contactos_contactos-empresa` FOREIGN KEY (`id_tipo_contacto`) REFERENCES `tipos_contactos` (`id_tipo_contacto`);

--
-- Filtros para la tabla `detalles_pedidos`
--
ALTER TABLE `detalles_pedidos`
  ADD CONSTRAINT `fk_img-productos_detalles-pedidos` FOREIGN KEY (`id_img_producto`) REFERENCES `img_productos` (`id_img_producto`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_pedidos_detalles-pedidos` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id_pedido`) ON DELETE CASCADE;

--
-- Filtros para la tabla `detalles_pedidos_local`
--
ALTER TABLE `detalles_pedidos_local`
  ADD CONSTRAINT `fk_img-productos_detalles-pedidos-local` FOREIGN KEY (`id_img_producto`) REFERENCES `img_productos` (`id_img_producto`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_pedidos-local_detalles-pedidos-local` FOREIGN KEY (`id_pedido_local`) REFERENCES `pedidos_local` (`id_pedido_local`) ON DELETE CASCADE;

--
-- Filtros para la tabla `direcciones`
--
ALTER TABLE `direcciones`
  ADD CONSTRAINT `fk_clientes_direcciones` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_cliente`) ON DELETE CASCADE;

--
-- Filtros para la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD CONSTRAINT `fk_preguntas_empleados` FOREIGN KEY (`id_pregunta`) REFERENCES `preguntas` (`id_pregunta`),
  ADD CONSTRAINT `fk_tipos-usuarios_empleados` FOREIGN KEY (`id_tipo_usuario`) REFERENCES `tipos_usuarios` (`id_tipo_usuario`);

--
-- Filtros para la tabla `entregar_pedidos`
--
ALTER TABLE `entregar_pedidos`
  ADD CONSTRAINT `fk_empleados_entregar-pedidos` FOREIGN KEY (`id_empleado`) REFERENCES `empleados` (`id_empleado`),
  ADD CONSTRAINT `fk_pedidos_entregar-pedidos` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id_pedido`);

--
-- Filtros para la tabla `existencias`
--
ALTER TABLE `existencias`
  ADD CONSTRAINT `fk_presentaciones_existencias` FOREIGN KEY (`id_presentacion`) REFERENCES `presentaciones` (`id_presentacion`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_productos_existencias` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`) ON DELETE CASCADE;

--
-- Filtros para la tabla `img_productos`
--
ALTER TABLE `img_productos`
  ADD CONSTRAINT `fk_presentaciones_img-productos` FOREIGN KEY (`id_presentacion`) REFERENCES `presentaciones` (`id_presentacion`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_productos_img-productos` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`) ON DELETE CASCADE;

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `fk_direcciones_pedidos` FOREIGN KEY (`id_direccion`) REFERENCES `direcciones` (`id_direccion`),
  ADD CONSTRAINT `fk_horarios-entrega_pedidos` FOREIGN KEY (`id_horario_entrega`) REFERENCES `horarios_entrega` (`id_horario_entrega`);

--
-- Filtros para la tabla `pedidos_local`
--
ALTER TABLE `pedidos_local`
  ADD CONSTRAINT `fk_clientes_pedidos_local` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_cliente`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `fk_categorias_productos` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;