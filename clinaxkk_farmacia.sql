-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 09-04-2025 a las 11:00:47
-- Versión del servidor: 10.6.21-MariaDB-cll-lve-log
-- Versión de PHP: 8.3.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `clinaxkk_farmacia`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `caja_apertura`
--

CREATE TABLE `caja_apertura` (
  `idcaja_a` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `caja` varchar(255) NOT NULL,
  `turno` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `hora` varchar(255) NOT NULL,
  `monto` decimal(10,2) NOT NULL,
  `usuario` varchar(255) NOT NULL,
  `estado` enum('Abierto','Cerrado') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `caja_apertura`
--

INSERT INTO `caja_apertura` (`idcaja_a`, `fecha`, `caja`, `turno`, `hora`, `monto`, `usuario`, `estado`) VALUES
(1, '2025-02-12', 'caja 1', 'ma&ntilde;ana', '4:05-pm', 10.00, 'admin', 'Abierto'),
(2, '2025-02-16', 'caja 1', 'ma&ntilde;ana', '7:20-am', 100.00, 'admin', 'Abierto'),
(3, '2025-02-17', 'caja 1', 'ma&ntilde;ana', '3:19-am', 100.00, 'admin', 'Abierto'),
(4, '2025-02-23', 'caja 1', 'ma&ntilde;ana', '4:58-pm', 100.00, 'admin', 'Abierto'),
(5, '2025-02-26', 'caja 1', 'ma&ntilde;ana', '8:11-am', 100.00, 'admin', 'Abierto'),
(6, '2025-03-01', 'caja 1', 'ma&ntilde;ana', '11:44-am', 100.00, 'admin', 'Abierto'),
(7, '2025-03-01', 'caja 1', 'ma&ntilde;ana', '11:44-am', 100.00, 'admin', 'Abierto'),
(8, '2025-03-02', 'caja 1', 'ma&ntilde;ana', '3:59-am', 100.00, 'admin', 'Abierto'),
(9, '2025-03-03', 'caja 1', 'ma&ntilde;ana', '9:02-pm', 5000.00, 'admin', 'Abierto'),
(10, '2025-03-05', 'caja 1', 'ma&ntilde;ana', '9:43-am', 10.00, 'admin', 'Abierto'),
(11, '2025-03-08', 'caja 1', 'ma&ntilde;ana', '12:08-pm', 100.00, 'admin', 'Abierto'),
(12, '2025-03-09', 'caja 1', 'ma&ntilde;ana', '4:58-am', 1.00, 'admin', 'Abierto'),
(13, '2025-03-10', 'caja 1', 'completo', '9:53-am', 300.00, 'admin', 'Abierto'),
(14, '2025-03-13', 'caja 1', 'ma&ntilde;ana', '9:23-pm', 100.00, 'admin', 'Abierto'),
(15, '2025-03-16', 'caja 1', 'ma&ntilde;ana', '4:53-pm', 0.00, 'admin', 'Abierto'),
(16, '2025-03-16', 'caja 1', 'ma&ntilde;ana', '4:53-pm', 0.00, 'admin', 'Abierto'),
(17, '2025-03-17', 'caja 1', 'ma&ntilde;ana', '5:05-am', 100.00, 'admin', 'Abierto'),
(18, '2025-03-18', 'caja 1', 'ma&ntilde;ana', '8:39-am', 100.00, 'admin', 'Abierto'),
(19, '2025-03-19', 'caja 1', 'ma&ntilde;ana', '12:11-pm', 100.00, 'admin', 'Abierto'),
(20, '2025-03-20', 'caja 1', 'ma&ntilde;ana', '7:22-am', 100.00, 'admin', 'Abierto'),
(21, '2025-03-24', 'caja 1', 'ma&ntilde;ana', '11:38-pm', 100.00, 'admin', 'Abierto'),
(22, '2025-03-25', 'caja 1', 'ma&ntilde;ana', '11:10-am', 0.00, 'admin', 'Abierto'),
(23, '2025-03-26', 'caja 1', 'ma&ntilde;ana', '4:50-pm', 100.00, 'admin', 'Abierto'),
(24, '2025-03-28', 'caja 1', 'ma&ntilde;ana', '3:11-pm', 10.00, 'admin', 'Abierto'),
(25, '2025-03-29', 'caja 1', 'ma&ntilde;ana', '5:39-am', 100.00, 'admin', 'Abierto'),
(26, '2025-03-30', 'caja 1', 'ma&ntilde;ana', '2:19-pm', 100.00, 'admin', 'Abierto'),
(27, '2025-03-31', 'caja 1', 'ma&ntilde;ana', '10:13-am', 100.00, 'admin', 'Abierto');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `caja_cierre`
--

CREATE TABLE `caja_cierre` (
  `idcaja_c` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `caja` varchar(255) NOT NULL,
  `turno` varchar(255) NOT NULL,
  `hora` varchar(255) NOT NULL,
  `usuario` varchar(255) NOT NULL,
  `pagos_efectivo` decimal(10,2) NOT NULL,
  `pagos_tarjeta` decimal(10,2) NOT NULL,
  `pagos_deposito` varchar(255) NOT NULL,
  `total_venta` decimal(10,2) NOT NULL,
  `monto_a` decimal(10,2) NOT NULL,
  `caja_sistema` decimal(10,2) NOT NULL,
  `efectivo_caja` decimal(10,2) NOT NULL,
  `diferencia` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito`
--

CREATE TABLE `carrito` (
  `idproducto` int(11) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `presentacion` varchar(255) NOT NULL,
  `cantidad` decimal(10,2) NOT NULL,
  `valor_unitario` decimal(10,2) NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL,
  `igv` decimal(10,2) NOT NULL,
  `porcentaje_igv` decimal(10,2) NOT NULL,
  `valor_total` decimal(10,2) NOT NULL,
  `importe_total` decimal(10,2) NOT NULL,
  `operacion` varchar(100) NOT NULL,
  `session_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `carrito`
--

INSERT INTO `carrito` (`idproducto`, `descripcion`, `presentacion`, `cantidad`, `valor_unitario`, `precio_unitario`, `igv`, `porcentaje_igv`, `valor_total`, `importe_total`, `operacion`, `session_id`) VALUES
(4, 'PARACETAMOL 500MG - PORTUGAL', 'UNIDAD', 1.00, 0.25, 0.30, 0.05, 18.00, 0.25, 0.30, 'OP. GRAVADAS', 'admin'),
(3, 'Olistic Women 28 vial de 25 ml', 'CAJA', 1.00, 16.95, 20.00, 3.05, 18.00, 16.95, 20.00, 'OP. GRAVADAS', 'admin'),
(1, 'ALBENDAZOL 500MG PRUEBA', 'UNIDAD', 1.00, 1.02, 1.20, 0.18, 18.00, 1.02, 1.20, 'OP. GRAVADAS', 'admin'),
(5, '23', 'LITRO', 1.00, 762.71, 900.00, 137.29, 18.00, 762.71, 900.00, 'OP. GRAVADAS', 'admin');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carritoc`
--

CREATE TABLE `carritoc` (
  `idproducto` int(11) NOT NULL,
  `descripcion` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `presentacion` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio` decimal(18,2) NOT NULL,
  `importe` decimal(18,2) NOT NULL,
  `session_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `idcategoria` int(11) NOT NULL,
  `forma_farmaceutica` varchar(255) NOT NULL,
  `ff_simplificada` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`idcategoria`, `forma_farmaceutica`, `ff_simplificada`) VALUES
(1, 'Comprimido', 'Comp'),
(2, 'Solución', 'Solu');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `certificado`
--

CREATE TABLE `certificado` (
  `idcertificado` int(11) NOT NULL,
  `certificado` varchar(255) DEFAULT NULL,
  `clave_certificado` varchar(255) DEFAULT NULL,
  `estado` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

--
-- Volcado de datos para la tabla `certificado`
--

INSERT INTO `certificado` (`idcertificado`, `certificado`, `clave_certificado`, `estado`) VALUES
(1, 'certificado.pfx', 'clave', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `idcliente` int(11) NOT NULL,
  `nombres` varchar(255) NOT NULL,
  `id_tipo_docu` int(11) NOT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `nrodoc` varchar(30) DEFAULT 'NULL',
  `tipo` enum('cliente','laboratorio') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`idcliente`, `nombres`, `id_tipo_docu`, `direccion`, `nrodoc`, `tipo`) VALUES
(1, 'RED INTEGRADA DE SALUD CHANCHAMAYO', 4, 'JR. TARMA NRO. 140 LA MERCED CHANCHAMAYO JUNIN CHANCHAMAYO CHANCHAMAYO', '20188446133', 'laboratorio'),
(2, 'CANOVA FLORES OSWALDO OMAR', 2, '-', '44881235', 'cliente'),
(3, 'ARTROSCOPICTRAUMA S.A.C.', 4, 'AV. GRAL.GARZON NRO. 2320 URB. FUNDO OYAGUE LIMA LIMA JESUS MARIA', '20538856674', 'cliente'),
(4, 'RVM MAQUINARIAS S.A.C.', 4, '---- NICOLAS AYLLON NRO. 8510 DPTO. 804 LIMA LIMA ATE', '20605100016', 'cliente'),
(5, 'publico en general', 2, '', '00000000', 'cliente'),
(6, 'Laboratorios LAFAR', 4, 'Sin direccion', '1234567', 'laboratorio'),
(8, 'QUISPE MAMANI EDGAR JAVIER', 2, '', '76662509', 'cliente'),
(9, 'MEDIFARMA S A', 4, 'JR. ECUADOR NRO. 787 LIMA LIMA LIMA', '20100018625', 'cliente'),
(10, 'publico en general', 2, '', '4274087', 'cliente'),
(11, 'CANO HONORIO TITO JESUS', 2, '', '45295601', 'cliente'),
(12, 'PORTUGAL SAC', 4, '', '', 'laboratorio'),
(13, 'VALDEZ PAREDES RICHARD IRVIN', 2, '', '71239046', 'cliente'),
(14, 'MORALES VILLAGARAY ASSELNY', 2, 'asdfasdf', '44030299', 'cliente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra`
--

CREATE TABLE `compra` (
  `idcompra` int(11) NOT NULL,
  `idcliente` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `subtotal` decimal(18,2) NOT NULL,
  `igv` decimal(18,2) NOT NULL,
  `total` decimal(18,2) NOT NULL,
  `docu` varchar(30) NOT NULL,
  `num_docu` char(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuracion`
--

CREATE TABLE `configuracion` (
  `idconfi` int(11) NOT NULL,
  `logo` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `tipodoc` char(1) NOT NULL,
  `ruc` varchar(255) NOT NULL,
  `razon_social` varchar(255) NOT NULL,
  `nombre_comercial` varchar(255) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `pais` varchar(255) NOT NULL,
  `departamento` varchar(255) NOT NULL,
  `provincia` varchar(255) NOT NULL,
  `distrito` varchar(255) NOT NULL DEFAULT 'NULL',
  `ubigeo` char(6) NOT NULL,
  `usuario_sol` varchar(50) NOT NULL,
  `clave_sol` varchar(50) NOT NULL,
  `simbolo_moneda` char(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `impuesto` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Volcado de datos para la tabla `configuracion`
--

INSERT INTO `configuracion` (`idconfi`, `logo`, `tipodoc`, `ruc`, `razon_social`, `nombre_comercial`, `direccion`, `pais`, `departamento`, `provincia`, `distrito`, `ubigeo`, `usuario_sol`, `clave_sol`, `simbolo_moneda`, `impuesto`) VALUES
(1, 'IMG_1857.png', '6', '23343888776', 'clinica prueba', 'clinica prueba', 'clinica prueba', 'PE', 'JUNIN', 'JAUJA', 'JAUJA', '120401', 'MODDATOS', 'moddatos', 'S/', 18.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `confi_backup`
--

CREATE TABLE `confi_backup` (
  `idbackup` int(11) NOT NULL,
  `host` varchar(50) NOT NULL,
  `db_name` varchar(50) NOT NULL,
  `user` varchar(50) NOT NULL,
  `pass` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

--
-- Volcado de datos para la tabla `confi_backup`
--

INSERT INTO `confi_backup` (`idbackup`, `host`, `db_name`, `user`, `pass`) VALUES
(1, 'localhost', 'bdfarmacia_sunat', 'root', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detallecompra`
--

CREATE TABLE `detallecompra` (
  `idcompra` int(11) NOT NULL,
  `idproducto` int(11) NOT NULL,
  `cantidad` decimal(18,2) NOT NULL,
  `precio` decimal(18,2) NOT NULL,
  `importe` decimal(18,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalleventa`
--

CREATE TABLE `detalleventa` (
  `idventa` int(11) NOT NULL,
  `item` int(11) NOT NULL,
  `idproducto` int(11) NOT NULL,
  `cantidad` decimal(10,2) NOT NULL,
  `valor_unitario` decimal(10,2) NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL,
  `igv` decimal(10,2) NOT NULL,
  `porcentaje_igv` decimal(10,2) NOT NULL,
  `valor_total` decimal(10,2) NOT NULL,
  `importe_total` decimal(10,2) NOT NULL,
  `descuento` decimal(18,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `detalleventa`
--

INSERT INTO `detalleventa` (`idventa`, `item`, `idproducto`, `cantidad`, `valor_unitario`, `precio_unitario`, `igv`, `porcentaje_igv`, `valor_total`, `importe_total`, `descuento`) VALUES
(11, 1, 1, 1.00, 1.02, 1.20, 0.18, 18.00, 1.02, 1.20, 0.00),
(12, 1, 1, 1.00, 1.02, 1.20, 0.18, 18.00, 1.02, 1.20, 0.00),
(13, 1, 1, 1.00, 1.02, 1.20, 0.18, 18.00, 1.02, 1.20, 0.00),
(14, 1, 1, 5.00, 1.02, 1.20, 0.92, 18.00, 5.10, 6.00, 0.00),
(15, 1, 2, 1.00, 5.51, 6.50, 0.99, 18.00, 5.51, 6.50, 0.00),
(16, 1, 1, 1.00, 1.02, 1.20, 0.18, 18.00, 1.02, 1.20, 0.00),
(17, 1, 2, 5.00, 5.51, 6.50, 4.96, 18.00, 27.55, 32.50, 0.00),
(18, 1, 2, 1.00, 5.51, 6.50, 0.99, 18.00, 5.51, 6.50, 0.00),
(18, 2, 3, 1.00, 16.95, 20.00, 3.05, 18.00, 16.95, 20.00, 0.00),
(19, 1, 2, 1.00, 5.51, 6.50, 0.99, 18.00, 5.51, 6.50, 0.00),
(19, 2, 3, 1.00, 16.95, 20.00, 3.05, 18.00, 16.95, 20.00, 0.00),
(20, 1, 3, 5.00, 16.95, 20.00, 15.26, 18.00, 84.75, 100.00, 0.00),
(20, 2, 2, 1.00, 5.51, 6.50, 0.99, 18.00, 5.51, 6.50, 0.00),
(21, 1, 2, 1.00, 5.51, 6.50, 0.99, 18.00, 5.51, 6.50, 0.00),
(22, 1, 4, 1.00, 0.25, 0.30, 0.05, 18.00, 0.25, 0.30, 0.00),
(23, 1, 4, 1.00, 0.25, 0.30, 0.05, 18.00, 0.25, 0.30, 0.00),
(23, 2, 1, 6.00, 1.02, 1.20, 1.10, 18.00, 6.12, 7.20, 0.00),
(24, 1, 3, 1.00, 16.95, 20.00, 3.05, 18.00, 16.95, 20.00, 0.00),
(25, 1, 4, 1.00, 0.25, 0.30, 0.05, 18.00, 0.25, 0.30, 0.00),
(26, 1, 4, 1.00, 0.25, 0.30, 0.05, 18.00, 0.25, 0.30, 0.00),
(26, 2, 3, 1.00, 16.95, 20.00, 3.05, 18.00, 16.95, 20.00, 0.00),
(26, 3, 1, 1.00, 1.02, 1.20, 0.18, 18.00, 1.02, 1.20, 0.00),
(27, 1, 1, 1.00, 1.02, 1.20, 0.18, 18.00, 1.02, 1.20, 0.00),
(28, 1, 4, 1.00, 0.25, 0.30, 0.05, 18.00, 0.25, 0.30, 0.00),
(28, 2, 3, 1.00, 16.95, 20.00, 3.05, 18.00, 16.95, 20.00, 0.00),
(29, 1, 5, 7.00, 762.71, 900.00, 961.01, 18.00, 5338.97, 6300.00, 0.00),
(29, 2, 4, 1.00, 0.25, 0.30, 0.05, 18.00, 0.25, 0.30, 0.00),
(30, 1, 4, 1.00, 0.25, 0.30, 0.05, 18.00, 0.25, 0.30, 0.00),
(30, 2, 5, 1.00, 762.71, 900.00, 137.29, 18.00, 762.71, 900.00, 0.00),
(31, 1, 4, 1.00, 0.25, 0.30, 0.05, 18.00, 0.25, 0.30, 0.00),
(31, 2, 3, 1.00, 16.95, 20.00, 3.05, 18.00, 16.95, 20.00, 0.00),
(31, 3, 1, 1.00, 1.02, 1.20, 0.18, 18.00, 1.02, 1.20, 0.00),
(31, 4, 5, 1.00, 762.71, 900.00, 137.29, 18.00, 762.71, 900.00, 0.00),
(32, 1, 5, 1.00, 762.71, 900.00, 137.29, 18.00, 762.71, 900.00, 0.00),
(32, 2, 1, 1.00, 1.02, 1.20, 0.18, 18.00, 1.02, 1.20, 0.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lote`
--

CREATE TABLE `lote` (
  `idlote` int(11) NOT NULL,
  `numero` varchar(255) NOT NULL,
  `fecha_vencimiento` date NOT NULL,
  `idsucu_c` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `lote`
--

INSERT INTO `lote` (`idlote`, `numero`, `fecha_vencimiento`, `idsucu_c`) VALUES
(1, '0000', '2025-03-31', 1),
(2, '2026q', '2026-10-22', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `moneda`
--

CREATE TABLE `moneda` (
  `codigo` char(3) NOT NULL,
  `descripcion` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Volcado de datos para la tabla `moneda`
--

INSERT INTO `moneda` (`codigo`, `descripcion`) VALUES
('PEN', 'SOLES'),
('USD', 'DOLARES');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nota_credito`
--

CREATE TABLE `nota_credito` (
  `idnota` int(11) NOT NULL,
  `idconf` int(11) NOT NULL,
  `tipocomp` char(2) NOT NULL,
  `idcliente` int(11) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `idserie` int(11) NOT NULL,
  `fecha_emision` date NOT NULL,
  `op_gravadas` decimal(10,2) NOT NULL,
  `op_exoneradas` decimal(10,2) NOT NULL,
  `op_inafectas` decimal(10,2) NOT NULL,
  `igv` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `serie_ref` char(4) NOT NULL,
  `correlativo_ref` int(11) NOT NULL,
  `codmotivo` varchar(5) NOT NULL,
  `feestado` char(1) DEFAULT NULL,
  `fecodigoerror` char(10) DEFAULT NULL,
  `femensajesunat` text DEFAULT NULL,
  `nombrexml` varchar(50) DEFAULT NULL,
  `xmlbase64` text DEFAULT NULL,
  `cdrbase64` text DEFAULT NULL,
  `idventa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish2_ci;

--
-- Volcado de datos para la tabla `nota_credito`
--

INSERT INTO `nota_credito` (`idnota`, `idconf`, `tipocomp`, `idcliente`, `idusuario`, `idserie`, `fecha_emision`, `op_gravadas`, `op_exoneradas`, `op_inafectas`, `igv`, `total`, `serie_ref`, `correlativo_ref`, `codmotivo`, `feestado`, `fecodigoerror`, `femensajesunat`, `nombrexml`, `xmlbase64`, `cdrbase64`, `idventa`) VALUES
(1, 1, '07', 2, 1, 1, '2025-02-12', 1.02, 0.00, 0.00, 0.18, 1.20, 'BN01', 11, '01', NULL, NULL, NULL, 'R-20612319198-07-BN01-11.XML', NULL, NULL, 11);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `presentacion`
--

CREATE TABLE `presentacion` (
  `idpresentacion` int(11) NOT NULL,
  `presentacion` varchar(255) NOT NULL,
  `idsucu_c` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `presentacion`
--

INSERT INTO `presentacion` (`idpresentacion`, `presentacion`, `idsucu_c`) VALUES
(1, 'UNIDAD', 1),
(2, 'CAJA', 1),
(3, 'LITRO', 1),
(4, 'BLISTER', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `idproducto` int(11) NOT NULL,
  `codigo` varchar(255) DEFAULT NULL,
  `idlote` int(11) NOT NULL,
  `descripcion` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish2_ci NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `stock` int(11) NOT NULL,
  `stockminimo` int(11) NOT NULL,
  `precio_compra` decimal(18,2) NOT NULL,
  `precio_venta` decimal(10,2) NOT NULL,
  `descuento` decimal(18,2) DEFAULT NULL,
  `ventasujeta` varchar(50) NOT NULL,
  `fecha_registro` date NOT NULL,
  `reg_sanitario` varchar(255) DEFAULT NULL,
  `idcategoria` int(11) NOT NULL,
  `idpresentacion` int(11) NOT NULL,
  `idcliente` int(11) NOT NULL,
  `idsintoma` int(11) NOT NULL,
  `idunidad` int(11) NOT NULL,
  `idtipoaf` int(11) NOT NULL,
  `estado` varchar(50) NOT NULL,
  `tipo_precio` char(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`idproducto`, `codigo`, `idlote`, `descripcion`, `tipo`, `stock`, `stockminimo`, `precio_compra`, `precio_venta`, `descuento`, `ventasujeta`, `fecha_registro`, `reg_sanitario`, `idcategoria`, `idpresentacion`, `idcliente`, `idsintoma`, `idunidad`, `idtipoaf`, `estado`, `tipo_precio`) VALUES
(1, '0000', 1, 'ALBENDAZOL 500MG PRUEBA', 'Generico', 10, 1, 1.00, 1.20, NULL, 'Con receta medica', '2025-02-12', '', 1, 1, 1, 1, 1, 1, '1', '01'),
(2, '981189', 1, 'Solución fisiologica 1 litro', 'Generico', 0, 5, 5.00, 6.50, NULL, 'sin receta medica', '2025-02-16', '0', 2, 3, 6, 1, 1, 1, '1', '01'),
(3, '009193', 1, 'Olistic Women 28 vial de 25 ml', 'Generico', 89, 1, 12.00, 20.00, NULL, 'Con receta medica', '2025-02-16', '981099', 1, 2, 1, 1, 1, 1, '1', '01'),
(4, '1234567891231', 1, 'PARACETAMOL 500MG - PORTUGAL', 'Generico', 993, 100, 0.10, 0.30, NULL, 'sin receta medica', '2025-03-13', 'RE02152', 1, 1, 12, 2, 1, 1, '1', '01'),
(5, 'panadol', 1, '23', 'Generico', 13, 1, 500.00, 900.00, NULL, 'Con receta medica', '2025-03-25', '23', 1, 3, 1, 1, 1, 1, '1', '01');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto_similar`
--

CREATE TABLE `producto_similar` (
  `idp_similar` int(11) NOT NULL,
  `idproducto` int(11) NOT NULL,
  `producto` varchar(255) NOT NULL,
  `presentacion` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `producto_similar`
--

INSERT INTO `producto_similar` (`idp_similar`, `idproducto`, `producto`, `presentacion`) VALUES
(2, 2, 'Olistic Women 28 vial de 25 ml', 'CAJA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `serie`
--

CREATE TABLE `serie` (
  `idserie` int(11) NOT NULL,
  `tipocomp` char(2) DEFAULT NULL,
  `serie` char(4) DEFAULT NULL,
  `correlativo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `serie`
--

INSERT INTO `serie` (`idserie`, `tipocomp`, `serie`, `correlativo`) VALUES
(1, '03', 'B001', 11),
(2, '07', 'BN01', 11),
(3, '01', 'F001', 11),
(4, '01', 'F001', 12),
(5, '03', 'B001', 12),
(6, '07', 'FN01', 11),
(7, '00', 'T001', 11),
(8, '03', 'B001', 13),
(9, '03', 'B001', 14),
(10, '00', 'T001', 12),
(11, '07', 'BN01', 12),
(12, '03', 'B001', 15),
(13, '01', 'F001', 13),
(14, '00', 'T001', 13),
(15, '03', 'B001', 16),
(16, '00', 'T001', 14),
(17, '00', 'T001', 15),
(18, '03', 'B001', 17),
(19, '03', 'B001', 18),
(20, '00', 'T001', 16),
(21, '03', 'B001', 19),
(22, '03', 'B001', 20),
(23, '01', 'F001', 14),
(24, '00', 'T001', 17),
(25, '03', 'B001', 21),
(26, '01', 'F001', 15);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sintoma`
--

CREATE TABLE `sintoma` (
  `idsintoma` int(11) NOT NULL,
  `sintoma` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_spanish_ci NOT NULL,
  `idsucu_c` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `sintoma`
--

INSERT INTO `sintoma` (`idsintoma`, `sintoma`, `idsucu_c`) VALUES
(1, 'prueba', 1),
(2, 'tos seca', 1),
(3, 'dolor de espalda', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_afectacion`
--

CREATE TABLE `tipo_afectacion` (
  `idtipoa` int(11) NOT NULL,
  `codigo` char(2) NOT NULL,
  `descripcion` varchar(50) DEFAULT NULL,
  `codigo_afectacion` char(4) DEFAULT NULL,
  `nombre_afectacion` char(3) DEFAULT NULL,
  `tipo_afectacion` char(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_afectacion`
--

INSERT INTO `tipo_afectacion` (`idtipoa`, `codigo`, `descripcion`, `codigo_afectacion`, `nombre_afectacion`, `tipo_afectacion`) VALUES
(1, '10', 'OP. GRAVADAS', '1000', 'IGV', 'VAT'),
(2, '20', 'OP. EXONERADAS', '9997', 'EXO', 'VAT'),
(3, '30', 'OP. INAFECTAS', '9998', 'INA', 'FRE');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_comprobante`
--

CREATE TABLE `tipo_comprobante` (
  `codigo` char(2) NOT NULL,
  `descripcion` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Volcado de datos para la tabla `tipo_comprobante`
--

INSERT INTO `tipo_comprobante` (`codigo`, `descripcion`) VALUES
('00', 'TICKET'),
('01', 'FACTURA'),
('03', 'BOLETA'),
('07', 'NOTA DE CREDITO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_documento`
--

CREATE TABLE `tipo_documento` (
  `idtipo_docu` int(11) NOT NULL,
  `codigo` char(1) NOT NULL,
  `descripcion` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_documento`
--

INSERT INTO `tipo_documento` (`idtipo_docu`, `codigo`, `descripcion`) VALUES
(1, '0', 'SIN DOCUMENTO'),
(2, '1', 'DNI'),
(3, '4', 'CARNET DE EXTRANJERIA'),
(4, '6', 'RUC'),
(5, '7', 'PASAPORTE'),
(6, 'A', 'Ced. Diplomática de identidad');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unidad`
--

CREATE TABLE `unidad` (
  `iduni` int(11) NOT NULL,
  `codigo` char(3) NOT NULL,
  `descripcion` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `unidad`
--

INSERT INTO `unidad` (`iduni`, `codigo`, `descripcion`) VALUES
(1, 'NIU', 'UNIDAD'),
(2, 'EP', 'PAQUETE DE ONCE'),
(3, 'ZZ', 'SERVICIOS'),
(4, 'BO', 'BOTELLA'),
(5, 'P9', 'PAQUETE DE NUEVE'),
(6, 'W2', 'KILOGRAMO'),
(7, 'BX', 'CAJA'),
(8, 'H2', 'MEDIO LITRO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `idusu` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `clave` varchar(50) NOT NULL,
  `cargo_usu` varchar(100) NOT NULL,
  `nombres` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefono` varchar(15) NOT NULL,
  `fechaingreso` date NOT NULL,
  `tipo` varchar(255) NOT NULL,
  `estado` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idusu`, `usuario`, `clave`, `cargo_usu`, `nombres`, `email`, `telefono`, `fechaingreso`, `tipo`, `estado`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'administrador', 'jose perez', 'jose@gmail.com', '123-3434', '2017-09-05', 'ADMINISTRADOR', 'Activo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta`
--

CREATE TABLE `venta` (
  `idventa` int(11) NOT NULL,
  `idconf` int(11) NOT NULL,
  `tipocomp` char(2) NOT NULL,
  `idcliente` int(11) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `idserie` int(11) NOT NULL,
  `fecha_emision` date NOT NULL,
  `op_gravadas` decimal(10,2) NOT NULL,
  `op_exoneradas` decimal(10,2) NOT NULL,
  `op_inafectas` decimal(10,2) NOT NULL,
  `igv` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `feestado` varchar(50) DEFAULT NULL,
  `fecodigoerror` char(10) DEFAULT NULL,
  `femensajesunat` text DEFAULT NULL,
  `nombrexml` varchar(50) DEFAULT NULL,
  `xmlbase64` text DEFAULT NULL,
  `cdrbase64` text DEFAULT NULL,
  `efectivo` decimal(18,2) DEFAULT NULL,
  `vuelto` decimal(18,2) DEFAULT NULL,
  `formadepago` varchar(50) NOT NULL,
  `tire` char(50) NOT NULL,
  `estado` enum('no_enviado','enviado','anulado') NOT NULL,
  `numope` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `venta`
--

INSERT INTO `venta` (`idventa`, `idconf`, `tipocomp`, `idcliente`, `idusuario`, `idserie`, `fecha_emision`, `op_gravadas`, `op_exoneradas`, `op_inafectas`, `igv`, `total`, `feestado`, `fecodigoerror`, `femensajesunat`, `nombrexml`, `xmlbase64`, `cdrbase64`, `efectivo`, `vuelto`, `formadepago`, `tire`, `estado`, `numope`) VALUES
(11, 1, '03', 2, 1, 1, '2025-02-12', 1.02, 0.00, 0.00, 0.18, 1.20, NULL, NULL, 'Aceptada', 'R-20612319198-03-B001-11.XML', NULL, NULL, 2.00, 0.80, 'EFECTIVO', 'noenviado', 'anulado', ''),
(12, 1, '01', 3, 1, 3, '2025-02-12', 1.02, 0.00, 0.00, 0.18, 1.20, NULL, NULL, 'Aceptada', 'R-20612319198-01-F001-11.XML', NULL, NULL, 5.00, 0.00, 'EFECTIVO', 'noenviado', 'enviado', ''),
(13, 1, '01', 4, 1, 4, '2025-02-16', 1.02, 0.00, 0.00, 0.18, 1.20, NULL, NULL, 'Aceptada', 'R-20612319198-01-F001-12.XML', NULL, NULL, 5.00, 0.00, 'EFECTIVO', 'noenviado', 'enviado', ''),
(14, 1, '03', 5, 1, 5, '2025-02-16', 5.10, 0.00, 0.00, 0.92, 6.00, NULL, NULL, 'Aceptada', 'R-23343888776-03-B001-12.XML', NULL, NULL, 0.00, 0.00, 'EFECTIVO', 'noenviado', 'enviado', ''),
(15, 1, '00', 5, 1, 7, '2025-02-23', 5.51, 0.00, 0.00, 0.99, 6.50, 'anulado', NULL, NULL, 'NULL', NULL, NULL, 2.00, 0.00, 'EFECTIVO', 'noenviado', 'no_enviado', ''),
(16, 1, '03', 8, 1, 9, '2025-02-23', 1.02, 0.00, 0.00, 0.18, 1.20, NULL, NULL, 'Aceptada', 'R-23343888776-03-B001-14.XML', NULL, NULL, 0.00, 0.00, 'EFECTIVO', 'noenviado', 'enviado', ''),
(17, 1, '00', 5, 1, 10, '2025-02-26', 27.55, 0.00, 0.00, 4.96, 32.50, NULL, NULL, NULL, 'NULL', NULL, NULL, 0.00, 0.00, 'EFECTIVO', 'noenviado', 'no_enviado', ''),
(18, 1, '03', 5, 1, 12, '2025-03-01', 22.46, 0.00, 0.00, 4.04, 26.50, NULL, NULL, 'Aceptada', 'R-23343888776-03-B001-15.XML', NULL, NULL, 0.00, 0.00, 'EFECTIVO', 'noenviado', 'enviado', ''),
(19, 1, '01', 9, 1, 13, '2025-03-01', 22.46, 0.00, 0.00, 4.04, 26.50, NULL, NULL, 'Aceptada', 'R-23343888776-01-F001-13.XML', NULL, NULL, 20.00, 0.00, 'EFECTIVO', 'noenviado', 'enviado', ''),
(20, 1, '00', 10, 1, 14, '2025-03-02', 90.26, 0.00, 0.00, 16.25, 106.50, NULL, NULL, NULL, 'NULL', NULL, NULL, 0.00, 0.00, 'EFECTIVO', 'noenviado', 'no_enviado', ''),
(21, 1, '03', 11, 1, 15, '2025-03-10', 5.51, 0.00, 0.00, 0.99, 6.50, NULL, NULL, 'Aceptada', 'R-23343888776-03-B001-16.XML', NULL, NULL, 0.00, 0.00, 'EFECTIVO', 'noenviado', 'enviado', ''),
(22, 1, '00', 5, 1, 16, '2025-03-16', 0.25, 0.00, 0.00, 0.05, 0.30, NULL, NULL, NULL, 'NULL', NULL, NULL, 0.00, 0.00, 'EFECTIVO', 'noenviado', 'no_enviado', ''),
(23, 1, '00', 5, 1, 17, '2025-03-17', 6.37, 0.00, 0.00, 1.15, 7.50, NULL, NULL, NULL, 'NULL', NULL, NULL, 0.00, 0.00, 'TARJETA', 'noenviado', 'no_enviado', ''),
(24, 1, '03', 5, 1, 18, '2025-03-17', 16.95, 0.00, 0.00, 3.05, 20.00, NULL, NULL, 'Aceptada', 'R-23343888776-03-B001-17.XML', NULL, NULL, 0.00, 0.00, 'EFECTIVO', 'noenviado', 'enviado', ''),
(25, 1, '03', 5, 1, 19, '2025-03-18', 0.25, 0.00, 0.00, 0.05, 0.30, NULL, NULL, 'Aceptada', 'R-23343888776-03-B001-18.XML', NULL, NULL, 0.00, 0.00, 'EFECTIVO', 'noenviado', 'enviado', ''),
(26, 1, '00', 13, 1, 20, '2025-03-20', 18.22, 0.00, 0.00, 3.28, 21.50, NULL, NULL, NULL, 'NULL', NULL, NULL, 0.00, 0.00, 'EFECTIVO', 'noenviado', 'no_enviado', ''),
(27, 1, '03', 5, 1, 21, '2025-03-24', 1.02, 0.00, 0.00, 0.18, 1.20, NULL, NULL, 'Aceptada', 'R-23343888776-03-B001-19.XML', NULL, NULL, 0.00, 0.00, 'EFECTIVO', 'noenviado', 'enviado', ''),
(28, 1, '03', 14, 1, 22, '2025-03-28', 17.20, 0.00, 0.00, 3.10, 20.30, NULL, NULL, 'Aceptada', 'R-23343888776-03-B001-20.XML', NULL, NULL, 30.00, 9.70, 'EFECTIVO', 'noenviado', 'enviado', ''),
(29, 1, '01', 3, 1, 23, '2025-03-29', 5339.22, 0.00, 0.00, 961.06, 6300.30, NULL, NULL, NULL, 'R-23343888776-01-F001-14.XML', NULL, NULL, 8000.00, 1699.72, 'EFECTIVO', 'noenviado', 'no_enviado', ''),
(30, 1, '00', 3, 1, 24, '2025-03-29', 762.96, 0.00, 0.00, 137.34, 900.30, NULL, NULL, NULL, 'NULL', NULL, NULL, 8000.00, 1699.72, 'EFECTIVO', 'noenviado', 'no_enviado', ''),
(31, 1, '03', 3, 1, 25, '2025-03-29', 780.93, 0.00, 0.00, 140.57, 921.50, NULL, NULL, NULL, 'R-23343888776-03-B001-21.XML', NULL, NULL, 8000.00, 1699.72, 'EFECTIVO', 'noenviado', 'no_enviado', ''),
(32, 1, '01', 3, 1, 26, '2025-03-29', 763.73, 0.00, 0.00, 137.47, 901.20, NULL, NULL, NULL, 'R-23343888776-01-F001-15.XML', NULL, NULL, 1000.00, 98.80, 'EFECTIVO', 'noenviado', 'no_enviado', '');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `caja_apertura`
--
ALTER TABLE `caja_apertura`
  ADD PRIMARY KEY (`idcaja_a`);

--
-- Indices de la tabla `caja_cierre`
--
ALTER TABLE `caja_cierre`
  ADD PRIMARY KEY (`idcaja_c`);

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`idcategoria`);

--
-- Indices de la tabla `certificado`
--
ALTER TABLE `certificado`
  ADD PRIMARY KEY (`idcertificado`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`idcliente`),
  ADD KEY `FK_cliente_tipo_documento_idtipo_docu` (`id_tipo_docu`);

--
-- Indices de la tabla `compra`
--
ALTER TABLE `compra`
  ADD PRIMARY KEY (`idcompra`),
  ADD KEY `FK_compra_proveedor_idprovedor` (`idcliente`);

--
-- Indices de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  ADD PRIMARY KEY (`idconfi`);

--
-- Indices de la tabla `confi_backup`
--
ALTER TABLE `confi_backup`
  ADD PRIMARY KEY (`idbackup`);

--
-- Indices de la tabla `detallecompra`
--
ALTER TABLE `detallecompra`
  ADD KEY `FK_detallecompra_productos_idproducto` (`idproducto`),
  ADD KEY `FK_detallecompra_compra_idcompra` (`idcompra`);

--
-- Indices de la tabla `detalleventa`
--
ALTER TABLE `detalleventa`
  ADD KEY `FK_detalleventa_productos_idproducto` (`idproducto`),
  ADD KEY `FK_detalleventa_venta_idventa` (`idventa`);

--
-- Indices de la tabla `lote`
--
ALTER TABLE `lote`
  ADD PRIMARY KEY (`idlote`);

--
-- Indices de la tabla `moneda`
--
ALTER TABLE `moneda`
  ADD UNIQUE KEY `codigo` (`codigo`);

--
-- Indices de la tabla `nota_credito`
--
ALTER TABLE `nota_credito`
  ADD PRIMARY KEY (`idnota`),
  ADD KEY `FK_nota_credito_configuracion_idconfi` (`idconf`),
  ADD KEY `FK_nota_credito_cliente_idcliente` (`idcliente`),
  ADD KEY `FK_nota_credito_usuario_idusu` (`idusuario`),
  ADD KEY `FK_nota_credito_serie_idserie` (`idserie`);

--
-- Indices de la tabla `presentacion`
--
ALTER TABLE `presentacion`
  ADD PRIMARY KEY (`idpresentacion`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`idproducto`),
  ADD KEY `FK_productos_presentacion_idpresentacion` (`idpresentacion`),
  ADD KEY `FK_productos_categoria_idcategoria` (`idcategoria`),
  ADD KEY `FK_productos_laboratorio_idlab` (`idcliente`),
  ADD KEY `FK_productos_sintoma_idsintoma` (`idsintoma`),
  ADD KEY `FK_productos_lote_idlote` (`idlote`),
  ADD KEY `FK_productos_unidad_iduni` (`idunidad`),
  ADD KEY `FK_productos` (`idtipoaf`);

--
-- Indices de la tabla `producto_similar`
--
ALTER TABLE `producto_similar`
  ADD PRIMARY KEY (`idp_similar`),
  ADD KEY `FK_producto_similar_productos_idproducto` (`idproducto`);

--
-- Indices de la tabla `serie`
--
ALTER TABLE `serie`
  ADD PRIMARY KEY (`idserie`);

--
-- Indices de la tabla `sintoma`
--
ALTER TABLE `sintoma`
  ADD PRIMARY KEY (`idsintoma`);

--
-- Indices de la tabla `tipo_afectacion`
--
ALTER TABLE `tipo_afectacion`
  ADD PRIMARY KEY (`idtipoa`);

--
-- Indices de la tabla `tipo_comprobante`
--
ALTER TABLE `tipo_comprobante`
  ADD UNIQUE KEY `codigo` (`codigo`);

--
-- Indices de la tabla `tipo_documento`
--
ALTER TABLE `tipo_documento`
  ADD PRIMARY KEY (`idtipo_docu`);

--
-- Indices de la tabla `unidad`
--
ALTER TABLE `unidad`
  ADD PRIMARY KEY (`iduni`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idusu`),
  ADD UNIQUE KEY `usuario` (`usuario`);

--
-- Indices de la tabla `venta`
--
ALTER TABLE `venta`
  ADD PRIMARY KEY (`idventa`),
  ADD KEY `FK_venta_usuario_idusu` (`idusuario`),
  ADD KEY `FK_venta_cliente_idcliente` (`idcliente`),
  ADD KEY `FK_venta_configuracion_idconfi` (`idconf`),
  ADD KEY `FK_venta_serie_idserie` (`idserie`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `caja_apertura`
--
ALTER TABLE `caja_apertura`
  MODIFY `idcaja_a` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `caja_cierre`
--
ALTER TABLE `caja_cierre`
  MODIFY `idcaja_c` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `idcategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `certificado`
--
ALTER TABLE `certificado`
  MODIFY `idcertificado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `idcliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `compra`
--
ALTER TABLE `compra`
  MODIFY `idcompra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  MODIFY `idconfi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `lote`
--
ALTER TABLE `lote`
  MODIFY `idlote` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `nota_credito`
--
ALTER TABLE `nota_credito`
  MODIFY `idnota` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `presentacion`
--
ALTER TABLE `presentacion`
  MODIFY `idpresentacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `idproducto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `producto_similar`
--
ALTER TABLE `producto_similar`
  MODIFY `idp_similar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `sintoma`
--
ALTER TABLE `sintoma`
  MODIFY `idsintoma` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idusu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `venta`
--
ALTER TABLE `venta`
  MODIFY `idventa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD CONSTRAINT `FK_cliente_tipo_documento_idtipo_docu` FOREIGN KEY (`id_tipo_docu`) REFERENCES `tipo_documento` (`idtipo_docu`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `compra`
--
ALTER TABLE `compra`
  ADD CONSTRAINT `FK_compra_cliente_idcliente` FOREIGN KEY (`idcliente`) REFERENCES `cliente` (`idcliente`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `detallecompra`
--
ALTER TABLE `detallecompra`
  ADD CONSTRAINT `FK_detallecompra_compra_idcompra` FOREIGN KEY (`idcompra`) REFERENCES `compra` (`idcompra`),
  ADD CONSTRAINT `FK_detallecompra_productos_idproducto` FOREIGN KEY (`idproducto`) REFERENCES `productos` (`idproducto`);

--
-- Filtros para la tabla `detalleventa`
--
ALTER TABLE `detalleventa`
  ADD CONSTRAINT `FK_detalleventa_productos_idproducto` FOREIGN KEY (`idproducto`) REFERENCES `productos` (`idproducto`),
  ADD CONSTRAINT `FK_detalleventa_venta_idventa` FOREIGN KEY (`idventa`) REFERENCES `venta` (`idventa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `nota_credito`
--
ALTER TABLE `nota_credito`
  ADD CONSTRAINT `FK_nota_credito_cliente_idcliente` FOREIGN KEY (`idcliente`) REFERENCES `cliente` (`idcliente`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_nota_credito_configuracion_idconfi` FOREIGN KEY (`idconf`) REFERENCES `configuracion` (`idconfi`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_nota_credito_serie_idserie` FOREIGN KEY (`idserie`) REFERENCES `serie` (`idserie`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_nota_credito_usuario_idusu` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`idusu`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `FK_productos` FOREIGN KEY (`idtipoaf`) REFERENCES `tipo_afectacion` (`idtipoa`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_productos_categoria_idcategoria` FOREIGN KEY (`idcategoria`) REFERENCES `categoria` (`idcategoria`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_productos_cliente_idcliente` FOREIGN KEY (`idcliente`) REFERENCES `cliente` (`idcliente`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_productos_lote_idlote` FOREIGN KEY (`idlote`) REFERENCES `lote` (`idlote`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_productos_presentacion_idpresentacion` FOREIGN KEY (`idpresentacion`) REFERENCES `presentacion` (`idpresentacion`),
  ADD CONSTRAINT `FK_productos_sintoma_idsintoma` FOREIGN KEY (`idsintoma`) REFERENCES `sintoma` (`idsintoma`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_productos_unidad_iduni` FOREIGN KEY (`idunidad`) REFERENCES `unidad` (`iduni`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `producto_similar`
--
ALTER TABLE `producto_similar`
  ADD CONSTRAINT `FK_producto_similar_productos_idproducto` FOREIGN KEY (`idproducto`) REFERENCES `productos` (`idproducto`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `venta`
--
ALTER TABLE `venta`
  ADD CONSTRAINT `FK_venta_cliente_idcliente` FOREIGN KEY (`idcliente`) REFERENCES `cliente` (`idcliente`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_venta_configuracion_idconfi` FOREIGN KEY (`idconf`) REFERENCES `configuracion` (`idconfi`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_venta_serie_idserie` FOREIGN KEY (`idserie`) REFERENCES `serie` (`idserie`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_venta_usuario_idusu` FOREIGN KEY (`idusuario`) REFERENCES `usuario` (`idusu`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
