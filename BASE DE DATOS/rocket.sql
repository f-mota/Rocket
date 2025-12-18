-- Rocket Rent a Car - Backup
-- Generation Time: 2025-12-18 01:36:11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

SET foreign_key_checks = 0;

-- --------------------------------------------------------
-- Table structure for table `accesorios-vehiculos`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `accesorios-vehiculos`;
CREATE TABLE `accesorios-vehiculos` (
  `idAccesorio` int(11) NOT NULL AUTO_INCREMENT,
  `nombreAccesorio` varchar(50) NOT NULL,
  `descripcionAccesorio` varchar(200) DEFAULT NULL COMMENT 'Campo optativo con una descripción del accesorio, en caso de requerirse',
  `cantidadEnDeposito` int(11) DEFAULT NULL COMMENT 'Cantidad de unidades que conforman el lote comprado',
  `precioAccesorio` float DEFAULT NULL COMMENT 'Precio unitario',
  `estadoAccesorio` varchar(100) DEFAULT NULL COMMENT 'Campo optativo con referencias al estado del accesorio o el lote de accesorios',
  `idTipoInsumo` int(11) DEFAULT NULL,
  `idProveedor` int(11) DEFAULT NULL,
  `disponibilidadAccesorio` varchar(200) DEFAULT NULL COMMENT 'Campo en donde se puede especificar cuántos accesorios están en uso o libres para ser usados en vehículos',
  `vehiculosHospedantes` varchar(200) DEFAULT NULL COMMENT 'Campo optativo para el caso de que uno esté siendo utilizado en un vehículo. Mencionar vehículos separando con comas',
  PRIMARY KEY (`idAccesorio`),
  KEY `idTipoInsumo` (`idTipoInsumo`),
  KEY `idProveedor` (`idProveedor`),
  CONSTRAINT `accesorios-vehiculos_ibfk_1` FOREIGN KEY (`idTipoInsumo`) REFERENCES `tipo-insumo` (`idTipoInsumo`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `accesorios-vehiculos_ibfk_2` FOREIGN KEY (`idProveedor`) REFERENCES `proveedores` (`idProveedor`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `accesorios-vehiculos`
--

INSERT INTO `accesorios-vehiculos` (`idAccesorio`, `nombreAccesorio`, `descripcionAccesorio`, `cantidadEnDeposito`, `precioAccesorio`, `estadoAccesorio`, `idTipoInsumo`, `idProveedor`, `disponibilidadAccesorio`, `vehiculosHospedantes`) VALUES ('1', 'Alfombrillas de vehículo marca FORD', '', '5', '17', 'Aún no recibido', '3', '11', NULL, NULL);
INSERT INTO `accesorios-vehiculos` (`idAccesorio`, `nombreAccesorio`, `descripcionAccesorio`, `cantidadEnDeposito`, `precioAccesorio`, `estadoAccesorio`, `idTipoInsumo`, `idProveedor`, `disponibilidadAccesorio`, `vehiculosHospedantes`) VALUES ('2', 'Extintor marca EXTINCENTER', '-', '5', '32.2', 'Aún no recibido', '3', '9', NULL, NULL);
INSERT INTO `accesorios-vehiculos` (`idAccesorio`, `nombreAccesorio`, `descripcionAccesorio`, `cantidadEnDeposito`, `precioAccesorio`, `estadoAccesorio`, `idTipoInsumo`, `idProveedor`, `disponibilidadAccesorio`, `vehiculosHospedantes`) VALUES ('3', 'Guardabarros universales marca MAXUS', 'Adaptables a la mayoría de los vehículos', '6', '17.2', 'Aún no recibido', '3', '9', NULL, NULL);
INSERT INTO `accesorios-vehiculos` (`idAccesorio`, `nombreAccesorio`, `descripcionAccesorio`, `cantidadEnDeposito`, `precioAccesorio`, `estadoAccesorio`, `idTipoInsumo`, `idProveedor`, `disponibilidadAccesorio`, `vehiculosHospedantes`) VALUES ('4', 'Cargadores para automovil genéricos', '-', '10', '14.5', 'Aún no recibido', '3', '1', NULL, NULL);
INSERT INTO `accesorios-vehiculos` (`idAccesorio`, `nombreAccesorio`, `descripcionAccesorio`, `cantidadEnDeposito`, `precioAccesorio`, `estadoAccesorio`, `idTipoInsumo`, `idProveedor`, `disponibilidadAccesorio`, `vehiculosHospedantes`) VALUES ('5', 'Deflectores de viento marca BELL', 'Gama media', '3', '20', 'Aún no recibido', '3', '8', NULL, NULL);
INSERT INTO `accesorios-vehiculos` (`idAccesorio`, `nombreAccesorio`, `descripcionAccesorio`, `cantidadEnDeposito`, `precioAccesorio`, `estadoAccesorio`, `idTipoInsumo`, `idProveedor`, `disponibilidadAccesorio`, `vehiculosHospedantes`) VALUES ('6', 'Barras de techo genéricas', 'Barras genéricas para transportar cargas en el techo', '2', '15', 'Aún no recibido', '3', '8', NULL, NULL);
INSERT INTO `accesorios-vehiculos` (`idAccesorio`, `nombreAccesorio`, `descripcionAccesorio`, `cantidadEnDeposito`, `precioAccesorio`, `estadoAccesorio`, `idTipoInsumo`, `idProveedor`, `disponibilidadAccesorio`, `vehiculosHospedantes`) VALUES ('7', 'Pantalla tactil', 'Pantalla tactil para dashboard', '1', '125', 'Aún no recibido', '3', '9', NULL, NULL);
INSERT INTO `accesorios-vehiculos` (`idAccesorio`, `nombreAccesorio`, `descripcionAccesorio`, `cantidadEnDeposito`, `precioAccesorio`, `estadoAccesorio`, `idTipoInsumo`, `idProveedor`, `disponibilidadAccesorio`, `vehiculosHospedantes`) VALUES ('8', 'Aromatizantes tecno', 'Aromatizantes para vehiculos', '10', '13.2', 'Aún no recibido', '3', '9', NULL, NULL);

-- --------------------------------------------------------
-- Table structure for table `cargo`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `cargo`;
CREATE TABLE `cargo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Dumping data for table `cargo`
--

INSERT INTO `cargo` (`id`, `descripcion`) VALUES ('1', 'ADMINISTRADOR');
INSERT INTO `cargo` (`id`, `descripcion`) VALUES ('2', 'GERENTE_OPERACIONES');
INSERT INTO `cargo` (`id`, `descripcion`) VALUES ('3', 'GERENTE_COMERCIAL');
INSERT INTO `cargo` (`id`, `descripcion`) VALUES ('4', 'GERENTE_TALLER');
INSERT INTO `cargo` (`id`, `descripcion`) VALUES ('5', 'ENCARGADO_ATPUBLICO');
INSERT INTO `cargo` (`id`, `descripcion`) VALUES ('6', 'ENCARGADO_VENTAS');
INSERT INTO `cargo` (`id`, `descripcion`) VALUES ('7', 'ENCARGADO_TALLER');
INSERT INTO `cargo` (`id`, `descripcion`) VALUES ('8', 'ENCARGADO_COMPRAS');
INSERT INTO `cargo` (`id`, `descripcion`) VALUES ('9', 'OPERATIVO_ATPUBLICO');
INSERT INTO `cargo` (`id`, `descripcion`) VALUES ('10', 'OPERATIVO_VENTAS');
INSERT INTO `cargo` (`id`, `descripcion`) VALUES ('11', 'OPERATIVO_TALLER');
INSERT INTO `cargo` (`id`, `descripcion`) VALUES ('12', 'OPERATIVO_COMPRAS');

-- --------------------------------------------------------
-- Table structure for table `clientes`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `clientes`;
CREATE TABLE `clientes` (
  `idCliente` int(11) NOT NULL AUTO_INCREMENT,
  `nombreCliente` varchar(50) NOT NULL,
  `apellidoCliente` varchar(50) NOT NULL,
  `nacionalidadCliente` varchar(50) DEFAULT NULL,
  `dniCliente` int(10) NOT NULL,
  `nroPasaporteCliente` int(11) DEFAULT NULL,
  `mailCliente` varchar(50) DEFAULT NULL,
  `telefonoCliente` int(20) DEFAULT NULL,
  `ciudadCliente` varchar(50) DEFAULT NULL,
  `direccionCliente` varchar(50) NOT NULL,
  `comprobanteDomicilio` int(1) DEFAULT NULL,
  `propositoAlquiler` varchar(100) DEFAULT NULL,
  `licenciaConducir` varchar(10) DEFAULT NULL,
  `licenciaInternacionalConducir` int(11) DEFAULT NULL,
  `tarjetaCredito_titular` varchar(50) DEFAULT NULL,
  `tarjetaCredito_numero` int(11) DEFAULT NULL,
  `tarjetaCredito_vencim` date DEFAULT NULL,
  `tarjetaCredito_codSeguridad` int(11) DEFAULT NULL,
  `seguroCliente_nombre` varchar(100) DEFAULT NULL,
  `seguroCliente_tipo` varchar(100) DEFAULT NULL,
  `seguroCliente_descripcion` varchar(100) DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`idCliente`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clientes`
--

INSERT INTO `clientes` (`idCliente`, `nombreCliente`, `apellidoCliente`, `nacionalidadCliente`, `dniCliente`, `nroPasaporteCliente`, `mailCliente`, `telefonoCliente`, `ciudadCliente`, `direccionCliente`, `comprobanteDomicilio`, `propositoAlquiler`, `licenciaConducir`, `licenciaInternacionalConducir`, `tarjetaCredito_titular`, `tarjetaCredito_numero`, `tarjetaCredito_vencim`, `tarjetaCredito_codSeguridad`, `seguroCliente_nombre`, `seguroCliente_tipo`, `seguroCliente_descripcion`, `activo`) VALUES ('1', 'Bruno', 'Carossi', 'Argentina', '38103736', NULL, 'brunocarossi@hotmail.com', '2147483647', 'JUAN ANCHORENA', '829 Av Malvinas Argentinas', '1', NULL, 'B2', NULL, 'Visa BRUNO CAROSSI', '3323332', '2024-12-01', NULL, 'Zurich Argentina', 'A', NULL, '0');
INSERT INTO `clientes` (`idCliente`, `nombreCliente`, `apellidoCliente`, `nacionalidadCliente`, `dniCliente`, `nroPasaporteCliente`, `mailCliente`, `telefonoCliente`, `ciudadCliente`, `direccionCliente`, `comprobanteDomicilio`, `propositoAlquiler`, `licenciaConducir`, `licenciaInternacionalConducir`, `tarjetaCredito_titular`, `tarjetaCredito_numero`, `tarjetaCredito_vencim`, `tarjetaCredito_codSeguridad`, `seguroCliente_nombre`, `seguroCliente_tipo`, `seguroCliente_descripcion`, `activo`) VALUES ('2', 'Lucia', 'HRASTE', 'Argentina', '31741578', NULL, 'lucia@hotmail.com', '214748368', 'URQUIZA', '829 Av Malvinas Argentinas', '1', NULL, 'B2', NULL, 'Visa LUCIA HRASTE', '2233323', '2024-11-30', NULL, 'San Cristobal', 'A', NULL, '0');
INSERT INTO `clientes` (`idCliente`, `nombreCliente`, `apellidoCliente`, `nacionalidadCliente`, `dniCliente`, `nroPasaporteCliente`, `mailCliente`, `telefonoCliente`, `ciudadCliente`, `direccionCliente`, `comprobanteDomicilio`, `propositoAlquiler`, `licenciaConducir`, `licenciaInternacionalConducir`, `tarjetaCredito_titular`, `tarjetaCredito_numero`, `tarjetaCredito_vencim`, `tarjetaCredito_codSeguridad`, `seguroCliente_nombre`, `seguroCliente_tipo`, `seguroCliente_descripcion`, `activo`) VALUES ('3', 'Eduardo Facundo', 'Mota', 'Argentina', '38343866', NULL, 'facundo@hotmail.com', '31474836', 'SIERRA DE LA VENTANA', '828 Av Malvinas Argentinas', '1', NULL, 'B2', NULL, 'Visa EDUARDO FACUNDO MOTA', '8949389', '2025-07-30', NULL, 'Seguros Rivadavia', 'A', NULL, '1');
INSERT INTO `clientes` (`idCliente`, `nombreCliente`, `apellidoCliente`, `nacionalidadCliente`, `dniCliente`, `nroPasaporteCliente`, `mailCliente`, `telefonoCliente`, `ciudadCliente`, `direccionCliente`, `comprobanteDomicilio`, `propositoAlquiler`, `licenciaConducir`, `licenciaInternacionalConducir`, `tarjetaCredito_titular`, `tarjetaCredito_numero`, `tarjetaCredito_vencim`, `tarjetaCredito_codSeguridad`, `seguroCliente_nombre`, `seguroCliente_tipo`, `seguroCliente_descripcion`, `activo`) VALUES ('4', 'Roberto', 'Sanchez', 'Argentina', '77433645', NULL, 'roberto@gmail.com', '55147483', 'CABA', '821 Av Malvinas Argentinas', '0', NULL, 'B2', NULL, NULL, NULL, NULL, NULL, 'San Cristobal', 'C', NULL, '1');
INSERT INTO `clientes` (`idCliente`, `nombreCliente`, `apellidoCliente`, `nacionalidadCliente`, `dniCliente`, `nroPasaporteCliente`, `mailCliente`, `telefonoCliente`, `ciudadCliente`, `direccionCliente`, `comprobanteDomicilio`, `propositoAlquiler`, `licenciaConducir`, `licenciaInternacionalConducir`, `tarjetaCredito_titular`, `tarjetaCredito_numero`, `tarjetaCredito_vencim`, `tarjetaCredito_codSeguridad`, `seguroCliente_nombre`, `seguroCliente_tipo`, `seguroCliente_descripcion`, `activo`) VALUES ('5', 'Maria', 'Ricardi', 'Argentina', '33224445', NULL, 'maria@gmail.com', '31474838', 'CABA', '222 Av Malvinas Argentinas', '0', NULL, 'B2', NULL, NULL, NULL, NULL, NULL, 'Seguros Rivadavia', 'A', NULL, '1');
INSERT INTO `clientes` (`idCliente`, `nombreCliente`, `apellidoCliente`, `nacionalidadCliente`, `dniCliente`, `nroPasaporteCliente`, `mailCliente`, `telefonoCliente`, `ciudadCliente`, `direccionCliente`, `comprobanteDomicilio`, `propositoAlquiler`, `licenciaConducir`, `licenciaInternacionalConducir`, `tarjetaCredito_titular`, `tarjetaCredito_numero`, `tarjetaCredito_vencim`, `tarjetaCredito_codSeguridad`, `seguroCliente_nombre`, `seguroCliente_tipo`, `seguroCliente_descripcion`, `activo`) VALUES ('6', 'Ana', 'Smith', 'Argentina', '33244232', NULL, 'ana@gmail.com', '77474839', 'CABA', '223 Av Malvinas Argentinas', '0', NULL, 'B2', NULL, NULL, NULL, NULL, NULL, 'San Cristobal', 'A', NULL, '1');
INSERT INTO `clientes` (`idCliente`, `nombreCliente`, `apellidoCliente`, `nacionalidadCliente`, `dniCliente`, `nroPasaporteCliente`, `mailCliente`, `telefonoCliente`, `ciudadCliente`, `direccionCliente`, `comprobanteDomicilio`, `propositoAlquiler`, `licenciaConducir`, `licenciaInternacionalConducir`, `tarjetaCredito_titular`, `tarjetaCredito_numero`, `tarjetaCredito_vencim`, `tarjetaCredito_codSeguridad`, `seguroCliente_nombre`, `seguroCliente_tipo`, `seguroCliente_descripcion`, `activo`) VALUES ('7', 'Gabriel', 'Garcia', 'Argentina', '44555999', NULL, 'gabriel@hotmail.com', '41474831', 'MAR DEL PLATA', '332 Av Malvinas Argentinas', '1', NULL, 'B2', NULL, 'Mastercard GABRIEL GARCIA', NULL, '2024-11-14', NULL, 'Zurich Argentina', 'B', NULL, '1');
INSERT INTO `clientes` (`idCliente`, `nombreCliente`, `apellidoCliente`, `nacionalidadCliente`, `dniCliente`, `nroPasaporteCliente`, `mailCliente`, `telefonoCliente`, `ciudadCliente`, `direccionCliente`, `comprobanteDomicilio`, `propositoAlquiler`, `licenciaConducir`, `licenciaInternacionalConducir`, `tarjetaCredito_titular`, `tarjetaCredito_numero`, `tarjetaCredito_vencim`, `tarjetaCredito_codSeguridad`, `seguroCliente_nombre`, `seguroCliente_tipo`, `seguroCliente_descripcion`, `activo`) VALUES ('8', 'Rosa', 'Alonso', 'Argentina', '33222444', NULL, 'rosa@hotmail.com', '51474832', 'MAR DEL PLATA', '444 Av Malvinas Argentinas', '1', NULL, 'B2', NULL, 'Visa ROSA ALONSO', NULL, '2024-11-15', NULL, 'Seguros Rivadavia', 'D', NULL, '1');
INSERT INTO `clientes` (`idCliente`, `nombreCliente`, `apellidoCliente`, `nacionalidadCliente`, `dniCliente`, `nroPasaporteCliente`, `mailCliente`, `telefonoCliente`, `ciudadCliente`, `direccionCliente`, `comprobanteDomicilio`, `propositoAlquiler`, `licenciaConducir`, `licenciaInternacionalConducir`, `tarjetaCredito_titular`, `tarjetaCredito_numero`, `tarjetaCredito_vencim`, `tarjetaCredito_codSeguridad`, `seguroCliente_nombre`, `seguroCliente_tipo`, `seguroCliente_descripcion`, `activo`) VALUES ('9', 'Rosario', 'Acosta', 'Argentina', '77888444', NULL, 'rosario@hotmail.com', '61474833', 'CORDOBA', '555 Av Malvinas Argentinas', '1', NULL, 'B2', NULL, 'Visa ROSARIO ACOSTA', NULL, '2024-11-15', NULL, 'Seguros Rivadavia', 'A', NULL, '0');
INSERT INTO `clientes` (`idCliente`, `nombreCliente`, `apellidoCliente`, `nacionalidadCliente`, `dniCliente`, `nroPasaporteCliente`, `mailCliente`, `telefonoCliente`, `ciudadCliente`, `direccionCliente`, `comprobanteDomicilio`, `propositoAlquiler`, `licenciaConducir`, `licenciaInternacionalConducir`, `tarjetaCredito_titular`, `tarjetaCredito_numero`, `tarjetaCredito_vencim`, `tarjetaCredito_codSeguridad`, `seguroCliente_nombre`, `seguroCliente_tipo`, `seguroCliente_descripcion`, `activo`) VALUES ('10', 'Francisco Juan', 'Lopez', 'Argentina', '66332557', NULL, 'francisco@hotmail.com', '71474834', 'CORDOBA', '666 Av Malvinas Argentinas', '1', NULL, 'B2', NULL, 'Mastercard FRANCISCO JUAN LOPEZ', NULL, '2024-11-15', NULL, 'San Cristobal', 'B', NULL, '1');
INSERT INTO `clientes` (`idCliente`, `nombreCliente`, `apellidoCliente`, `nacionalidadCliente`, `dniCliente`, `nroPasaporteCliente`, `mailCliente`, `telefonoCliente`, `ciudadCliente`, `direccionCliente`, `comprobanteDomicilio`, `propositoAlquiler`, `licenciaConducir`, `licenciaInternacionalConducir`, `tarjetaCredito_titular`, `tarjetaCredito_numero`, `tarjetaCredito_vencim`, `tarjetaCredito_codSeguridad`, `seguroCliente_nombre`, `seguroCliente_tipo`, `seguroCliente_descripcion`, `activo`) VALUES ('11', 'Lorena', 'Berlusconi', 'Argentina', '443332555', NULL, 'lorena@hotmail.com', '81474891', 'VILLA CARLOS PAZ', '777 Av Malvinas Argentinas', '1', NULL, 'B2', NULL, 'Visa LORENA BERLUSCONI', NULL, '2024-12-15', NULL, 'Zurich Argentina', 'A', NULL, '1');
INSERT INTO `clientes` (`idCliente`, `nombreCliente`, `apellidoCliente`, `nacionalidadCliente`, `dniCliente`, `nroPasaporteCliente`, `mailCliente`, `telefonoCliente`, `ciudadCliente`, `direccionCliente`, `comprobanteDomicilio`, `propositoAlquiler`, `licenciaConducir`, `licenciaInternacionalConducir`, `tarjetaCredito_titular`, `tarjetaCredito_numero`, `tarjetaCredito_vencim`, `tarjetaCredito_codSeguridad`, `seguroCliente_nombre`, `seguroCliente_tipo`, `seguroCliente_descripcion`, `activo`) VALUES ('12', 'Nicolás', 'Servidio', 'Argentina', '33222558', NULL, 'nicolas@hotmail.com', '91474892', 'BAHIA BLANCA', '888 Av Malvinas Argentinas', '1', NULL, 'B2', NULL, 'Visa NICOLAS SERVIDIO', NULL, '2024-11-25', NULL, 'Zurich Argentina', 'A', NULL, '1');
INSERT INTO `clientes` (`idCliente`, `nombreCliente`, `apellidoCliente`, `nacionalidadCliente`, `dniCliente`, `nroPasaporteCliente`, `mailCliente`, `telefonoCliente`, `ciudadCliente`, `direccionCliente`, `comprobanteDomicilio`, `propositoAlquiler`, `licenciaConducir`, `licenciaInternacionalConducir`, `tarjetaCredito_titular`, `tarjetaCredito_numero`, `tarjetaCredito_vencim`, `tarjetaCredito_codSeguridad`, `seguroCliente_nombre`, `seguroCliente_tipo`, `seguroCliente_descripcion`, `activo`) VALUES ('15', 'Padme', 'Amidala', NULL, '33222557', NULL, 'padme@gmail.com', '44656324', NULL, '323 Organa, Naboo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1');
INSERT INTO `clientes` (`idCliente`, `nombreCliente`, `apellidoCliente`, `nacionalidadCliente`, `dniCliente`, `nroPasaporteCliente`, `mailCliente`, `telefonoCliente`, `ciudadCliente`, `direccionCliente`, `comprobanteDomicilio`, `propositoAlquiler`, `licenciaConducir`, `licenciaInternacionalConducir`, `tarjetaCredito_titular`, `tarjetaCredito_numero`, `tarjetaCredito_vencim`, `tarjetaCredito_codSeguridad`, `seguroCliente_nombre`, `seguroCliente_tipo`, `seguroCliente_descripcion`, `activo`) VALUES ('17', 'Ana', 'Rossi', NULL, '33256642', NULL, 'anarossi@gmail.com', '455887241', NULL, '1498 Cuyo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1');

-- --------------------------------------------------------
-- Table structure for table `combustibles`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `combustibles`;
CREATE TABLE `combustibles` (
  `idCombustible` int(11) NOT NULL AUTO_INCREMENT,
  `tipoCombustible` varchar(20) NOT NULL,
  PRIMARY KEY (`idCombustible`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `combustibles`
--

INSERT INTO `combustibles` (`idCombustible`, `tipoCombustible`) VALUES ('1', 'INFINIA TC2000');
INSERT INTO `combustibles` (`idCombustible`, `tipoCombustible`) VALUES ('2', 'INFINIA Top Race');
INSERT INTO `combustibles` (`idCombustible`, `tipoCombustible`) VALUES ('3', 'INFINIA Rally Argent');
INSERT INTO `combustibles` (`idCombustible`, `tipoCombustible`) VALUES ('4', 'INFINIA CARX');
INSERT INTO `combustibles` (`idCombustible`, `tipoCombustible`) VALUES ('5', 'Axion Diesel');
INSERT INTO `combustibles` (`idCombustible`, `tipoCombustible`) VALUES ('6', 'Axion Power Diesel');
INSERT INTO `combustibles` (`idCombustible`, `tipoCombustible`) VALUES ('7', 'Axion Turbo Diesel');
INSERT INTO `combustibles` (`idCombustible`, `tipoCombustible`) VALUES ('8', 'Shell V-Power');
INSERT INTO `combustibles` (`idCombustible`, `tipoCombustible`) VALUES ('9', 'A definir');

-- --------------------------------------------------------
-- Table structure for table `contratos-alquiler`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `contratos-alquiler`;
CREATE TABLE `contratos-alquiler` (
  `idContrato` int(11) NOT NULL AUTO_INCREMENT,
  `fechaInicioContrato` date DEFAULT NULL,
  `fechaFinContrato` date DEFAULT NULL,
  `fechaEntrega` date DEFAULT NULL,
  `fechaDevolucion` date DEFAULT NULL,
  `idCliente` int(11) DEFAULT NULL,
  `idVehiculo` int(11) DEFAULT NULL,
  `idVendedor` int(11) DEFAULT NULL,
  `idDetalleContrato` int(11) DEFAULT NULL,
  `idEstadoContrato` int(11) DEFAULT NULL,
  PRIMARY KEY (`idContrato`),
  KEY `contratosalquiler_ibfk_1` (`idCliente`),
  KEY `idVehiculo` (`idVehiculo`),
  KEY `idVendedor` (`idVendedor`),
  KEY `idDetalleContrato` (`idDetalleContrato`),
  KEY `idEstadoContrato` (`idEstadoContrato`),
  CONSTRAINT `contratos-alquiler_ibfk_1` FOREIGN KEY (`idCliente`) REFERENCES `clientes` (`idCliente`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `contratos-alquiler_ibfk_2` FOREIGN KEY (`idVehiculo`) REFERENCES `vehiculos` (`idVehiculo`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `contratos-alquiler_ibfk_3` FOREIGN KEY (`idVendedor`) REFERENCES `vendedores` (`idVendedor`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `contratos-alquiler_ibfk_4` FOREIGN KEY (`idDetalleContrato`) REFERENCES `detalle-contratos` (`idDetalleContrato`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `contratos-alquiler_ibfk_5` FOREIGN KEY (`idEstadoContrato`) REFERENCES `estados-contratos` (`idEstadoContrato`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=145 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `contratos-alquiler`
--

INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('1', '2024-12-01', '2024-12-03', NULL, NULL, '12', '32', NULL, '1', '6');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('2', '2024-12-02', '2024-12-09', NULL, NULL, '9', '24', NULL, '2', '6');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('3', '2024-12-08', '2024-12-10', NULL, NULL, '15', '21', NULL, '3', '4');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('4', '2024-12-06', '2024-12-09', NULL, NULL, '6', '2', NULL, '4', '6');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('5', '2024-12-08', '2024-12-10', NULL, NULL, '7', '19', NULL, '5', '6');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('7', '2024-12-09', '2025-04-04', NULL, NULL, '11', '6', NULL, '7', '6');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('8', '2024-12-11', '2024-12-13', NULL, NULL, '17', '24', NULL, '8', '6');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('10', '2024-12-14', '2024-12-16', NULL, NULL, '7', '28', NULL, '10', '6');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('11', '2024-12-15', '2024-12-17', NULL, NULL, '8', '20', NULL, '11', '4');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('12', '2024-12-17', '2024-12-20', NULL, NULL, '7', '32', NULL, '12', '4');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('13', '2024-12-17', '2024-12-20', NULL, NULL, '8', '6', NULL, '13', '4');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('14', '2024-12-11', '2024-12-27', NULL, NULL, '6', '19', NULL, '14', '4');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('15', '2024-12-14', '2025-01-04', NULL, NULL, '12', '36', NULL, '15', '4');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('16', '2024-12-31', '2025-01-04', NULL, NULL, '15', '35', NULL, '16', '3');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('17', '2025-01-01', '2025-01-03', NULL, '2025-01-05', '1', '24', NULL, '17', '6');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('18', '2025-01-02', '2025-01-04', NULL, NULL, '3', '1', NULL, '18', '6');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('19', '2024-01-01', '2024-01-05', NULL, NULL, '6', '2', NULL, '19', '6');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('20', '2024-01-02', '2024-01-07', NULL, NULL, '4', '32', NULL, '20', '6');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('21', '2024-01-02', '2024-01-05', NULL, NULL, '5', '3', NULL, '21', '6');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('22', '2024-01-03', '2024-01-11', NULL, NULL, '7', '35', NULL, '22', '6');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('23', '2024-01-05', '2024-01-10', NULL, NULL, '1', '7', NULL, '23', '6');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('24', '2024-01-05', '2024-01-10', NULL, NULL, '2', '19', NULL, '24', '6');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('25', '2024-01-09', '2024-01-12', NULL, NULL, '3', '30', NULL, '25', '3');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('26', '2024-01-11', '2024-01-17', NULL, NULL, '8', '6', NULL, '26', '3');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('27', '2024-01-16', '2024-01-19', NULL, NULL, '9', '1', NULL, '27', '6');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('28', '2024-01-18', '2024-01-23', NULL, NULL, '10', '28', NULL, '28', '4');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('29', '2024-01-20', '2024-01-24', NULL, NULL, '11', '18', NULL, '29', '3');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('30', '2024-01-21', '2024-01-29', NULL, NULL, '12', '21', NULL, '30', '6');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('31', '2024-01-25', '2024-01-27', NULL, NULL, '15', '23', NULL, '31', '6');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('32', '2024-01-27', '2024-01-30', NULL, NULL, '17', '24', NULL, '32', '6');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('33', '2024-01-27', '2024-01-29', NULL, NULL, '1', '36', NULL, '33', '6');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('34', '2024-01-29', '2024-02-02', NULL, NULL, '2', '20', NULL, '34', '3');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('35', '2024-02-01', '2024-02-03', NULL, NULL, '3', '2', NULL, '35', '6');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('36', '2024-02-02', '2024-02-03', NULL, NULL, '4', '32', NULL, '36', '6');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('37', '2024-02-03', '2024-02-05', NULL, NULL, '5', '3', NULL, '37', '6');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('38', '2024-02-05', '2024-02-06', NULL, NULL, '6', '35', NULL, '38', '6');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('39', '2024-02-05', '2024-02-10', NULL, NULL, '7', '7', NULL, '39', '6');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('40', '2024-02-07', '2024-02-09', NULL, NULL, '8', '19', NULL, '40', '6');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('41', '2024-02-09', '2024-02-12', NULL, NULL, '9', '30', NULL, '41', '3');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('42', '2024-02-10', '2024-02-14', NULL, NULL, '10', '6', NULL, '42', '6');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('43', '2024-02-12', '2024-02-15', NULL, NULL, '11', '25', NULL, '43', '6');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('44', '2024-02-13', '2024-02-16', NULL, NULL, '12', '1', NULL, '44', '6');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('45', '2024-02-15', '2024-02-17', NULL, NULL, '15', '28', NULL, '45', '3');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('46', '2024-02-17', '2024-02-20', NULL, NULL, '17', '18', NULL, '46', '3');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('47', '2024-02-20', '2024-02-24', NULL, NULL, '1', '21', NULL, '47', '6');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('48', '2024-02-20', '2024-02-29', NULL, NULL, '2', '23', NULL, '48', '6');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('49', '2024-02-21', '2024-02-23', NULL, NULL, '3', '24', NULL, '49', '6');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('50', '2024-02-24', '2024-02-27', NULL, NULL, '4', '36', NULL, '50', '6');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('51', '2024-02-24', '2024-02-27', NULL, NULL, '5', '20', NULL, '51', '6');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('52', '2024-02-25', '2024-02-27', NULL, NULL, '6', '2', NULL, '52', '6');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('53', '2024-02-25', '2024-02-28', NULL, NULL, '7', '32', NULL, '53', '6');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('54', '2024-02-27', '2024-02-29', NULL, NULL, '8', '35', NULL, '54', '6');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('55', '2024-02-29', '2024-03-05', NULL, NULL, '12', '3', NULL, '55', '6');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('56', '2024-02-29', '2024-03-04', NULL, NULL, '11', '35', NULL, '56', '3');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('57', '2024-03-01', '2024-03-02', NULL, NULL, '15', '7', NULL, '57', '6');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('58', '2024-03-01', '2024-03-04', NULL, NULL, '17', '19', NULL, '58', '6');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('59', '2024-03-02', '2024-03-05', NULL, NULL, '9', '2', NULL, '59', '6');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('60', '2024-03-02', '2024-03-07', NULL, NULL, '10', '32', NULL, '60', '6');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('61', '2024-03-02', '2024-03-05', NULL, NULL, '11', '3', NULL, '61', '6');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('62', '2024-03-03', '2024-03-07', NULL, NULL, '12', '35', NULL, '62', '6');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('63', '2024-03-03', '2024-03-09', NULL, NULL, '15', '7', NULL, '63', '6');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('64', '2024-03-04', '2024-03-05', NULL, NULL, '1', '19', NULL, '64', '6');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('65', '2024-03-05', '2024-03-06', NULL, NULL, '2', '30', NULL, '65', '6');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('66', '2024-03-06', '2024-03-11', NULL, NULL, '3', '6', NULL, '66', '6');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('67', '2024-03-07', '2024-03-10', NULL, NULL, '4', '25', NULL, '67', '6');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('68', '2024-03-07', '2024-03-10', NULL, NULL, '5', '1', NULL, '68', '3');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('69', '2024-03-08', '2024-03-11', NULL, NULL, '6', '28', NULL, '69', '3');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('70', '2024-03-09', '2024-03-11', NULL, NULL, '7', '18', NULL, '70', '6');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('71', '2024-03-09', '2024-03-12', NULL, NULL, '8', '21', NULL, '71', '6');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('72', '2024-03-12', '2024-03-14', NULL, NULL, '9', '23', NULL, '72', '6');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('73', '2024-03-15', '2024-03-17', NULL, NULL, '10', '24', NULL, '73', '6');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('74', '2024-03-16', '2024-03-18', NULL, NULL, '11', '36', NULL, '74', '6');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('75', '2024-03-18', '2024-03-21', NULL, NULL, '12', '20', NULL, '75', '6');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('76', '2024-03-19', '2024-03-22', NULL, NULL, '15', '25', NULL, '76', '6');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('77', '2024-03-24', '2024-03-25', NULL, NULL, '17', '32', NULL, '77', '6');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('78', '2024-04-01', '2024-04-03', NULL, NULL, '1', '3', NULL, '78', '6');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('79', '2024-04-03', '2024-04-05', NULL, NULL, '4', '2', NULL, '79', '6');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('80', '2024-04-05', '2024-04-08', NULL, NULL, '7', '35', NULL, '80', '6');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('81', '2024-04-07', '2024-04-09', NULL, NULL, '10', '7', NULL, '81', '3');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('82', '2024-04-07', '2024-04-10', NULL, NULL, '11', '19', NULL, '82', '6');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('83', '2024-04-10', '2024-04-12', NULL, NULL, '15', '1', NULL, '83', '3');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('84', '2024-04-12', '2024-04-15', NULL, NULL, '17', '23', NULL, '84', '6');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('85', '2024-04-14', '2024-04-16', NULL, NULL, '4', '2', NULL, '85', '6');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('86', '2024-04-19', '2024-04-23', NULL, NULL, '5', '19', NULL, '86', '6');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('87', '2024-04-26', '2024-04-30', NULL, NULL, '6', '23', NULL, '87', '6');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('88', '2024-05-03', '2024-05-06', NULL, NULL, '1', '1', NULL, '88', '6');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('89', '2024-05-06', '2024-05-09', NULL, NULL, '2', '19', NULL, '89', '6');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('90', '2024-05-07', '2024-05-10', NULL, NULL, '3', '18', NULL, '90', '3');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('91', '2024-05-09', '2024-05-11', NULL, NULL, '6', '23', NULL, '91', '6');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('92', '2024-05-11', '2024-05-15', NULL, NULL, '10', '36', NULL, '92', '6');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('93', '2024-05-14', '2024-05-17', NULL, NULL, '12', '2', NULL, '93', '3');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('94', '2024-05-22', '2024-05-25', NULL, NULL, '17', '3', NULL, '94', '6');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('95', '2024-05-24', '2024-05-26', NULL, NULL, '5', '7', NULL, '95', '6');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('96', '2024-05-26', '2024-05-29', NULL, NULL, '8', '18', NULL, '96', '3');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('97', '2024-06-01', '2024-06-03', NULL, NULL, '9', '2', NULL, '97', '3');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('98', '2024-06-03', '2024-06-04', NULL, NULL, '10', '3', NULL, '98', '3');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('99', '2024-06-04', '2024-06-07', NULL, NULL, '11', '7', NULL, '99', '6');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('100', '2024-06-05', '2024-06-09', NULL, NULL, '12', '36', NULL, '100', '6');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('101', '2024-06-07', '2024-06-10', NULL, NULL, '17', '19', NULL, '101', '6');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('102', '2024-06-09', '2024-06-12', NULL, NULL, '1', '36', NULL, '102', '3');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('103', '2024-06-12', '2024-06-15', NULL, NULL, '4', '32', NULL, '103', '3');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('104', '2024-06-15', '2024-06-18', NULL, NULL, '3', '20', NULL, '104', '6');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('105', '2024-06-20', '2024-06-22', NULL, NULL, '6', '3', NULL, '105', '6');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('106', '2024-06-22', '2024-06-25', NULL, NULL, '7', '32', NULL, '106', '6');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('107', '2024-06-25', '2024-06-27', NULL, NULL, '10', '21', NULL, '107', '6');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('108', '2024-07-03', '2024-07-06', NULL, NULL, '2', '35', NULL, '108', '6');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('109', '2024-07-05', '2024-07-08', NULL, NULL, '6', '7', NULL, '109', '6');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('110', '2024-07-09', '2024-07-12', NULL, NULL, '5', '2', NULL, '110', '6');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('111', '2024-07-10', '2024-07-13', NULL, NULL, '1', '6', NULL, '111', '6');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('112', '2024-07-13', '2024-07-16', NULL, NULL, '8', '35', NULL, '112', '6');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('113', '2024-07-13', '2024-07-18', NULL, NULL, '12', '30', NULL, '113', '6');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('114', '2024-07-15', '2024-07-18', NULL, NULL, '17', '1', NULL, '114', '3');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('115', '2024-07-16', '2024-07-20', NULL, NULL, '3', '3', NULL, '115', '6');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('116', '2024-08-03', '2024-08-06', NULL, NULL, '4', '2', NULL, '116', '6');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('117', '2024-08-07', '2024-08-09', NULL, NULL, '5', '6', NULL, '117', '6');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('118', '2024-08-10', '2024-08-12', NULL, NULL, '6', '25', NULL, '118', '6');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('119', '2024-08-13', '2024-08-16', NULL, NULL, '7', '18', NULL, '119', '3');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('120', '2024-08-23', '2024-08-25', NULL, NULL, '10', '36', NULL, '120', '6');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('121', '2024-08-29', '2024-08-31', NULL, NULL, '15', '23', NULL, '121', '6');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('122', '2024-09-05', '2024-09-09', NULL, NULL, '1', '1', NULL, '122', '6');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('123', '2024-10-07', '2024-10-10', NULL, NULL, '15', '19', NULL, '123', '2');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('124', '2024-10-09', '2024-10-14', NULL, NULL, '1', '25', NULL, '124', '6');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('125', '2024-10-16', '2024-10-19', NULL, NULL, '3', '18', NULL, '125', '6');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('126', '2024-11-02', '2024-11-07', NULL, NULL, '12', '2', NULL, '126', '6');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('127', '2024-11-07', '2024-11-10', NULL, NULL, '5', '23', NULL, '127', '4');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('128', '2024-11-12', '2024-11-14', NULL, '2024-11-14', '6', '24', NULL, '128', '6');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('129', '2024-11-13', '2024-11-15', NULL, NULL, '11', '24', NULL, '129', '6');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('130', '2025-01-02', '2025-01-04', NULL, NULL, '6', '23', NULL, '130', '5');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('131', '2025-01-02', '2025-01-09', NULL, NULL, '12', '19', NULL, '131', '6');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('132', '2025-01-02', '2025-01-02', NULL, NULL, '15', '25', NULL, '132', '4');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('134', '2025-05-23', '2025-05-28', NULL, NULL, '6', '19', NULL, '134', '2');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('135', '2025-05-22', '2025-05-29', NULL, NULL, '12', '6', NULL, '135', '1');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('136', '2025-05-24', '2025-05-28', NULL, NULL, '10', '45', NULL, '136', '3');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('137', '2025-05-23', '2025-05-29', NULL, NULL, '15', '45', NULL, '137', '6');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('138', '2025-03-20', '2025-03-27', NULL, NULL, '12', '35', NULL, '138', '1');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('139', '2025-03-13', '2025-03-18', '2025-03-14', '2025-03-17', '9', '44', NULL, '139', '6');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('140', '2025-12-03', '2025-12-11', NULL, NULL, '1', '2', NULL, '140', '1');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('141', '2025-12-01', '2025-12-10', NULL, NULL, '3', '2', NULL, '141', '1');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('142', '2025-12-12', '2025-12-22', NULL, NULL, '10', '45', NULL, '142', '1');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('143', '2025-12-11', '2025-12-21', NULL, NULL, '4', '2', NULL, '143', '1');
INSERT INTO `contratos-alquiler` (`idContrato`, `fechaInicioContrato`, `fechaFinContrato`, `fechaEntrega`, `fechaDevolucion`, `idCliente`, `idVehiculo`, `idVendedor`, `idDetalleContrato`, `idEstadoContrato`) VALUES ('144', '2025-12-11', '2025-12-21', NULL, NULL, '8', '7', NULL, '144', '1');

-- --------------------------------------------------------
-- Table structure for table `cuentas-clientes`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `cuentas-clientes`;
CREATE TABLE `cuentas-clientes` (
  `idCuentaCliente` int(11) NOT NULL AUTO_INCREMENT,
  `nombreUsuarioCliente` varchar(20) NOT NULL,
  `passwordCliente` varchar(50) NOT NULL,
  `idCliente` int(11) DEFAULT NULL,
  `idEstadoCuentaCliente` int(1) DEFAULT NULL,
  PRIMARY KEY (`idCuentaCliente`),
  KEY `cliente` (`idCliente`),
  KEY `estado cuenta` (`idEstadoCuentaCliente`),
  CONSTRAINT `cliente` FOREIGN KEY (`idCliente`) REFERENCES `clientes` (`idCliente`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `estado cuenta` FOREIGN KEY (`idEstadoCuentaCliente`) REFERENCES `estados-cuentacliente` (`idEstadoCuenta`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `cuentas-clientes`
--

INSERT INTO `cuentas-clientes` (`idCuentaCliente`, `nombreUsuarioCliente`, `passwordCliente`, `idCliente`, `idEstadoCuentaCliente`) VALUES ('1', 'brunancio', '123', '1', '2');
INSERT INTO `cuentas-clientes` (`idCuentaCliente`, `nombreUsuarioCliente`, `passwordCliente`, `idCliente`, `idEstadoCuentaCliente`) VALUES ('2', 'nicosio', '123', '12', '1');
INSERT INTO `cuentas-clientes` (`idCuentaCliente`, `nombreUsuarioCliente`, `passwordCliente`, `idCliente`, `idEstadoCuentaCliente`) VALUES ('3', 'facunyo', '123', '3', '1');
INSERT INTO `cuentas-clientes` (`idCuentaCliente`, `nombreUsuarioCliente`, `passwordCliente`, `idCliente`, `idEstadoCuentaCliente`) VALUES ('4', 'nosoyunbot', '123', '5', '2');

-- --------------------------------------------------------
-- Table structure for table `detalle-contratos`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `detalle-contratos`;
CREATE TABLE `detalle-contratos` (
  `idDetalleContrato` int(11) NOT NULL AUTO_INCREMENT,
  `precioPorDiaContrato` float NOT NULL,
  `cantidadDiasContrato` int(11) NOT NULL,
  `montoTotalContrato` float NOT NULL,
  `condicionesContrato` varchar(100) DEFAULT NULL COMMENT 'Aclaraciones opcionales sobre condiciones del contrato',
  `estadoContrato` varchar(100) DEFAULT NULL COMMENT 'Aclaraciones opcionales sobre el estado del contrato',
  `idEntregaVehiculo` int(11) DEFAULT NULL,
  `idDevVehiculo` int(11) DEFAULT NULL,
  PRIMARY KEY (`idDetalleContrato`),
  KEY `idEntregaVehiculo` (`idEntregaVehiculo`),
  KEY `idDevVehiculo` (`idDevVehiculo`),
  CONSTRAINT `detalle-contratos_ibfk_1` FOREIGN KEY (`idEntregaVehiculo`) REFERENCES `entregas-vehiculos` (`idEntrega`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `detalle-contratos_ibfk_2` FOREIGN KEY (`idDevVehiculo`) REFERENCES `devoluciones-vehiculos` (`idDevolucion`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=145 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `detalle-contratos`
--

INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('1', '50', '2', '100', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('2', '55.1', '7', '385.7', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('3', '150.5', '2', '301', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('4', '40.2', '3', '120.6', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('5', '33.6', '2', '67.2', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('7', '60', '116', '6960', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('8', '60.2', '2', '120.4', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('10', '53.5', '2', '107', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('11', '55', '2', '110', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('12', '50.5', '3', '151.5', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('13', '33.2', '3', '99.6', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('14', '90', '16', '1440', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('15', '50', '21', '1050', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('16', '100', '4', '400', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('17', '80', '2', '160', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('18', '90.6', '2', '181.2', NULL, NULL, NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('19', '55', '4', '220', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('20', '61', '5', '305', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('21', '73.2', '3', '219.6', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('22', '89', '8', '712', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('23', '48.61', '5', '243.05', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('24', '58.43', '5', '292.15', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('25', '72.49', '3', '217.47', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('26', '34.27', '6', '205.62', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('27', '88.9', '3', '266.7', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('28', '81.6', '5', '408', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('29', '99.1', '4', '396.4', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('30', '71.8', '8', '574.4', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('31', '75', '2', '150', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('32', '89.3', '3', '267.9', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('33', '89', '2', '178', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('34', '73', '4', '292', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('35', '46.8', '2', '93.6', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('36', '70', '1', '70', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('37', '79.3', '2', '158.6', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('38', '65.81', '1', '65.81', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('39', '69.81', '5', '349.05', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('40', '78.3', '2', '156.6', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('41', '98.1', '3', '294.3', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('42', '110.32', '4', '441.28', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('43', '87', '3', '261', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('44', '82.99', '3', '248.97', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('45', '87.39', '2', '174.78', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('46', '91.15', '3', '273.45', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('47', '86.87', '4', '347.48', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('48', '78.2', '9', '703.8', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('49', '98.2', '2', '196.4', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('50', '110.25', '3', '330.75', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('51', '105.4', '3', '316.2', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('52', '67', '2', '134', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('53', '68', '3', '204', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('54', '78', '2', '156', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('55', '71.11', '5', '355.55', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('56', '78.12', '4', '312.48', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('57', '88.7', '1', '88.7', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('58', '91.3', '3', '273.9', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('59', '67.88', '3', '203.64', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('60', '78.28', '5', '391.4', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('61', '76.9', '3', '230.7', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('62', '89.88', '4', '359.52', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('63', '91.9', '6', '551.4', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('64', '81.71', '1', '81.71', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('65', '86.8', '1', '86.8', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('66', '101.3', '5', '506.5', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('67', '201', '3', '603', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('68', '120.8', '3', '362.4', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('69', '110.9', '3', '332.7', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('70', '99.9', '2', '199.8', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('71', '110.99', '3', '332.97', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('72', '110.9', '2', '221.8', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('73', '105.99', '2', '211.98', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('74', '110', '2', '220', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('75', '115.88', '3', '347.64', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('76', '113.99', '3', '341.97', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('77', '120', '1', '120', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('78', '120.99', '2', '241.98', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('79', '110', '2', '220', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('80', '120', '3', '360', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('81', '130', '2', '260', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('82', '120', '3', '360', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('83', '125', '2', '250', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('84', '130', '3', '390', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('85', '100', '2', '200', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('86', '120', '4', '480', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('87', '120', '4', '480', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('88', '125', '3', '375', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('89', '113', '3', '339', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('90', '135', '3', '405', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('91', '117', '2', '234', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('92', '140', '4', '560', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('93', '130', '3', '390', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('94', '120', '3', '360', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('95', '135', '2', '270', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('96', '110', '3', '330', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('97', '135', '2', '270', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('98', '145', '1', '145', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('99', '150', '3', '450', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('100', '140', '4', '560', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('101', '130', '3', '390', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('102', '140', '3', '420', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('103', '135', '3', '405', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('104', '145', '3', '435', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('105', '135', '2', '270', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('106', '125', '3', '375', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('107', '155', '2', '310', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('108', '135', '3', '405', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('109', '145', '3', '435', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('110', '128', '3', '384', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('111', '145', '3', '435', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('112', '135', '3', '405', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('113', '145', '5', '725', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('114', '150', '3', '450', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('115', '130', '4', '520', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('116', '145', '3', '435', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('117', '165', '2', '330', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('118', '165', '2', '330', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('119', '165', '3', '495', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('120', '200', '2', '400', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('121', '180', '2', '360', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('122', '205', '4', '820', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('123', '120', '3', '360', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('124', '138.9', '5', '694.5', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('125', '135.7', '3', '407.1', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('126', '110', '5', '550', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('127', '125', '3', '375', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('128', '125', '2', '250', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('129', '135', '2', '270', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('130', '55', '2', '110', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('131', '45', '7', '315', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('132', '55', '0', '0', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('134', '101.12', '5', '505.6', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('135', '81.5', '7', '570.5', NULL, NULL, NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('136', '55.6', '4', '222.4', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('137', '71.7', '6', '430.2', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('138', '88.1', '7', '616.7', NULL, NULL, NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('139', '55.71', '5', '278.55', NULL, 'El estado ha sido modificado', NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('140', '45', '8', '360', NULL, NULL, NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('141', '40', '9', '360', NULL, NULL, NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('142', '45', '10', '450', NULL, NULL, NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('143', '45', '10', '450', NULL, NULL, NULL, NULL);
INSERT INTO `detalle-contratos` (`idDetalleContrato`, `precioPorDiaContrato`, `cantidadDiasContrato`, `montoTotalContrato`, `condicionesContrato`, `estadoContrato`, `idEntregaVehiculo`, `idDevVehiculo`) VALUES ('144', '60', '10', '600', NULL, 'El estado ha sido modificado', NULL, NULL);

-- --------------------------------------------------------
-- Table structure for table `detalle-pedidoaproveedor`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `detalle-pedidoaproveedor`;
CREATE TABLE `detalle-pedidoaproveedor` (
  `idDetallePedidoAProveedor` int(11) NOT NULL AUTO_INCREMENT,
  `idPedido` int(11) DEFAULT NULL COMMENT 'Llave foránea hacia el encabezado',
  `precioPorUnidad` float NOT NULL,
  `cantidadUnidades` int(11) NOT NULL,
  `subtotal` float NOT NULL,
  `idRepuestoVehiculo` int(11) DEFAULT NULL COMMENT 'Cada registro de "Pedido a Proveedor" involucra solo un repuesto, un producto, o un accesorio, nunca puede involucrar a los tres campos.',
  `idProductoVehiculo` int(11) DEFAULT NULL COMMENT 'Cada registro de "Pedido a Proveedor" involucra solo un repuesto, un producto, o un accesorio, nunca puede involucrar a los tres campos.',
  `idAccesorioVehiculo` int(11) DEFAULT NULL COMMENT 'Cada registro de "Pedido a Proveedor" involucra solo un repuesto, un producto, o un accesorio, nunca puede involucrar a los tres campos.',
  PRIMARY KEY (`idDetallePedidoAProveedor`),
  KEY `idRepuestoVehiculo` (`idRepuestoVehiculo`),
  KEY `idProductoVehiculo` (`idProductoVehiculo`),
  KEY `idAccesorioVehiculo` (`idAccesorioVehiculo`),
  KEY `idPedido` (`idPedido`),
  CONSTRAINT `detalle-pedidoaproveedor_ibfk_1` FOREIGN KEY (`idRepuestoVehiculo`) REFERENCES `repuestos-vehiculos` (`idRepuesto`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `detalle-pedidoaproveedor_ibfk_2` FOREIGN KEY (`idProductoVehiculo`) REFERENCES `productos-vehiculo` (`idProducto`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `detalle-pedidoaproveedor_ibfk_3` FOREIGN KEY (`idAccesorioVehiculo`) REFERENCES `accesorios-vehiculos` (`idAccesorio`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `detalle-pedidoaproveedor_ibfk_4` FOREIGN KEY (`idPedido`) REFERENCES `pedido-a-proveedor` (`idPedido`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `detalle-pedidoaproveedor`
--

INSERT INTO `detalle-pedidoaproveedor` (`idDetallePedidoAProveedor`, `idPedido`, `precioPorUnidad`, `cantidadUnidades`, `subtotal`, `idRepuestoVehiculo`, `idProductoVehiculo`, `idAccesorioVehiculo`) VALUES ('1', '1', '800', '3', '2400', '1', NULL, NULL);
INSERT INTO `detalle-pedidoaproveedor` (`idDetallePedidoAProveedor`, `idPedido`, `precioPorUnidad`, `cantidadUnidades`, `subtotal`, `idRepuestoVehiculo`, `idProductoVehiculo`, `idAccesorioVehiculo`) VALUES ('2', '2', '1300.74', '2', '2601.48', '2', NULL, NULL);
INSERT INTO `detalle-pedidoaproveedor` (`idDetallePedidoAProveedor`, `idPedido`, `precioPorUnidad`, `cantidadUnidades`, `subtotal`, `idRepuestoVehiculo`, `idProductoVehiculo`, `idAccesorioVehiculo`) VALUES ('3', '2', '170.1', '9', '1530.9', '3', NULL, NULL);
INSERT INTO `detalle-pedidoaproveedor` (`idDetallePedidoAProveedor`, `idPedido`, `precioPorUnidad`, `cantidadUnidades`, `subtotal`, `idRepuestoVehiculo`, `idProductoVehiculo`, `idAccesorioVehiculo`) VALUES ('4', '2', '870', '4', '3480', '4', NULL, NULL);
INSERT INTO `detalle-pedidoaproveedor` (`idDetallePedidoAProveedor`, `idPedido`, `precioPorUnidad`, `cantidadUnidades`, `subtotal`, `idRepuestoVehiculo`, `idProductoVehiculo`, `idAccesorioVehiculo`) VALUES ('5', '3', '23', '4', '92', '5', NULL, NULL);
INSERT INTO `detalle-pedidoaproveedor` (`idDetallePedidoAProveedor`, `idPedido`, `precioPorUnidad`, `cantidadUnidades`, `subtotal`, `idRepuestoVehiculo`, `idProductoVehiculo`, `idAccesorioVehiculo`) VALUES ('6', '3', '11', '1', '11', NULL, '1', NULL);
INSERT INTO `detalle-pedidoaproveedor` (`idDetallePedidoAProveedor`, `idPedido`, `precioPorUnidad`, `cantidadUnidades`, `subtotal`, `idRepuestoVehiculo`, `idProductoVehiculo`, `idAccesorioVehiculo`) VALUES ('7', '3', '17', '5', '85', NULL, NULL, '1');
INSERT INTO `detalle-pedidoaproveedor` (`idDetallePedidoAProveedor`, `idPedido`, `precioPorUnidad`, `cantidadUnidades`, `subtotal`, `idRepuestoVehiculo`, `idProductoVehiculo`, `idAccesorioVehiculo`) VALUES ('8', '4', '22.3', '3', '66.9', NULL, '2', NULL);
INSERT INTO `detalle-pedidoaproveedor` (`idDetallePedidoAProveedor`, `idPedido`, `precioPorUnidad`, `cantidadUnidades`, `subtotal`, `idRepuestoVehiculo`, `idProductoVehiculo`, `idAccesorioVehiculo`) VALUES ('9', '4', '32.2', '5', '161', NULL, NULL, '2');
INSERT INTO `detalle-pedidoaproveedor` (`idDetallePedidoAProveedor`, `idPedido`, `precioPorUnidad`, `cantidadUnidades`, `subtotal`, `idRepuestoVehiculo`, `idProductoVehiculo`, `idAccesorioVehiculo`) VALUES ('10', '4', '17.2', '6', '103.2', NULL, NULL, '3');
INSERT INTO `detalle-pedidoaproveedor` (`idDetallePedidoAProveedor`, `idPedido`, `precioPorUnidad`, `cantidadUnidades`, `subtotal`, `idRepuestoVehiculo`, `idProductoVehiculo`, `idAccesorioVehiculo`) VALUES ('11', '6', '25', '1', '25', NULL, '3', NULL);
INSERT INTO `detalle-pedidoaproveedor` (`idDetallePedidoAProveedor`, `idPedido`, `precioPorUnidad`, `cantidadUnidades`, `subtotal`, `idRepuestoVehiculo`, `idProductoVehiculo`, `idAccesorioVehiculo`) VALUES ('12', '6', '14.5', '10', '145', NULL, NULL, '4');
INSERT INTO `detalle-pedidoaproveedor` (`idDetallePedidoAProveedor`, `idPedido`, `precioPorUnidad`, `cantidadUnidades`, `subtotal`, `idRepuestoVehiculo`, `idProductoVehiculo`, `idAccesorioVehiculo`) VALUES ('13', '6', '18.3', '6', '109.8', '6', NULL, NULL);
INSERT INTO `detalle-pedidoaproveedor` (`idDetallePedidoAProveedor`, `idPedido`, `precioPorUnidad`, `cantidadUnidades`, `subtotal`, `idRepuestoVehiculo`, `idProductoVehiculo`, `idAccesorioVehiculo`) VALUES ('14', '7', '20', '3', '60', NULL, NULL, '5');
INSERT INTO `detalle-pedidoaproveedor` (`idDetallePedidoAProveedor`, `idPedido`, `precioPorUnidad`, `cantidadUnidades`, `subtotal`, `idRepuestoVehiculo`, `idProductoVehiculo`, `idAccesorioVehiculo`) VALUES ('15', '7', '15', '2', '30', NULL, NULL, '6');
INSERT INTO `detalle-pedidoaproveedor` (`idDetallePedidoAProveedor`, `idPedido`, `precioPorUnidad`, `cantidadUnidades`, `subtotal`, `idRepuestoVehiculo`, `idProductoVehiculo`, `idAccesorioVehiculo`) VALUES ('16', '8', '35', '2', '70', '7', NULL, NULL);
INSERT INTO `detalle-pedidoaproveedor` (`idDetallePedidoAProveedor`, `idPedido`, `precioPorUnidad`, `cantidadUnidades`, `subtotal`, `idRepuestoVehiculo`, `idProductoVehiculo`, `idAccesorioVehiculo`) VALUES ('17', '8', '44', '6', '264', '8', NULL, NULL);
INSERT INTO `detalle-pedidoaproveedor` (`idDetallePedidoAProveedor`, `idPedido`, `precioPorUnidad`, `cantidadUnidades`, `subtotal`, `idRepuestoVehiculo`, `idProductoVehiculo`, `idAccesorioVehiculo`) VALUES ('18', '8', '901', '3', '2703', '9', NULL, NULL);
INSERT INTO `detalle-pedidoaproveedor` (`idDetallePedidoAProveedor`, `idPedido`, `precioPorUnidad`, `cantidadUnidades`, `subtotal`, `idRepuestoVehiculo`, `idProductoVehiculo`, `idAccesorioVehiculo`) VALUES ('19', '8', '99.9', '10', '999', '10', NULL, NULL);
INSERT INTO `detalle-pedidoaproveedor` (`idDetallePedidoAProveedor`, `idPedido`, `precioPorUnidad`, `cantidadUnidades`, `subtotal`, `idRepuestoVehiculo`, `idProductoVehiculo`, `idAccesorioVehiculo`) VALUES ('20', '9', '45', '10', '450', '11', NULL, NULL);
INSERT INTO `detalle-pedidoaproveedor` (`idDetallePedidoAProveedor`, `idPedido`, `precioPorUnidad`, `cantidadUnidades`, `subtotal`, `idRepuestoVehiculo`, `idProductoVehiculo`, `idAccesorioVehiculo`) VALUES ('21', '9', '23.2', '4', '92.8', '12', NULL, NULL);
INSERT INTO `detalle-pedidoaproveedor` (`idDetallePedidoAProveedor`, `idPedido`, `precioPorUnidad`, `cantidadUnidades`, `subtotal`, `idRepuestoVehiculo`, `idProductoVehiculo`, `idAccesorioVehiculo`) VALUES ('22', '10', '125', '1', '125', NULL, NULL, '7');
INSERT INTO `detalle-pedidoaproveedor` (`idDetallePedidoAProveedor`, `idPedido`, `precioPorUnidad`, `cantidadUnidades`, `subtotal`, `idRepuestoVehiculo`, `idProductoVehiculo`, `idAccesorioVehiculo`) VALUES ('23', '10', '13.2', '10', '132', NULL, NULL, '8');

-- --------------------------------------------------------
-- Table structure for table `devoluciones-vehiculos`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `devoluciones-vehiculos`;
CREATE TABLE `devoluciones-vehiculos` (
  `idDevolucion` int(11) NOT NULL AUTO_INCREMENT,
  `fechaDevolucion` date NOT NULL,
  `horaDevolucion` varchar(8) DEFAULT NULL,
  `estadoDevolucion` varchar(200) DEFAULT NULL COMMENT 'Campo opcional señalando el estado del vehículo en caso de requerirse',
  `aclaracionesDevolucion` varchar(200) DEFAULT NULL COMMENT 'Campo opcional con aclaraciones sobre la devolución en caso de requerirse',
  `infraccionesDevolucion` varchar(200) DEFAULT NULL COMMENT 'Campo opcional señalando infracciones cometidas',
  `costosInfracciones` float DEFAULT NULL,
  `montoExtra` float DEFAULT NULL COMMENT 'Monto extra a cobrar por infracciones, en caso de requerirse',
  `idCliente` int(11) DEFAULT NULL,
  `idContrato` int(11) DEFAULT NULL,
  `idVerificacion` int(11) DEFAULT NULL COMMENT 'Rutina de verificación asociada a la devolución del vehículo',
  `idVendedorReceptor` int(11) DEFAULT NULL COMMENT 'Vendedor que recibe el vehículo al ser devuelto',
  `actualizacion` varchar(1) DEFAULT NULL COMMENT '"N" si el registro aún no ha sido actualizado, "S" si se actualizó por lo menos una vez. Sirve para deshabilitar campos de modificación (se permite solo una modificacion del registro)',
  PRIMARY KEY (`idDevolucion`),
  KEY `idCliente` (`idCliente`),
  KEY `idContrato` (`idContrato`),
  KEY `idVendedorReceptor` (`idVendedorReceptor`),
  KEY `idVerificacion` (`idVerificacion`),
  CONSTRAINT `devoluciones-vehiculos_ibfk_1` FOREIGN KEY (`idCliente`) REFERENCES `clientes` (`idCliente`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `devoluciones-vehiculos_ibfk_2` FOREIGN KEY (`idContrato`) REFERENCES `contratos-alquiler` (`idContrato`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `devoluciones-vehiculos_ibfk_3` FOREIGN KEY (`idVendedorReceptor`) REFERENCES `vendedores` (`idVendedor`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `devoluciones-vehiculos_ibfk_4` FOREIGN KEY (`idVerificacion`) REFERENCES `verificaciones-vehiculos` (`idVerificacion`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `devoluciones-vehiculos`
--

INSERT INTO `devoluciones-vehiculos` (`idDevolucion`, `fechaDevolucion`, `horaDevolucion`, `estadoDevolucion`, `aclaracionesDevolucion`, `infraccionesDevolucion`, `costosInfracciones`, `montoExtra`, `idCliente`, `idContrato`, `idVerificacion`, `idVendedorReceptor`, `actualizacion`) VALUES ('2', '2025-04-11', '04:09', 'Capot dañado', 'Choque en autopista RNA001 ', 'Velocidad', '1000', '4000', '6', '14', NULL, NULL, 'N');
INSERT INTO `devoluciones-vehiculos` (`idDevolucion`, `fechaDevolucion`, `horaDevolucion`, `estadoDevolucion`, `aclaracionesDevolucion`, `infraccionesDevolucion`, `costosInfracciones`, `montoExtra`, `idCliente`, `idContrato`, `idVerificacion`, `idVendedorReceptor`, `actualizacion`) VALUES ('3', '2025-04-25', '04:09', 'Ruptura limpiaparabrisas', 'Cliente reporta problemas con el limpiaparabrisas', 'Ninguna', '0', '20', '8', '13', NULL, NULL, 'N');
INSERT INTO `devoluciones-vehiculos` (`idDevolucion`, `fechaDevolucion`, `horaDevolucion`, `estadoDevolucion`, `aclaracionesDevolucion`, `infraccionesDevolucion`, `costosInfracciones`, `montoExtra`, `idCliente`, `idContrato`, `idVerificacion`, `idVendedorReceptor`, `actualizacion`) VALUES ('4', '2024-12-21', '07:00', 'Requiere limpieza profunda', 'Accidente con aderesos y otros alimentos en el asiento trasero', 'Ninguna', '0', '45', '17', '8', NULL, NULL, 'N');
INSERT INTO `devoluciones-vehiculos` (`idDevolucion`, `fechaDevolucion`, `horaDevolucion`, `estadoDevolucion`, `aclaracionesDevolucion`, `infraccionesDevolucion`, `costosInfracciones`, `montoExtra`, `idCliente`, `idContrato`, `idVerificacion`, `idVendedorReceptor`, `actualizacion`) VALUES ('5', '2025-04-04', '07:00', 'Sin cambios', 'Sin aclaraciones', 'Ninguna', '0', '0', '11', '7', NULL, NULL, 'N');
INSERT INTO `devoluciones-vehiculos` (`idDevolucion`, `fechaDevolucion`, `horaDevolucion`, `estadoDevolucion`, `aclaracionesDevolucion`, `infraccionesDevolucion`, `costosInfracciones`, `montoExtra`, `idCliente`, `idContrato`, `idVerificacion`, `idVendedorReceptor`, `actualizacion`) VALUES ('6', '2025-01-04', '21:20', 'Sin cambios', 'Cliente reporta problemas de inflado de neumáticos', 'Ninguna', '0', '0', '6', '130', NULL, NULL, 'N');
INSERT INTO `devoluciones-vehiculos` (`idDevolucion`, `fechaDevolucion`, `horaDevolucion`, `estadoDevolucion`, `aclaracionesDevolucion`, `infraccionesDevolucion`, `costosInfracciones`, `montoExtra`, `idCliente`, `idContrato`, `idVerificacion`, `idVendedorReceptor`, `actualizacion`) VALUES ('7', '2025-01-09', '07:00', 'Sin cambios', 'Sin aclaraciones', 'Ninguna', '0', '0', '12', '131', NULL, NULL, 'N');
INSERT INTO `devoluciones-vehiculos` (`idDevolucion`, `fechaDevolucion`, `horaDevolucion`, `estadoDevolucion`, `aclaracionesDevolucion`, `infraccionesDevolucion`, `costosInfracciones`, `montoExtra`, `idCliente`, `idContrato`, `idVerificacion`, `idVendedorReceptor`, `actualizacion`) VALUES ('8', '2025-02-08', '16:30', 'Sin cambios', 'Sin aclaraciones', 'Ninguna', '0', '0', '3', '18', NULL, NULL, 'N');
INSERT INTO `devoluciones-vehiculos` (`idDevolucion`, `fechaDevolucion`, `horaDevolucion`, `estadoDevolucion`, `aclaracionesDevolucion`, `infraccionesDevolucion`, `costosInfracciones`, `montoExtra`, `idCliente`, `idContrato`, `idVerificacion`, `idVendedorReceptor`, `actualizacion`) VALUES ('9', '2024-12-18', '20:00', 'Sin cambios', 'Sin aclaraciones', 'Ninguna', '0', '100', '7', '10', NULL, NULL, 'S');
INSERT INTO `devoluciones-vehiculos` (`idDevolucion`, `fechaDevolucion`, `horaDevolucion`, `estadoDevolucion`, `aclaracionesDevolucion`, `infraccionesDevolucion`, `costosInfracciones`, `montoExtra`, `idCliente`, `idContrato`, `idVerificacion`, `idVendedorReceptor`, `actualizacion`) VALUES ('10', '2025-02-05', '20:00', 'Sin cambios', 'Sin aclaraciones', 'Ninguna', '0', '0', '12', '131', NULL, NULL, 'N');
INSERT INTO `devoluciones-vehiculos` (`idDevolucion`, `fechaDevolucion`, `horaDevolucion`, `estadoDevolucion`, `aclaracionesDevolucion`, `infraccionesDevolucion`, `costosInfracciones`, `montoExtra`, `idCliente`, `idContrato`, `idVerificacion`, `idVendedorReceptor`, `actualizacion`) VALUES ('11', '2025-06-03', '00:34', 'Sin cambios', 'Sin aclaraciones', 'Ninguna', '0', '0', '15', '137', NULL, NULL, 'N');
INSERT INTO `devoluciones-vehiculos` (`idDevolucion`, `fechaDevolucion`, `horaDevolucion`, `estadoDevolucion`, `aclaracionesDevolucion`, `infraccionesDevolucion`, `costosInfracciones`, `montoExtra`, `idCliente`, `idContrato`, `idVerificacion`, `idVendedorReceptor`, `actualizacion`) VALUES ('12', '2025-06-23', '16:53', 'Sin cambios', 'Sin aclaraciones', 'Ninguna', '0', '0', '7', '5', NULL, NULL, 'N');
INSERT INTO `devoluciones-vehiculos` (`idDevolucion`, `fechaDevolucion`, `horaDevolucion`, `estadoDevolucion`, `aclaracionesDevolucion`, `infraccionesDevolucion`, `costosInfracciones`, `montoExtra`, `idCliente`, `idContrato`, `idVerificacion`, `idVendedorReceptor`, `actualizacion`) VALUES ('13', '2024-08-30', '21:52', 'Sin cambios', 'Sin aclaraciones necesarias', 'Cubiertas por el usuario', '0', '0', '15', '121', NULL, NULL, 'S');
INSERT INTO `devoluciones-vehiculos` (`idDevolucion`, `fechaDevolucion`, `horaDevolucion`, `estadoDevolucion`, `aclaracionesDevolucion`, `infraccionesDevolucion`, `costosInfracciones`, `montoExtra`, `idCliente`, `idContrato`, `idVerificacion`, `idVendedorReceptor`, `actualizacion`) VALUES ('14', '2025-03-17', '11:11', 'Sin cambios', 'Sin aclaraciones', 'Ninguna', '0', '0', '9', '139', NULL, NULL, 'N');
INSERT INTO `devoluciones-vehiculos` (`idDevolucion`, `fechaDevolucion`, `horaDevolucion`, `estadoDevolucion`, `aclaracionesDevolucion`, `infraccionesDevolucion`, `costosInfracciones`, `montoExtra`, `idCliente`, `idContrato`, `idVerificacion`, `idVendedorReceptor`, `actualizacion`) VALUES ('15', '2025-01-05', '10:24', 'Sin cambios', 'Sin aclaraciones', 'Ninguna', '0', '100', '1', '17', NULL, NULL, 'S');
INSERT INTO `devoluciones-vehiculos` (`idDevolucion`, `fechaDevolucion`, `horaDevolucion`, `estadoDevolucion`, `aclaracionesDevolucion`, `infraccionesDevolucion`, `costosInfracciones`, `montoExtra`, `idCliente`, `idContrato`, `idVerificacion`, `idVendedorReceptor`, `actualizacion`) VALUES ('16', '2024-11-14', '14:00', 'Sin cambios', 'Sin aclaraciones', 'Ninguna', '0', '0', '6', '128', NULL, NULL, 'N');

-- --------------------------------------------------------
-- Table structure for table `empleados`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `empleados`;
CREATE TABLE `empleados` (
  `idEmpleado` int(11) NOT NULL AUTO_INCREMENT,
  `nombreEmpleado` varchar(50) NOT NULL,
  `apellidoEmpleado` varchar(50) NOT NULL,
  `dniEmpleado` int(10) NOT NULL,
  `mailEmpleado` varchar(100) NOT NULL,
  `telefonoEmpleado` int(10) NOT NULL,
  `direccionEmpleado` varchar(100) NOT NULL,
  `cargoEmpleado` varchar(100) NOT NULL,
  `salarioEmpleado` float NOT NULL,
  `fechaIngresoEmpleado` date NOT NULL,
  `idSucursal` int(11) DEFAULT NULL,
  PRIMARY KEY (`idEmpleado`),
  KEY `idSucursal` (`idSucursal`),
  CONSTRAINT `empleados_ibfk_1` FOREIGN KEY (`idSucursal`) REFERENCES `sucursales` (`idSucursal`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------
-- Table structure for table `entregas-vehiculos`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `entregas-vehiculos`;
CREATE TABLE `entregas-vehiculos` (
  `idEntrega` int(11) NOT NULL AUTO_INCREMENT,
  `fechaEntrega` date NOT NULL,
  `horaEntrega` varchar(8) NOT NULL,
  `idCliente` int(11) DEFAULT NULL,
  `idContrato` int(11) DEFAULT NULL,
  PRIMARY KEY (`idEntrega`),
  KEY `idCliente` (`idCliente`),
  KEY `idContrato` (`idContrato`),
  CONSTRAINT `entregas-vehiculos_ibfk_1` FOREIGN KEY (`idCliente`) REFERENCES `clientes` (`idCliente`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `entregas-vehiculos_ibfk_2` FOREIGN KEY (`idContrato`) REFERENCES `contratos-alquiler` (`idContrato`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `entregas-vehiculos`
--

INSERT INTO `entregas-vehiculos` (`idEntrega`, `fechaEntrega`, `horaEntrega`, `idCliente`, `idContrato`) VALUES ('1', '2024-01-01', '07:00', '6', '19');
INSERT INTO `entregas-vehiculos` (`idEntrega`, `fechaEntrega`, `horaEntrega`, `idCliente`, `idContrato`) VALUES ('2', '2025-01-02', '07:35', '6', '130');
INSERT INTO `entregas-vehiculos` (`idEntrega`, `fechaEntrega`, `horaEntrega`, `idCliente`, `idContrato`) VALUES ('3', '2025-01-02', '13:15', '3', '18');
INSERT INTO `entregas-vehiculos` (`idEntrega`, `fechaEntrega`, `horaEntrega`, `idCliente`, `idContrato`) VALUES ('4', '2024-12-11', '15:00', '17', '8');
INSERT INTO `entregas-vehiculos` (`idEntrega`, `fechaEntrega`, `horaEntrega`, `idCliente`, `idContrato`) VALUES ('5', '2025-04-16', '02:10', '7', '12');
INSERT INTO `entregas-vehiculos` (`idEntrega`, `fechaEntrega`, `horaEntrega`, `idCliente`, `idContrato`) VALUES ('6', '2025-04-16', '19:12', '12', '15');
INSERT INTO `entregas-vehiculos` (`idEntrega`, `fechaEntrega`, `horaEntrega`, `idCliente`, `idContrato`) VALUES ('7', '2024-12-14', '21:30', '7', '10');
INSERT INTO `entregas-vehiculos` (`idEntrega`, `fechaEntrega`, `horaEntrega`, `idCliente`, `idContrato`) VALUES ('8', '2024-12-15', '07:15', '8', '11');
INSERT INTO `entregas-vehiculos` (`idEntrega`, `fechaEntrega`, `horaEntrega`, `idCliente`, `idContrato`) VALUES ('9', '2024-01-18', '08:20', '10', '28');
INSERT INTO `entregas-vehiculos` (`idEntrega`, `fechaEntrega`, `horaEntrega`, `idCliente`, `idContrato`) VALUES ('10', '2025-01-01', '17:00', '1', '17');
INSERT INTO `entregas-vehiculos` (`idEntrega`, `fechaEntrega`, `horaEntrega`, `idCliente`, `idContrato`) VALUES ('11', '2025-01-02', '06:00', '12', '131');
INSERT INTO `entregas-vehiculos` (`idEntrega`, `fechaEntrega`, `horaEntrega`, `idCliente`, `idContrato`) VALUES ('12', '2025-01-02', '07:00', '15', '132');
INSERT INTO `entregas-vehiculos` (`idEntrega`, `fechaEntrega`, `horaEntrega`, `idCliente`, `idContrato`) VALUES ('13', '2024-12-09', '05:00', '11', '7');
INSERT INTO `entregas-vehiculos` (`idEntrega`, `fechaEntrega`, `horaEntrega`, `idCliente`, `idContrato`) VALUES ('14', '2024-11-12', '23:14', '6', '128');
INSERT INTO `entregas-vehiculos` (`idEntrega`, `fechaEntrega`, `horaEntrega`, `idCliente`, `idContrato`) VALUES ('15', '2025-02-02', '06:00', '12', '131');
INSERT INTO `entregas-vehiculos` (`idEntrega`, `fechaEntrega`, `horaEntrega`, `idCliente`, `idContrato`) VALUES ('16', '2025-04-04', '19:00', '12', '131');
INSERT INTO `entregas-vehiculos` (`idEntrega`, `fechaEntrega`, `horaEntrega`, `idCliente`, `idContrato`) VALUES ('17', '2025-05-23', '15:11', '15', '137');
INSERT INTO `entregas-vehiculos` (`idEntrega`, `fechaEntrega`, `horaEntrega`, `idCliente`, `idContrato`) VALUES ('18', '2025-04-10', '04:29', '5', '127');
INSERT INTO `entregas-vehiculos` (`idEntrega`, `fechaEntrega`, `horaEntrega`, `idCliente`, `idContrato`) VALUES ('19', '2024-08-30', '19:00', '15', '121');
INSERT INTO `entregas-vehiculos` (`idEntrega`, `fechaEntrega`, `horaEntrega`, `idCliente`, `idContrato`) VALUES ('20', '2025-03-14', '09:08', '9', '139');

-- --------------------------------------------------------
-- Table structure for table `estados-contratos`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `estados-contratos`;
CREATE TABLE `estados-contratos` (
  `idEstadoContrato` int(11) NOT NULL AUTO_INCREMENT,
  `estadoContrato` varchar(50) NOT NULL,
  `descripcionEstadoContrato` varchar(200) DEFAULT NULL COMMENT 'Descripción opcional del estado',
  PRIMARY KEY (`idEstadoContrato`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `estados-contratos`
--

INSERT INTO `estados-contratos` (`idEstadoContrato`, `estadoContrato`, `descripcionEstadoContrato`) VALUES ('1', 'En Preparación', NULL);
INSERT INTO `estados-contratos` (`idEstadoContrato`, `estadoContrato`, `descripcionEstadoContrato`) VALUES ('2', 'Firmado', NULL);
INSERT INTO `estados-contratos` (`idEstadoContrato`, `estadoContrato`, `descripcionEstadoContrato`) VALUES ('3', 'Cancelado', NULL);
INSERT INTO `estados-contratos` (`idEstadoContrato`, `estadoContrato`, `descripcionEstadoContrato`) VALUES ('4', 'Activo', NULL);
INSERT INTO `estados-contratos` (`idEstadoContrato`, `estadoContrato`, `descripcionEstadoContrato`) VALUES ('5', 'Renovado', NULL);
INSERT INTO `estados-contratos` (`idEstadoContrato`, `estadoContrato`, `descripcionEstadoContrato`) VALUES ('6', 'Finalizado', NULL);

-- --------------------------------------------------------
-- Table structure for table `estados-cuentacliente`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `estados-cuentacliente`;
CREATE TABLE `estados-cuentacliente` (
  `idEstadoCuenta` int(11) NOT NULL AUTO_INCREMENT,
  `Denominacion` varchar(20) NOT NULL,
  PRIMARY KEY (`idEstadoCuenta`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `estados-cuentacliente`
--

INSERT INTO `estados-cuentacliente` (`idEstadoCuenta`, `Denominacion`) VALUES ('1', 'Activo');
INSERT INTO `estados-cuentacliente` (`idEstadoCuenta`, `Denominacion`) VALUES ('2', 'Inactivo');

-- --------------------------------------------------------
-- Table structure for table `estados-pedidoaproveedor`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `estados-pedidoaproveedor`;
CREATE TABLE `estados-pedidoaproveedor` (
  `idEstadoPedido` int(11) NOT NULL AUTO_INCREMENT,
  `estadoPedido` varchar(50) NOT NULL,
  `descripcionEstadoPedido` varchar(200) DEFAULT NULL COMMENT 'Descripción optativa del estado.',
  PRIMARY KEY (`idEstadoPedido`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `estados-pedidoaproveedor`
--

INSERT INTO `estados-pedidoaproveedor` (`idEstadoPedido`, `estadoPedido`, `descripcionEstadoPedido`) VALUES ('1', 'Pendiente', NULL);
INSERT INTO `estados-pedidoaproveedor` (`idEstadoPedido`, `estadoPedido`, `descripcionEstadoPedido`) VALUES ('2', 'Confirmado', NULL);
INSERT INTO `estados-pedidoaproveedor` (`idEstadoPedido`, `estadoPedido`, `descripcionEstadoPedido`) VALUES ('3', 'Cancelado', NULL);
INSERT INTO `estados-pedidoaproveedor` (`idEstadoPedido`, `estadoPedido`, `descripcionEstadoPedido`) VALUES ('4', 'En Preparación', NULL);
INSERT INTO `estados-pedidoaproveedor` (`idEstadoPedido`, `estadoPedido`, `descripcionEstadoPedido`) VALUES ('5', 'Enviado', NULL);
INSERT INTO `estados-pedidoaproveedor` (`idEstadoPedido`, `estadoPedido`, `descripcionEstadoPedido`) VALUES ('6', 'Entregado', NULL);
INSERT INTO `estados-pedidoaproveedor` (`idEstadoPedido`, `estadoPedido`, `descripcionEstadoPedido`) VALUES ('7', 'Devuelto', NULL);

-- --------------------------------------------------------
-- Table structure for table `feedbacks-clientes`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `feedbacks-clientes`;
CREATE TABLE `feedbacks-clientes` (
  `idFeedbackCliente` int(11) NOT NULL AUTO_INCREMENT,
  `descripcionFeedback` varchar(200) NOT NULL,
  `puntuacionFeedback` int(1) NOT NULL,
  `idVehiculo` int(11) DEFAULT NULL,
  `idCuentaCliente` int(11) DEFAULT NULL,
  PRIMARY KEY (`idFeedbackCliente`),
  KEY `idVehiculo` (`idVehiculo`),
  KEY `idCuentaCliente` (`idCuentaCliente`),
  CONSTRAINT `feedbacks-clientes_ibfk_1` FOREIGN KEY (`idVehiculo`) REFERENCES `vehiculos` (`idVehiculo`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `feedbacks-clientes_ibfk_2` FOREIGN KEY (`idCuentaCliente`) REFERENCES `cuentas-clientes` (`idCuentaCliente`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `feedbacks-clientes`
--

INSERT INTO `feedbacks-clientes` (`idFeedbackCliente`, `descripcionFeedback`, `puntuacionFeedback`, `idVehiculo`, `idCuentaCliente`) VALUES ('1', 'Gran experiencia. Los frenos están un poco quemados', '4', '1', '1');
INSERT INTO `feedbacks-clientes` (`idFeedbackCliente`, `descripcionFeedback`, `puntuacionFeedback`, `idVehiculo`, `idCuentaCliente`) VALUES ('2', 'La verdad que podría mejorar', '2', '3', '3');

-- --------------------------------------------------------
-- Table structure for table `grupos-vehiculos`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `grupos-vehiculos`;
CREATE TABLE `grupos-vehiculos` (
  `idGrupo` int(11) NOT NULL AUTO_INCREMENT,
  `nombreGrupo` varchar(40) NOT NULL,
  `descripcionGrupo` varchar(100) DEFAULT NULL,
  `precioGrupo` float NOT NULL,
  PRIMARY KEY (`idGrupo`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `grupos-vehiculos`
--

INSERT INTO `grupos-vehiculos` (`idGrupo`, `nombreGrupo`, `descripcionGrupo`, `precioGrupo`) VALUES ('1', 'Automóvil deportivo', NULL, '50');
INSERT INTO `grupos-vehiculos` (`idGrupo`, `nombreGrupo`, `descripcionGrupo`, `precioGrupo`) VALUES ('2', 'Compacto deportivo', NULL, '40');
INSERT INTO `grupos-vehiculos` (`idGrupo`, `nombreGrupo`, `descripcionGrupo`, `precioGrupo`) VALUES ('3', 'Sedán deportivo', NULL, '30');
INSERT INTO `grupos-vehiculos` (`idGrupo`, `nombreGrupo`, `descripcionGrupo`, `precioGrupo`) VALUES ('4', 'Sedán', NULL, '25');
INSERT INTO `grupos-vehiculos` (`idGrupo`, `nombreGrupo`, `descripcionGrupo`, `precioGrupo`) VALUES ('5', 'Deportivo', NULL, '45');
INSERT INTO `grupos-vehiculos` (`idGrupo`, `nombreGrupo`, `descripcionGrupo`, `precioGrupo`) VALUES ('6', 'Superdeportivo ', NULL, '70');
INSERT INTO `grupos-vehiculos` (`idGrupo`, `nombreGrupo`, `descripcionGrupo`, `precioGrupo`) VALUES ('7', 'Gran turismo', NULL, '55');
INSERT INTO `grupos-vehiculos` (`idGrupo`, `nombreGrupo`, `descripcionGrupo`, `precioGrupo`) VALUES ('8', 'Descapotable', NULL, '35');
INSERT INTO `grupos-vehiculos` (`idGrupo`, `nombreGrupo`, `descripcionGrupo`, `precioGrupo`) VALUES ('9', 'Bólido muscle americano', NULL, '35');
INSERT INTO `grupos-vehiculos` (`idGrupo`, `nombreGrupo`, `descripcionGrupo`, `precioGrupo`) VALUES ('10', 'Pony', NULL, '25');
INSERT INTO `grupos-vehiculos` (`idGrupo`, `nombreGrupo`, `descripcionGrupo`, `precioGrupo`) VALUES ('11', 'Coupe', NULL, '30');
INSERT INTO `grupos-vehiculos` (`idGrupo`, `nombreGrupo`, `descripcionGrupo`, `precioGrupo`) VALUES ('12', 'Camioneta pickup ', NULL, '45');
INSERT INTO `grupos-vehiculos` (`idGrupo`, `nombreGrupo`, `descripcionGrupo`, `precioGrupo`) VALUES ('13', 'Sedán de lujo', NULL, '35');

-- --------------------------------------------------------
-- Table structure for table `intereses-clientes`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `intereses-clientes`;
CREATE TABLE `intereses-clientes` (
  `idInteresCliente` int(11) NOT NULL AUTO_INCREMENT,
  `motivoDeInteres` varchar(100) NOT NULL,
  `idVehiculo` int(11) DEFAULT NULL,
  `idCuentaCliente` int(11) DEFAULT NULL,
  PRIMARY KEY (`idInteresCliente`),
  KEY `vehiculo` (`idVehiculo`),
  KEY `cuenta del cliente` (`idCuentaCliente`),
  CONSTRAINT `cuenta del cliente` FOREIGN KEY (`idCuentaCliente`) REFERENCES `cuentas-clientes` (`idCuentaCliente`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `vehiculo` FOREIGN KEY (`idVehiculo`) REFERENCES `vehiculos` (`idVehiculo`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `intereses-clientes`
--

INSERT INTO `intereses-clientes` (`idInteresCliente`, `motivoDeInteres`, `idVehiculo`, `idCuentaCliente`) VALUES ('1', 'lindo auto para alquilar cuando tenga $!', '1', '4');
INSERT INTO `intereses-clientes` (`idInteresCliente`, `motivoDeInteres`, `idVehiculo`, `idCuentaCliente`) VALUES ('2', 'Alcanza 230kmh en ruta!', '3', '2');

-- --------------------------------------------------------
-- Table structure for table `mantenimientos-vehiculos`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `mantenimientos-vehiculos`;
CREATE TABLE `mantenimientos-vehiculos` (
  `idMantenimiento` int(11) NOT NULL AUTO_INCREMENT,
  `nombreMantenimiento` varchar(50) NOT NULL,
  `descripcionMantenimiento` varchar(200) DEFAULT NULL COMMENT 'Descripción opcional del tipo de mantenimiento realizado',
  `fechaInicioMantenimiento` date NOT NULL,
  `fechaFinMantenimiento` date NOT NULL,
  `costoMantenimiento` float DEFAULT NULL COMMENT 'Optativo. En caso de que sea necesario registrar costos adicionales.',
  `idVehiculo` int(11) DEFAULT NULL,
  `idRepuestoUsado` int(11) DEFAULT NULL COMMENT 'En caso de que se haya utilizado un repuesto en las labores de mantenimiento. Cada registro de mantenimiento puede involucrar cero (0) a un (1) repuestos.',
  `idProductoUsado` int(11) DEFAULT NULL COMMENT 'En caso de que se haya agotado un producto en las labores de mantenimiento. Cada registro de mantenimiento puede involucrar cero (0) a un (1) producto.',
  PRIMARY KEY (`idMantenimiento`),
  KEY `idVehiculo` (`idVehiculo`),
  KEY `idRepuestoUsado` (`idRepuestoUsado`),
  KEY `idProductoUsado` (`idProductoUsado`),
  CONSTRAINT `mantenimientos-vehiculos_ibfk_1` FOREIGN KEY (`idVehiculo`) REFERENCES `vehiculos` (`idVehiculo`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `mantenimientos-vehiculos_ibfk_2` FOREIGN KEY (`idRepuestoUsado`) REFERENCES `repuestos-vehiculos` (`idRepuesto`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `mantenimientos-vehiculos_ibfk_3` FOREIGN KEY (`idProductoUsado`) REFERENCES `productos-vehiculo` (`idProducto`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------
-- Table structure for table `modelos`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `modelos`;
CREATE TABLE `modelos` (
  `idModelo` int(11) NOT NULL AUTO_INCREMENT,
  `nombreModelo` varchar(20) NOT NULL,
  `descripcionModelo` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`idModelo`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `modelos`
--

INSERT INTO `modelos` (`idModelo`, `nombreModelo`, `descripcionModelo`) VALUES ('1', 'Toyota Hilux', NULL);
INSERT INTO `modelos` (`idModelo`, `nombreModelo`, `descripcionModelo`) VALUES ('2', 'Ford Ranger', NULL);
INSERT INTO `modelos` (`idModelo`, `nombreModelo`, `descripcionModelo`) VALUES ('3', 'Mercedes Clase S', NULL);
INSERT INTO `modelos` (`idModelo`, `nombreModelo`, `descripcionModelo`) VALUES ('4', 'Porsche Taycan', NULL);
INSERT INTO `modelos` (`idModelo`, `nombreModelo`, `descripcionModelo`) VALUES ('5', 'Mercedes EQS', NULL);
INSERT INTO `modelos` (`idModelo`, `nombreModelo`, `descripcionModelo`) VALUES ('6', 'Rolls-Royce Phantom', NULL);
INSERT INTO `modelos` (`idModelo`, `nombreModelo`, `descripcionModelo`) VALUES ('7', 'Rolls-Royce Ghost', NULL);
INSERT INTO `modelos` (`idModelo`, `nombreModelo`, `descripcionModelo`) VALUES ('8', 'Porsche Cayenne', NULL);
INSERT INTO `modelos` (`idModelo`, `nombreModelo`, `descripcionModelo`) VALUES ('9', 'Range Rover', NULL);
INSERT INTO `modelos` (`idModelo`, `nombreModelo`, `descripcionModelo`) VALUES ('10', 'Audi RS7 Sportback', NULL);

-- --------------------------------------------------------
-- Table structure for table `pedido-a-proveedor`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `pedido-a-proveedor`;
CREATE TABLE `pedido-a-proveedor` (
  `idPedido` int(11) NOT NULL AUTO_INCREMENT,
  `fechaPedido` date NOT NULL,
  `fechaEntregaPedido` date DEFAULT NULL,
  `idProveedor` int(11) DEFAULT NULL,
  `idEstadoPedido` int(11) DEFAULT NULL,
  `aclaracionesEstadoPedido` varchar(200) DEFAULT NULL COMMENT 'Campo opcional que permite incorporar información adicional sobre el estado del pedido, en caso de ser necesario.',
  `condicionesDeEntrega` varchar(200) DEFAULT NULL COMMENT 'Campo opcional que permite registrar condiciones pactadas de entrega.',
  `totalPedido` float DEFAULT NULL,
  PRIMARY KEY (`idPedido`),
  KEY `idProveedor` (`idProveedor`),
  KEY `idEstadoPedido` (`idEstadoPedido`),
  CONSTRAINT `pedido-a-proveedor_ibfk_2` FOREIGN KEY (`idProveedor`) REFERENCES `proveedores` (`idProveedor`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `pedido-a-proveedor_ibfk_3` FOREIGN KEY (`idEstadoPedido`) REFERENCES `estados-pedidoaproveedor` (`idEstadoPedido`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `pedido-a-proveedor`
--

INSERT INTO `pedido-a-proveedor` (`idPedido`, `fechaPedido`, `fechaEntregaPedido`, `idProveedor`, `idEstadoPedido`, `aclaracionesEstadoPedido`, `condicionesDeEntrega`, `totalPedido`) VALUES ('1', '2024-11-01', '2024-11-05', '4', '1', 'Ninguna', '5 de noviembre a las 8 AM en puerta, previo aviso telefónico', '2400');
INSERT INTO `pedido-a-proveedor` (`idPedido`, `fechaPedido`, `fechaEntregaPedido`, `idProveedor`, `idEstadoPedido`, `aclaracionesEstadoPedido`, `condicionesDeEntrega`, `totalPedido`) VALUES ('2', '2024-11-01', '2024-11-11', '4', '1', '', '', '7612.38');
INSERT INTO `pedido-a-proveedor` (`idPedido`, `fechaPedido`, `fechaEntregaPedido`, `idProveedor`, `idEstadoPedido`, `aclaracionesEstadoPedido`, `condicionesDeEntrega`, `totalPedido`) VALUES ('3', '2024-11-03', '2024-11-08', '11', '1', '', '', '188');
INSERT INTO `pedido-a-proveedor` (`idPedido`, `fechaPedido`, `fechaEntregaPedido`, `idProveedor`, `idEstadoPedido`, `aclaracionesEstadoPedido`, `condicionesDeEntrega`, `totalPedido`) VALUES ('4', '2024-11-12', '2024-11-26', '9', '6', 'Pedido se retrasó 2 días previo aviso', '', '331.1');
INSERT INTO `pedido-a-proveedor` (`idPedido`, `fechaPedido`, `fechaEntregaPedido`, `idProveedor`, `idEstadoPedido`, `aclaracionesEstadoPedido`, `condicionesDeEntrega`, `totalPedido`) VALUES ('6', '2024-12-03', '2024-12-06', '1', '1', 'Ninguna', 'Llega con antelación previo aviso', '279.8');
INSERT INTO `pedido-a-proveedor` (`idPedido`, `fechaPedido`, `fechaEntregaPedido`, `idProveedor`, `idEstadoPedido`, `aclaracionesEstadoPedido`, `condicionesDeEntrega`, `totalPedido`) VALUES ('7', '2024-11-20', '2024-11-23', '8', '1', 'Cambio varias veces a pendiente', 'Buenas', '90');
INSERT INTO `pedido-a-proveedor` (`idPedido`, `fechaPedido`, `fechaEntregaPedido`, `idProveedor`, `idEstadoPedido`, `aclaracionesEstadoPedido`, `condicionesDeEntrega`, `totalPedido`) VALUES ('8', '2024-12-04', '2024-12-07', '6', '1', 'Ninguna', 'Las mejores', '4036');
INSERT INTO `pedido-a-proveedor` (`idPedido`, `fechaPedido`, `fechaEntregaPedido`, `idProveedor`, `idEstadoPedido`, `aclaracionesEstadoPedido`, `condicionesDeEntrega`, `totalPedido`) VALUES ('9', '2025-01-01', '2025-01-05', '8', '1', 'Ninguna de relevancia', 'Ir a buscar a negocio', '542.8');
INSERT INTO `pedido-a-proveedor` (`idPedido`, `fechaPedido`, `fechaEntregaPedido`, `idProveedor`, `idEstadoPedido`, `aclaracionesEstadoPedido`, `condicionesDeEntrega`, `totalPedido`) VALUES ('10', '2025-12-04', '2025-12-04', '9', '1', 'Sin aclaraciones', 'Hacen llamado previo', '257');

-- --------------------------------------------------------
-- Table structure for table `preparaciones-vehiculos`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `preparaciones-vehiculos`;
CREATE TABLE `preparaciones-vehiculos` (
  `idPreparacion` int(11) NOT NULL AUTO_INCREMENT,
  `descripcionPreparacion` varchar(200) DEFAULT NULL COMMENT 'Breve descripción opcional del tipo de preparación realizada.',
  `fechaInicioPreparacion` date NOT NULL,
  `fechaFinPreparacion` date NOT NULL,
  `idVehiculo` int(11) DEFAULT NULL,
  `idEmpleado` int(11) DEFAULT NULL,
  `idProductoUsado` int(11) DEFAULT NULL COMMENT 'Solo se admite un producto por cada registro de "preparación". ',
  PRIMARY KEY (`idPreparacion`),
  KEY `idVehiculo` (`idVehiculo`),
  KEY `idEmpleado` (`idEmpleado`),
  KEY `idProductoUsado` (`idProductoUsado`),
  CONSTRAINT `preparaciones-vehiculos_ibfk_1` FOREIGN KEY (`idVehiculo`) REFERENCES `vehiculos` (`idVehiculo`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `preparaciones-vehiculos_ibfk_2` FOREIGN KEY (`idEmpleado`) REFERENCES `empleados` (`idEmpleado`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `preparaciones-vehiculos_ibfk_3` FOREIGN KEY (`idProductoUsado`) REFERENCES `productos-vehiculo` (`idProducto`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------
-- Table structure for table `productos-vehiculo`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `productos-vehiculo`;
CREATE TABLE `productos-vehiculo` (
  `idProducto` int(11) NOT NULL AUTO_INCREMENT,
  `nombreProducto` varchar(50) NOT NULL,
  `descripcionProducto` varchar(200) DEFAULT NULL COMMENT 'Descripción opcional del producto',
  `cantidadEnDeposito` int(11) DEFAULT NULL COMMENT 'Cantidad de unidades que conforman el lote comprado',
  `precioProducto` float DEFAULT NULL COMMENT 'Precio unitario',
  `estadoProducto` varchar(100) DEFAULT NULL COMMENT 'Descripción optativa del estado del producto o los productos en caso de requerirse',
  `idTipoInsumo` int(11) DEFAULT NULL,
  `idProveedor` int(11) DEFAULT NULL,
  `vehiculosDestinatarios` varchar(200) DEFAULT NULL COMMENT 'Campo optativo que señala para cuál vehículo se adquirió el producto, en caso de que uno particular lo halla requerido. Separar con comas',
  PRIMARY KEY (`idProducto`),
  KEY `idTipoInsumo` (`idTipoInsumo`),
  KEY `idProveedor` (`idProveedor`),
  CONSTRAINT `productos-vehiculo_ibfk_1` FOREIGN KEY (`idTipoInsumo`) REFERENCES `tipo-insumo` (`idTipoInsumo`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `productos-vehiculo_ibfk_2` FOREIGN KEY (`idProveedor`) REFERENCES `proveedores` (`idProveedor`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `productos-vehiculo`
--

INSERT INTO `productos-vehiculo` (`idProducto`, `nombreProducto`, `descripcionProducto`, `cantidadEnDeposito`, `precioProducto`, `estadoProducto`, `idTipoInsumo`, `idProveedor`, `vehiculosDestinatarios`) VALUES ('1', 'Limpiador de llantas REVIGAL', 'Bajo precio', '1', '11', 'Aún no recibido', '2', '11', NULL);
INSERT INTO `productos-vehiculo` (`idProducto`, `nombreProducto`, `descripcionProducto`, `cantidadEnDeposito`, `precioProducto`, `estadoProducto`, `idTipoInsumo`, `idProveedor`, `vehiculosDestinatarios`) VALUES ('2', 'Cera marca VONIXX', 'Calidad elevada', '3', '22.3', 'Aún no recibido', '2', '9', NULL);
INSERT INTO `productos-vehiculo` (`idProducto`, `nombreProducto`, `descripcionProducto`, `cantidadEnDeposito`, `precioProducto`, `estadoProducto`, `idTipoInsumo`, `idProveedor`, `vehiculosDestinatarios`) VALUES ('3', 'Guantes de microfibra genéricos', 'Paquete con 40 unidades', '1', '25', 'Aún no recibido', '2', '1', NULL);

-- --------------------------------------------------------
-- Table structure for table `proveedores`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `proveedores`;
CREATE TABLE `proveedores` (
  `idProveedor` int(11) NOT NULL AUTO_INCREMENT,
  `nombreProveedor` varchar(50) NOT NULL,
  `mailProveedor` varchar(50) DEFAULT NULL,
  `direccionProveedor` varchar(50) DEFAULT NULL,
  `localidadProveedor` varchar(50) DEFAULT NULL,
  `telefonoProveedor` bigint(20) DEFAULT NULL,
  `cuitProveedor` bigint(20) DEFAULT NULL,
  `ivaProveedor` varchar(50) DEFAULT NULL,
  `idTipoInsumo` int(11) DEFAULT NULL,
  PRIMARY KEY (`idProveedor`),
  KEY `idTipoInsumo` (`idTipoInsumo`),
  CONSTRAINT `proveedores_ibfk_1` FOREIGN KEY (`idTipoInsumo`) REFERENCES `tipo-insumo` (`idTipoInsumo`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `proveedores`
--

INSERT INTO `proveedores` (`idProveedor`, `nombreProveedor`, `mailProveedor`, `direccionProveedor`, `localidadProveedor`, `telefonoProveedor`, `cuitProveedor`, `ivaProveedor`, `idTipoInsumo`) VALUES ('1', 'Bruno', 'brunocarossi@hotmail.com', '829, Av Malvinas Argentin', 'Pergamino, Argentina', '2477610676', '20381037364', 'Monotributo C', NULL);
INSERT INTO `proveedores` (`idProveedor`, `nombreProveedor`, `mailProveedor`, `direccionProveedor`, `localidadProveedor`, `telefonoProveedor`, `cuitProveedor`, `ivaProveedor`, `idTipoInsumo`) VALUES ('2', 'Litoral Gas S.A', 'litoralgas@gmail.com', '792 Tucuman', 'CABA, Argentina', '2477610676', '1111111111111111', 'Responsable Inscripto', NULL);
INSERT INTO `proveedores` (`idProveedor`, `nombreProveedor`, `mailProveedor`, `direccionProveedor`, `localidadProveedor`, `telefonoProveedor`, `cuitProveedor`, `ivaProveedor`, `idTipoInsumo`) VALUES ('3', 'LUCIA', 'lucia@hotmail.com', '829 Av Malvinas Argentin', 'Pergamino, Argentina', '32456787866', '345346375378578', 'Monotributo A', NULL);
INSERT INTO `proveedores` (`idProveedor`, `nombreProveedor`, `mailProveedor`, `direccionProveedor`, `localidadProveedor`, `telefonoProveedor`, `cuitProveedor`, `ivaProveedor`, `idTipoInsumo`) VALUES ('4', 'Nicolas Servidio', 'nicoservidio@gmail.com', '238 Alem', 'Villa Carlos Paz, Argentina', '123546758', '132465758', 'Monotributo B', NULL);
INSERT INTO `proveedores` (`idProveedor`, `nombreProveedor`, `mailProveedor`, `direccionProveedor`, `localidadProveedor`, `telefonoProveedor`, `cuitProveedor`, `ivaProveedor`, `idTipoInsumo`) VALUES ('5', 'Seguros SA', 'segurossa@segurossa.com', '883 Av Rivadavia', 'Córdoba Capital', '89893877', '6898302', 'Responsable Inscripto', NULL);
INSERT INTO `proveedores` (`idProveedor`, `nombreProveedor`, `mailProveedor`, `direccionProveedor`, `localidadProveedor`, `telefonoProveedor`, `cuitProveedor`, `ivaProveedor`, `idTipoInsumo`) VALUES ('6', 'Repuestos SA', 'repuestossa@repuestosa.com', '9182 Rodriguez', 'Córdoba Capital', '8888222999', '828828888', 'Responsable Inscripto', NULL);
INSERT INTO `proveedores` (`idProveedor`, `nombreProveedor`, `mailProveedor`, `direccionProveedor`, `localidadProveedor`, `telefonoProveedor`, `cuitProveedor`, `ivaProveedor`, `idTipoInsumo`) VALUES ('7', 'Limpiezas SA', 'limpiezassa@limpiezassa.com', '1626 Tucuman', 'CABA, Argentina', '8282884611', '7227727272', 'Responsable Inscripto', NULL);
INSERT INTO `proveedores` (`idProveedor`, `nombreProveedor`, `mailProveedor`, `direccionProveedor`, `localidadProveedor`, `telefonoProveedor`, `cuitProveedor`, `ivaProveedor`, `idTipoInsumo`) VALUES ('8', 'InsumOsCar SA', 'insumos-oscar@oscar.com', '88176 Guemes', 'Cordoba Capital, Argentina', '888299927166', '88165353511', 'Responsable Inscripto', NULL);
INSERT INTO `proveedores` (`idProveedor`, `nombreProveedor`, `mailProveedor`, `direccionProveedor`, `localidadProveedor`, `telefonoProveedor`, `cuitProveedor`, `ivaProveedor`, `idTipoInsumo`) VALUES ('9', 'TechnoVehiculos SA', 'proveedor@techonvehiculos.com', '1020 Guemes', 'Cordoba Capital, Argentina', '9991828888', '99100938777', 'Responsable Inscripto', NULL);
INSERT INTO `proveedores` (`idProveedor`, `nombreProveedor`, `mailProveedor`, `direccionProveedor`, `localidadProveedor`, `telefonoProveedor`, `cuitProveedor`, `ivaProveedor`, `idTipoInsumo`) VALUES ('11', 'TuVehiculo SA', 'proveedores@tvsa.com', '8389 Cuyo', 'CABA, Argentina', '8822228889', '99922200002', 'Responsable Inscripto', NULL);
INSERT INTO `proveedores` (`idProveedor`, `nombreProveedor`, `mailProveedor`, `direccionProveedor`, `localidadProveedor`, `telefonoProveedor`, `cuitProveedor`, `ivaProveedor`, `idTipoInsumo`) VALUES ('14', 'Proveedor SA', 'provedorsa@gmail.com', '1999 Alem', 'Bahía Blanca', '54545999', '878888', 'Responsable Inscripto', NULL);

-- --------------------------------------------------------
-- Table structure for table `repuestos-vehiculos`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `repuestos-vehiculos`;
CREATE TABLE `repuestos-vehiculos` (
  `idRepuesto` int(11) NOT NULL AUTO_INCREMENT,
  `nombreRepuesto` varchar(100) NOT NULL,
  `descripcionRepuesto` varchar(200) DEFAULT NULL COMMENT 'Descripción opcional del repuesto',
  `cantidadEnDeposito` int(11) DEFAULT NULL COMMENT 'Cantidad de unidades que conforman el lote comprado',
  `precioRepuesto` float DEFAULT NULL COMMENT 'Precio unitario',
  `estadoRepuesto` varchar(100) DEFAULT NULL COMMENT 'Campo opcional con aclaraciones sobre el estado del repuesto o lote de repuestos',
  `idTipoInsumo` int(11) DEFAULT NULL,
  `idProveedor` int(11) DEFAULT NULL,
  `disponibilidadRepuesto` varchar(200) DEFAULT NULL COMMENT 'Campo en donde se puede especificar cuántos están en uso o libres para ser usados en vehículos',
  `vehiculosHospedantes` varchar(200) DEFAULT NULL COMMENT 'El vehículo que lleva el repuesto o los repuestos. Separar con comas en caso de que sean diferentes',
  PRIMARY KEY (`idRepuesto`),
  KEY `idTipoInsumo` (`idTipoInsumo`),
  KEY `idProveedor` (`idProveedor`),
  CONSTRAINT `repuestos-vehiculos_ibfk_1` FOREIGN KEY (`idTipoInsumo`) REFERENCES `tipo-insumo` (`idTipoInsumo`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `repuestos-vehiculos_ibfk_2` FOREIGN KEY (`idProveedor`) REFERENCES `proveedores` (`idProveedor`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `repuestos-vehiculos`
--

INSERT INTO `repuestos-vehiculos` (`idRepuesto`, `nombreRepuesto`, `descripcionRepuesto`, `cantidadEnDeposito`, `precioRepuesto`, `estadoRepuesto`, `idTipoInsumo`, `idProveedor`, `disponibilidadRepuesto`, `vehiculosHospedantes`) VALUES ('1', 'Bomba de combustible', 'Bomba genérica de combustible, calidad mínima', '3', '800', 'Aún no recibido', '1', '4', NULL, NULL);
INSERT INTO `repuestos-vehiculos` (`idRepuesto`, `nombreRepuesto`, `descripcionRepuesto`, `cantidadEnDeposito`, `precioRepuesto`, `estadoRepuesto`, `idTipoInsumo`, `idProveedor`, `disponibilidadRepuesto`, `vehiculosHospedantes`) VALUES ('2', 'Bomba de combustible marca AEROMOTIVE', 'Bomba de combustible de calidad elevada', '2', '1300.74', 'Aún no recibido', '1', '4', NULL, NULL);
INSERT INTO `repuestos-vehiculos` (`idRepuesto`, `nombreRepuesto`, `descripcionRepuesto`, `cantidadEnDeposito`, `precioRepuesto`, `estadoRepuesto`, `idTipoInsumo`, `idProveedor`, `disponibilidadRepuesto`, `vehiculosHospedantes`) VALUES ('3', 'Pastillas de freno marca genérica', 'Genéricas', '9', '170.1', 'Aún no recibido', '1', '4', NULL, NULL);
INSERT INTO `repuestos-vehiculos` (`idRepuesto`, `nombreRepuesto`, `descripcionRepuesto`, `cantidadEnDeposito`, `precioRepuesto`, `estadoRepuesto`, `idTipoInsumo`, `idProveedor`, `disponibilidadRepuesto`, `vehiculosHospedantes`) VALUES ('4', 'Alternadores marca BOSCH', 'Calidad elevada', '4', '870', 'Aún no recibido', '1', '4', NULL, NULL);
INSERT INTO `repuestos-vehiculos` (`idRepuesto`, `nombreRepuesto`, `descripcionRepuesto`, `cantidadEnDeposito`, `precioRepuesto`, `estadoRepuesto`, `idTipoInsumo`, `idProveedor`, `disponibilidadRepuesto`, `vehiculosHospedantes`) VALUES ('5', 'Bujías NGK IRIDIUM', 'Calidad media', '4', '23', 'Aún no recibido', '1', '11', NULL, NULL);
INSERT INTO `repuestos-vehiculos` (`idRepuesto`, `nombreRepuesto`, `descripcionRepuesto`, `cantidadEnDeposito`, `precioRepuesto`, `estadoRepuesto`, `idTipoInsumo`, `idProveedor`, `disponibilidadRepuesto`, `vehiculosHospedantes`) VALUES ('6', 'Correas de distribución marca MANN-FILTER', '', '6', '18.3', 'Aún no recibido', '1', '1', NULL, NULL);
INSERT INTO `repuestos-vehiculos` (`idRepuesto`, `nombreRepuesto`, `descripcionRepuesto`, `cantidadEnDeposito`, `precioRepuesto`, `estadoRepuesto`, `idTipoInsumo`, `idProveedor`, `disponibilidadRepuesto`, `vehiculosHospedantes`) VALUES ('7', 'Espejos retrovisores VAN WEZEL', '', '2', '35', 'Aún no recibido', '1', '6', NULL, NULL);
INSERT INTO `repuestos-vehiculos` (`idRepuesto`, `nombreRepuesto`, `descripcionRepuesto`, `cantidadEnDeposito`, `precioRepuesto`, `estadoRepuesto`, `idTipoInsumo`, `idProveedor`, `disponibilidadRepuesto`, `vehiculosHospedantes`) VALUES ('8', 'Neumáticos marca MICHELIN', 'Gama media', '6', '44', 'Aún no recibido', '1', '6', NULL, NULL);
INSERT INTO `repuestos-vehiculos` (`idRepuesto`, `nombreRepuesto`, `descripcionRepuesto`, `cantidadEnDeposito`, `precioRepuesto`, `estadoRepuesto`, `idTipoInsumo`, `idProveedor`, `disponibilidadRepuesto`, `vehiculosHospedantes`) VALUES ('9', 'Alternador marca BMW', 'Gama alta', '3', '901', 'Aún no recibido', '1', '6', NULL, NULL);
INSERT INTO `repuestos-vehiculos` (`idRepuesto`, `nombreRepuesto`, `descripcionRepuesto`, `cantidadEnDeposito`, `precioRepuesto`, `estadoRepuesto`, `idTipoInsumo`, `idProveedor`, `disponibilidadRepuesto`, `vehiculosHospedantes`) VALUES ('10', 'Rótulas de suspensión marca LEMFÖRDER', 'Gama media', '10', '99.9', 'Aún no recibido', '1', '6', NULL, NULL);
INSERT INTO `repuestos-vehiculos` (`idRepuesto`, `nombreRepuesto`, `descripcionRepuesto`, `cantidadEnDeposito`, `precioRepuesto`, `estadoRepuesto`, `idTipoInsumo`, `idProveedor`, `disponibilidadRepuesto`, `vehiculosHospedantes`) VALUES ('11', 'Bujías marca NGK', 'Genéricas', '10', '45', 'Aún no recibido', '1', '8', NULL, NULL);
INSERT INTO `repuestos-vehiculos` (`idRepuesto`, `nombreRepuesto`, `descripcionRepuesto`, `cantidadEnDeposito`, `precioRepuesto`, `estadoRepuesto`, `idTipoInsumo`, `idProveedor`, `disponibilidadRepuesto`, `vehiculosHospedantes`) VALUES ('12', 'Filtros de aceite marca PURFLUX', 'alta calidad, tecnología de plegado Chevron para mayor área de filtración, diseño compacto y ligero, y compromiso con la protección ambiental', '4', '23.2', 'Aún no recibido', '1', '8', NULL, NULL);

-- --------------------------------------------------------
-- Table structure for table `reservas-vehiculos`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `reservas-vehiculos`;
CREATE TABLE `reservas-vehiculos` (
  `idReserva` int(11) NOT NULL AUTO_INCREMENT,
  `numeroReserva` int(11) DEFAULT NULL COMMENT 'Número de reserva del cliente. Habría que cambiar esto en el sistema para que fuera el ID, no pudiendose registrar manualmente',
  `fechaReserva` date NOT NULL,
  `fechaInicioReserva` date NOT NULL,
  `FechaFinReserva` date NOT NULL,
  `precioPorDiaReserva` float NOT NULL,
  `cantidadDiasReserva` int(11) NOT NULL,
  `totalReserva` float NOT NULL,
  `idCliente` int(11) DEFAULT NULL,
  `idContrato` int(11) DEFAULT NULL,
  `idSucursal` int(11) DEFAULT NULL,
  `idVehiculo` int(11) DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `comentario` text DEFAULT NULL,
  PRIMARY KEY (`idReserva`),
  KEY `idCliente` (`idCliente`),
  KEY `idContrato` (`idContrato`),
  KEY `idSucursal` (`idSucursal`),
  KEY `idVehiculo` (`idVehiculo`),
  CONSTRAINT `reservas-vehiculos_ibfk_1` FOREIGN KEY (`idCliente`) REFERENCES `clientes` (`idCliente`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `reservas-vehiculos_ibfk_2` FOREIGN KEY (`idContrato`) REFERENCES `contratos-alquiler` (`idContrato`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `reservas-vehiculos_ibfk_3` FOREIGN KEY (`idSucursal`) REFERENCES `sucursales` (`idSucursal`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `reservas-vehiculos_ibfk_4` FOREIGN KEY (`idVehiculo`) REFERENCES `vehiculos` (`idVehiculo`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=146 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `reservas-vehiculos`
--

INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('1', '12', '2024-11-01', '2024-11-02', '2024-11-05', '30', '3', '90', '8', NULL, '1', '18', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('2', '5', '2024-11-01', '2024-11-05', '2024-11-07', '20', '2', '40', '15', NULL, '1', '20', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('3', '8', '2024-11-01', '2024-11-04', '2024-11-08', '50', '4', '200', '4', NULL, '2', '32', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('5', '9', '2024-11-01', '2024-11-13', '2024-11-20', '20', '7', '140', '12', NULL, NULL, '1', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('6', '10', '2025-12-11', '2024-11-07', '2024-11-14', '20', '7', '140', '11', NULL, NULL, '25', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('7', '15', '2024-11-29', '2024-11-20', '2024-11-23', '20', '3', '60', '6', NULL, NULL, '24', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('8', '1', '2025-05-25', '2024-11-12', '2024-11-16', '20', '4', '80', '10', NULL, NULL, '42', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('9', '3', '2025-12-11', '2024-11-15', '2024-11-30', '40', '15', '600', '11', NULL, NULL, '37', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('10', '2', '2024-11-01', '2024-11-22', '2024-11-25', '20', '3', '60', '1', NULL, NULL, '2', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('14', '22', '2024-11-30', '2024-12-03', '2024-12-05', '20', '4', '80', '4', NULL, NULL, '2', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('17', '4', '2024-12-04', '2024-12-17', '2024-12-23', '20.5', '3', '61.5', '7', NULL, NULL, '19', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('18', '21', '2024-12-04', '2024-12-25', '2024-12-27', '20', '21', '420', '9', NULL, NULL, '2', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('19', '20', '2024-12-04', '2024-12-10', '2024-12-11', '20', '6', '120', '17', NULL, NULL, '7', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('20', '11', '2024-12-04', '2024-12-06', '2024-12-07', '20', '2', '40', '5', NULL, NULL, '23', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('21', '6', '2024-12-04', '2024-12-05', '2024-12-08', '20', '1', '20', '11', NULL, NULL, '23', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('22', '23', '2024-12-06', '2024-12-11', '2024-12-13', '20', '5', '100', '17', '8', NULL, '2', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('24', '24', '2024-12-07', '2024-12-14', '2024-12-16', '20', '7', '140', '7', '10', NULL, '1', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('25', '25', '2024-12-07', '2024-12-17', '2024-12-19', '50.1', '2', '100.2', '7', '12', '4', '32', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('26', '26', '2024-12-07', '2024-12-17', '2024-12-19', '33.3', '2', '66.6', '8', '13', '2', '6', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('27', '27', '2024-12-07', '2024-12-11', '2024-12-27', '90', '16', '1440', '6', '14', '4', '19', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('28', '28', '2024-12-07', '2024-12-14', '2025-01-04', '50', '21', '1050', '12', '15', '4', '36', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('29', '29', '2024-12-07', '2025-01-02', '2025-01-04', '90.6', '2', '181.2', '3', '18', '1', '1', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('30', '30', '2024-12-07', '2024-01-02', '2024-01-07', '61', '5', '305', '4', '20', '4', '32', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('31', '31', '2024-12-07', '2024-01-02', '2024-01-05', '73.2', '3', '219.6', '5', '21', '1', '3', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('32', '32', '2024-12-07', '2024-01-03', '2024-01-11', '89', '8', '712', '7', '22', '4', '35', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('33', '33', '2024-12-07', '2024-01-05', '2024-01-10', '48.61', '5', '243.05', '1', '23', '2', '7', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('34', '34', '2024-12-07', '2024-01-05', '2024-01-10', '58.43', '5', '292.15', '2', '24', '4', '19', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('35', '35', '2024-12-07', '2024-01-09', '2024-01-12', '72.49', '3', '217.47', '3', '25', '3', '30', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('36', '36', '2024-12-07', '2024-01-11', '2024-01-17', '34.27', '6', '205.62', '8', '26', '2', '6', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('37', '37', '2024-12-07', '2024-01-16', '2024-01-19', '88.9', '3', '266.7', '9', '27', '1', '1', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('38', '38', '2024-12-07', '2024-01-18', '2024-01-23', '81.6', '5', '408', '10', '28', '3', '28', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('39', '39', '2024-12-07', '2024-01-20', '2024-01-24', '99.1', '4', '396.4', '11', '29', '3', '18', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('40', '40', '2024-12-07', '2024-01-21', '2024-01-29', '71.8', '8', '574.4', '12', '30', '2', '21', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('41', '41', '2024-12-07', '2024-01-25', '2024-01-27', '75', '2', '150', '15', '31', '1', '23', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('42', '42', '2024-12-07', '2024-01-27', '2024-01-30', '89.3', '3', '267.9', '17', '32', '1', '24', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('43', '43', '2024-12-07', '2024-01-27', '2024-01-29', '89', '2', '178', '1', '33', '4', '36', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('44', '44', '2024-12-07', '2024-01-29', '2024-02-02', '73', '4', '292', '2', '34', '3', '20', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('45', '45', '2024-12-07', '2024-02-01', '2024-02-03', '46.8', '2', '93.6', '3', '35', '2', '2', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('46', '46', '2024-12-07', '2024-02-02', '2024-02-03', '70', '1', '70', '4', '36', '4', '32', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('47', '47', '2024-12-07', '2024-02-03', '2024-02-05', '79.3', '2', '158.6', '5', '37', '1', '3', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('48', '48', '2024-12-07', '2024-02-05', '2024-02-06', '65.81', '1', '65.81', '6', '38', '4', '35', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('49', '49', '2024-12-07', '2024-02-05', '2024-02-10', '69.81', '5', '349.05', '7', '39', '2', '7', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('50', '50', '2024-12-07', '2024-02-07', '2024-02-09', '78.3', '2', '156.6', '8', '40', '4', '19', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('51', '51', '2024-12-07', '2024-02-09', '2024-02-12', '98.1', '3', '294.3', '9', '41', '3', '30', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('52', '52', '2024-12-07', '2024-02-10', '2024-02-14', '110.32', '4', '441.28', '10', '42', '2', '6', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('53', '53', '2024-12-07', '2024-02-12', '2024-02-15', '87', '3', '261', '11', '43', '2', '25', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('54', '54', '2024-12-07', '2024-02-13', '2024-02-16', '82.99', '3', '248.97', '12', '44', '1', '1', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('55', '55', '2024-12-07', '2024-02-15', '2024-02-17', '87.39', '2', '174.78', '15', '45', '3', '28', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('56', '56', '2024-12-07', '2024-02-17', '2024-02-20', '91.15', '3', '273.45', '17', '46', '3', '18', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('57', '57', '2024-12-07', '2024-02-20', '2024-02-24', '86.87', '4', '347.48', '1', '47', '2', '21', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('58', '58', '2024-12-07', '2024-02-20', '2024-02-29', '78.2', '9', '703.8', '2', '48', '1', '23', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('59', '59', '2024-12-07', '2024-02-21', '2024-02-23', '98.2', '2', '196.4', '3', '49', '1', '24', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('60', '60', '2024-12-07', '2024-02-24', '2024-02-27', '110.25', '3', '330.75', '4', '50', '4', '36', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('61', '61', '2024-12-07', '2024-02-24', '2024-02-27', '105.4', '3', '316.2', '5', '51', '3', '20', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('62', '62', '2024-12-07', '2024-02-25', '2024-02-27', '67', '2', '134', '6', '52', '2', '2', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('63', '63', '2024-12-07', '2024-02-25', '2024-02-28', '68', '3', '204', '7', '53', '4', '32', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('64', '64', '2024-12-07', '2024-02-27', '2024-02-29', '78', '2', '156', '8', '54', '4', '35', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('65', '65', '2024-12-07', '2024-02-29', '2024-03-05', '71.11', '5', '355.55', '12', '55', '1', '3', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('66', '66', '2024-12-07', '2024-02-29', '2024-03-04', '78.12', '4', '312.48', '11', '56', '4', '35', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('67', '67', '2024-12-07', '2024-03-01', '2024-03-02', '88.7', '1', '88.7', '15', '57', '2', '7', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('68', '68', '2024-12-07', '2024-03-01', '2024-03-04', '91.3', '3', '273.9', '17', '58', '4', '19', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('69', '69', '2024-12-07', '2024-03-02', '2024-03-05', '67.88', '3', '203.64', '9', '59', '2', '2', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('70', '70', '2024-12-07', '2024-03-02', '2024-03-07', '78.28', '5', '391.4', '10', '60', '4', '32', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('71', '71', '2024-12-07', '2024-03-02', '2024-03-05', '76.9', '3', '230.7', '11', '61', '1', '3', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('72', '72', '2024-12-07', '2024-03-03', '2024-03-07', '89.88', '4', '359.52', '12', '62', '4', '35', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('73', '73', '2024-12-07', '2024-03-03', '2024-03-09', '91.9', '6', '551.4', '15', '63', '2', '7', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('74', '74', '2024-12-07', '2024-03-04', '2024-03-05', '81.71', '1', '81.71', '1', '64', '4', '19', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('75', '75', '2024-12-07', '2024-03-05', '2024-03-06', '86.8', '1', '86.8', '2', '65', '3', '30', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('76', '76', '2024-12-07', '2024-03-06', '2024-03-11', '101.3', '5', '506.5', '3', '66', '2', '6', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('77', '77', '2024-12-07', '2024-03-07', '2024-03-10', '201', '3', '603', '4', '67', '2', '25', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('78', '78', '2024-12-07', '2024-03-07', '2024-03-10', '120.8', '3', '362.4', '5', '68', '1', '1', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('79', '79', '2024-12-07', '2024-03-08', '2024-03-11', '110.9', '3', '332.7', '6', '69', '3', '28', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('80', '80', '2024-12-07', '2024-03-09', '2024-03-11', '99.9', '2', '199.8', '7', '70', '3', '18', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('81', '81', '2024-12-07', '2024-03-09', '2024-03-12', '110.99', '3', '332.97', '8', '71', '2', '21', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('82', '82', '2024-12-07', '2024-03-12', '2024-03-14', '110.9', '2', '221.8', '9', '72', '1', '23', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('83', '83', '2024-12-07', '2024-03-15', '2024-03-17', '105.99', '2', '211.98', '10', '73', '1', '24', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('84', '84', '2024-12-07', '2024-03-16', '2024-03-18', '110', '2', '220', '11', '74', '4', '36', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('85', '85', '2024-12-07', '2024-03-18', '2024-03-21', '115.88', '3', '347.64', '12', '75', '3', '20', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('86', '86', '2024-12-07', '2024-03-19', '2024-03-22', '113.99', '3', '341.97', '15', '76', '2', '25', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('87', '87', '2024-12-07', '2024-03-24', '2024-03-25', '120', '1', '120', '17', '77', '4', '32', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('88', '88', '2024-12-07', '2024-04-01', '2024-04-03', '120.99', '2', '241.98', '1', '78', '1', '3', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('89', '89', '2024-12-07', '2024-04-03', '2024-04-05', '110', '2', '220', '4', '79', '2', '2', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('90', '90', '2024-12-07', '2024-04-05', '2024-04-08', '120', '3', '360', '7', '80', '4', '35', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('91', '91', '2024-12-07', '2024-04-07', '2024-04-09', '130', '2', '260', '10', '81', '2', '7', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('92', '92', '2024-12-07', '2024-04-07', '2024-04-10', '120', '3', '360', '11', '82', '4', '19', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('93', '93', '2024-12-07', '2024-04-10', '2024-04-12', '125', '2', '250', '15', '83', '1', '1', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('94', '94', '2024-12-07', '2024-04-12', '2024-04-15', '130', '3', '390', '17', '84', '1', '23', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('95', '95', '2024-12-07', '2024-04-14', '2024-04-16', '100', '2', '200', '4', '85', '2', '2', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('96', '96', '2024-12-07', '2024-04-19', '2024-04-23', '120', '4', '480', '5', '86', '4', '19', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('97', '97', '2024-12-07', '2024-04-26', '2024-04-30', '120', '4', '480', '6', '87', '1', '23', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('98', '98', '2024-12-07', '2024-05-03', '2024-05-06', '125', '3', '375', '1', '88', '1', '1', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('99', '99', '2024-12-07', '2024-05-06', '2024-05-09', '113', '3', '339', '2', '89', '4', '19', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('100', '100', '2024-12-07', '2024-05-07', '2024-05-10', '135', '3', '405', '3', '90', '3', '18', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('101', '101', '2024-12-07', '2024-05-09', '2024-05-11', '117', '2', '234', '6', '91', '1', '23', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('102', '102', '2024-12-07', '2024-05-11', '2024-05-15', '140', '4', '560', '10', '92', '4', '36', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('103', '103', '2024-12-07', '2024-05-14', '2024-05-17', '130', '3', '390', '12', '93', '2', '2', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('104', '104', '2024-12-07', '2024-05-22', '2024-05-25', '120', '3', '360', '17', '94', '1', '3', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('105', '105', '2024-12-07', '2024-05-24', '2024-05-26', '135', '2', '270', '5', '95', '2', '7', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('106', '106', '2024-12-07', '2024-05-26', '2024-05-29', '110', '3', '330', '8', '96', '3', '18', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('107', '107', '2024-12-07', '2024-06-01', '2024-06-03', '135', '2', '270', '9', '97', '2', '2', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('108', '108', '2024-12-07', '2024-06-03', '2024-06-04', '145', '1', '145', '10', '98', '1', '3', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('109', '109', '2024-12-07', '2024-06-04', '2024-06-07', '150', '3', '450', '11', '99', '2', '7', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('110', '110', '2024-12-07', '2024-06-05', '2024-06-09', '140', '4', '560', '12', '100', '4', '36', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('111', '111', '2024-12-07', '2024-06-07', '2024-06-10', '130', '3', '390', '17', '101', '4', '19', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('112', '112', '2024-12-07', '2024-06-09', '2024-06-12', '140', '3', '420', '1', '102', '4', '36', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('113', '113', '2024-12-07', '2024-06-12', '2024-06-15', '135', '3', '405', '4', '103', '4', '32', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('114', '114', '2024-12-07', '2024-06-15', '2024-06-18', '145', '3', '435', '3', '104', '3', '20', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('115', '115', '2024-12-07', '2024-06-20', '2024-06-22', '135', '2', '270', '6', '105', '1', '3', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('116', '116', '2024-12-07', '2024-06-22', '2024-06-25', '125', '3', '375', '7', '106', '4', '32', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('117', '117', '2024-12-07', '2024-06-25', '2024-06-27', '155', '2', '310', '10', '107', '2', '21', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('118', '118', '2024-12-07', '2024-07-03', '2024-07-06', '135', '3', '405', '2', '108', '4', '35', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('119', '119', '2024-12-07', '2024-07-05', '2024-07-08', '145', '3', '435', '6', '109', '2', '7', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('120', '120', '2024-12-07', '2024-07-09', '2024-07-12', '128', '3', '384', '5', '110', '2', '2', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('121', '121', '2024-12-07', '2024-07-10', '2024-07-13', '145', '3', '435', '1', '111', '2', '6', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('122', '122', '2024-12-07', '2024-07-13', '2024-07-16', '135', '3', '405', '8', '112', '4', '35', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('123', '123', '2024-12-07', '2024-07-13', '2024-07-18', '145', '5', '725', '12', '113', '3', '30', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('124', '124', '2024-12-07', '2024-07-15', '2024-07-18', '150', '3', '450', '17', '114', '1', '1', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('125', '125', '2024-12-07', '2024-07-16', '2024-07-20', '130', '4', '520', '3', '115', '1', '3', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('126', '126', '2024-12-07', '2024-08-03', '2024-08-06', '145', '3', '435', '4', '116', '2', '2', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('127', '127', '2024-12-07', '2024-08-07', '2024-08-09', '165', '2', '330', '5', '117', '2', '6', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('128', '128', '2024-12-07', '2024-08-10', '2024-08-12', '165', '2', '330', '6', '118', '2', '25', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('129', '129', '2024-12-07', '2024-08-13', '2024-08-16', '165', '3', '495', '7', '119', '3', '18', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('130', '130', '2024-12-07', '2024-08-23', '2024-08-25', '200', '2', '400', '10', '120', '4', '36', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('131', '131', '2024-12-07', '2024-08-29', '2024-08-31', '180', '2', '360', '15', '121', '1', '23', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('132', '132', '2024-12-07', '2024-09-05', '2024-09-09', '205', '4', '820', '1', '122', '1', '1', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('133', '133', '2024-12-07', '2024-10-07', '2024-10-10', '120', '3', '360', '15', '123', '4', '19', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('134', '134', '2024-12-07', '2024-10-09', '2024-10-14', '138.9', '5', '694.5', '1', '124', '2', '25', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('135', '135', '2024-12-07', '2024-10-16', '2024-10-19', '135.7', '3', '407.1', '3', '125', '3', '18', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('136', '136', '2024-12-07', '2024-11-02', '2024-11-07', '110', '5', '550', '12', '126', '2', '2', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('137', '139', '2024-12-07', '2024-11-07', '2024-11-10', '125', '3', '375', '5', '127', '1', '23', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('138', '140', '2024-12-07', '2024-11-12', '2024-11-14', '125', '2', '250', '6', '128', '1', '24', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('139', '141', '2024-12-07', '2024-11-13', '2024-11-15', '135', '2', '270', '11', '129', '1', '24', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('140', '142', '2025-04-05', '2025-01-02', '2025-01-09', '45', '7', '315', '12', '131', '4', '19', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('142', '254', '2025-12-11', '2025-12-03', '2025-12-11', '45', '8', '360', '1', '140', '2', '42', '0', 'No voy a realizar el viaje');
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('143', '255', '2025-12-11', '2025-12-01', '2025-12-10', '40', '9', '360', '3', '141', '2', '45', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('144', NULL, '2025-12-11', '2025-12-12', '2025-12-20', '20', '8', '160', '1', NULL, '1', '45', '1', NULL);
INSERT INTO `reservas-vehiculos` (`idReserva`, `numeroReserva`, `fechaReserva`, `fechaInicioReserva`, `FechaFinReserva`, `precioPorDiaReserva`, `cantidadDiasReserva`, `totalReserva`, `idCliente`, `idContrato`, `idSucursal`, `idVehiculo`, `activo`, `comentario`) VALUES ('145', NULL, '2025-12-11', '2025-12-12', '2025-12-20', '35.5', '8', '284', '2', NULL, '1', '24', '1', NULL);

-- --------------------------------------------------------
-- Table structure for table `sucursales`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `sucursales`;
CREATE TABLE `sucursales` (
  `idSucursal` int(11) NOT NULL AUTO_INCREMENT,
  `numeroSucursal` int(11) NOT NULL,
  `direccionSucursal` varchar(50) NOT NULL,
  `ciudadSucursal` varchar(50) NOT NULL,
  `telefonoSucursal` int(11) DEFAULT NULL,
  PRIMARY KEY (`idSucursal`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `sucursales`
--

INSERT INTO `sucursales` (`idSucursal`, `numeroSucursal`, `direccionSucursal`, `ciudadSucursal`, `telefonoSucursal`) VALUES ('1', '3', 'Isabel la Católica 1632', 'Córdoba', '389893343');
INSERT INTO `sucursales` (`idSucursal`, `numeroSucursal`, `direccionSucursal`, `ciudadSucursal`, `telefonoSucursal`) VALUES ('2', '7', 'Av. Callao 2720', 'CABA', '29293933');
INSERT INTO `sucursales` (`idSucursal`, `numeroSucursal`, `direccionSucursal`, `ciudadSucursal`, `telefonoSucursal`) VALUES ('3', '0', 'A definir', 'Argentina', '991919000');
INSERT INTO `sucursales` (`idSucursal`, `numeroSucursal`, `direccionSucursal`, `ciudadSucursal`, `telefonoSucursal`) VALUES ('4', '11', 'Alem 238', 'Bahía Blanca', '22311167');
INSERT INTO `sucursales` (`idSucursal`, `numeroSucursal`, `direccionSucursal`, `ciudadSucursal`, `telefonoSucursal`) VALUES ('5', '9', 'Rivadavia 320', 'Villa Carlos Paz', '99745211');

-- --------------------------------------------------------
-- Table structure for table `tipo-insumo`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `tipo-insumo`;
CREATE TABLE `tipo-insumo` (
  `idTipoInsumo` int(11) NOT NULL AUTO_INCREMENT,
  `tipoInsumo` varchar(50) NOT NULL,
  `descripcionTipoInsumo` varchar(200) DEFAULT NULL COMMENT 'Descripción del tipo de insumo en caso de requerirse',
  PRIMARY KEY (`idTipoInsumo`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `tipo-insumo`
--

INSERT INTO `tipo-insumo` (`idTipoInsumo`, `tipoInsumo`, `descripcionTipoInsumo`) VALUES ('1', 'Repuesto', 'Piezas de repuestos para los vehiculos, neumáticos, etc');
INSERT INTO `tipo-insumo` (`idTipoInsumo`, `tipoInsumo`, `descripcionTipoInsumo`) VALUES ('2', 'Producto', 'Productos para el mantenimiento de los vehiculos');
INSERT INTO `tipo-insumo` (`idTipoInsumo`, `tipoInsumo`, `descripcionTipoInsumo`) VALUES ('3', 'Accesorio', 'Accesorios para colocar en vehículos');
INSERT INTO `tipo-insumo` (`idTipoInsumo`, `tipoInsumo`, `descripcionTipoInsumo`) VALUES ('4', 'Otros', 'Otros tipos de artículos o insumos diferentes de los principales. Ej, combustible, herramientas, elementos de oficina, etc');

-- --------------------------------------------------------
-- Table structure for table `usuarios`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(250) DEFAULT NULL,
  `usuario` varchar(250) DEFAULT NULL,
  `contrasena` varchar(250) DEFAULT NULL,
  `id_cargo` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_cargo` (`id_cargo`),
  KEY `id_cargo_2` (`id_cargo`),
  CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`id_cargo`) REFERENCES `cargo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `usuario`, `contrasena`, `id_cargo`) VALUES ('1', 'ADMINISTRADOR', 'ADMIN', 'ADMIN', '1');
INSERT INTO `usuarios` (`id`, `nombre`, `usuario`, `contrasena`, `id_cargo`) VALUES ('2', 'Nicolas Servidio', 'nservidio', '1234', '2');
INSERT INTO `usuarios` (`id`, `nombre`, `usuario`, `contrasena`, `id_cargo`) VALUES ('3', 'Facundo Mota', 'fmota', '1234', '3');
INSERT INTO `usuarios` (`id`, `nombre`, `usuario`, `contrasena`, `id_cargo`) VALUES ('4', 'Bruno Carossi', 'bcarossi', '1234', '4');
INSERT INTO `usuarios` (`id`, `nombre`, `usuario`, `contrasena`, `id_cargo`) VALUES ('5', 'Luke Skywalker', 'luke-skywalker', '1234', '12');
INSERT INTO `usuarios` (`id`, `nombre`, `usuario`, `contrasena`, `id_cargo`) VALUES ('6', 'Master Yoda', 'elorejudo', '1234', '9');
INSERT INTO `usuarios` (`id`, `nombre`, `usuario`, `contrasena`, `id_cargo`) VALUES ('7', 'Obi-Wan Kenobi', 'generalkenobi', '1234', '10');

-- --------------------------------------------------------
-- Table structure for table `vehiculos`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `vehiculos`;
CREATE TABLE `vehiculos` (
  `idVehiculo` int(11) NOT NULL AUTO_INCREMENT,
  `matricula` varchar(12) DEFAULT NULL,
  `color` varchar(20) DEFAULT NULL,
  `anio` int(4) DEFAULT NULL COMMENT 'Año de fabricación del vehículo',
  `fechaCompra` date DEFAULT NULL,
  `precioCompra` float DEFAULT NULL COMMENT 'Precio al que la empresa adquirió el vehículo',
  `numeroMotor` varchar(50) DEFAULT NULL COMMENT 'El número de motor de un automóvil es un código alfanumérico único que identifica el motor específico instalado en un vehículo. Generalmente se encuentra en el bloque del motor, aunque su ubicación puede variar según el modelo del vehículo. ',
  `numeroChasis` varchar(17) DEFAULT NULL COMMENT 'El número de chasis de un auto, también conocido como VIN (Vehicle Identification Number), es un código alfanumérico único de 17 dígitos que identifica cada vehículo. Este número contiene información clave sobre el vehículo, como su país de fabricación, el modelo y las características específicas. ',
  `puertas` int(11) DEFAULT NULL,
  `asientos` int(11) DEFAULT NULL,
  `esAutomatico` char(1) DEFAULT NULL COMMENT 'S o N',
  `aireAcondicionado` char(1) DEFAULT NULL COMMENT 'S o N',
  `dirHidraulica` char(1) DEFAULT NULL COMMENT 'S o N',
  `estadoFisicoDelVehiculo` varchar(200) DEFAULT NULL,
  `kilometraje` varchar(50) DEFAULT NULL,
  `disponibilidad` varchar(5) DEFAULT NULL,
  `idModelo` int(11) DEFAULT NULL,
  `idCombustible` int(11) DEFAULT NULL,
  `idGrupoVehiculo` int(11) DEFAULT NULL,
  `idSucursal` int(11) DEFAULT NULL,
  `activo` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`idVehiculo`),
  KEY `modelo` (`idModelo`),
  KEY `combustible` (`idCombustible`),
  KEY `grupo` (`idGrupoVehiculo`),
  KEY `sucursal` (`idSucursal`),
  CONSTRAINT `combustible` FOREIGN KEY (`idCombustible`) REFERENCES `combustibles` (`idCombustible`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `grupo` FOREIGN KEY (`idGrupoVehiculo`) REFERENCES `grupos-vehiculos` (`idGrupo`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `modelo` FOREIGN KEY (`idModelo`) REFERENCES `modelos` (`idModelo`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `sucursal` FOREIGN KEY (`idSucursal`) REFERENCES `sucursales` (`idSucursal`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vehiculos`
--

INSERT INTO `vehiculos` (`idVehiculo`, `matricula`, `color`, `anio`, `fechaCompra`, `precioCompra`, `numeroMotor`, `numeroChasis`, `puertas`, `asientos`, `esAutomatico`, `aireAcondicionado`, `dirHidraulica`, `estadoFisicoDelVehiculo`, `kilometraje`, `disponibilidad`, `idModelo`, `idCombustible`, `idGrupoVehiculo`, `idSucursal`, `activo`) VALUES ('1', 'AB468FG', 'Rojo', '2010', '0000-00-00', '0', '5453543', 'aaaaaa888888bbbbb', '4', '5', 'S', 'S', 'S', '', '', 'N', '6', '8', '13', '1', '0');
INSERT INTO `vehiculos` (`idVehiculo`, `matricula`, `color`, `anio`, `fechaCompra`, `precioCompra`, `numeroMotor`, `numeroChasis`, `puertas`, `asientos`, `esAutomatico`, `aireAcondicionado`, `dirHidraulica`, `estadoFisicoDelVehiculo`, `kilometraje`, `disponibilidad`, `idModelo`, `idCombustible`, `idGrupoVehiculo`, `idSucursal`, `activo`) VALUES ('2', 'AA070DE', 'Negro', '2013', '0000-00-00', '0', '5545', 'aaaaaa888888ccccc', '4', '5', 'N', 'S', 'S', '', '', 'N', '1', '4', '12', '2', '1');
INSERT INTO `vehiculos` (`idVehiculo`, `matricula`, `color`, `anio`, `fechaCompra`, `precioCompra`, `numeroMotor`, `numeroChasis`, `puertas`, `asientos`, `esAutomatico`, `aireAcondicionado`, `dirHidraulica`, `estadoFisicoDelVehiculo`, `kilometraje`, `disponibilidad`, `idModelo`, `idCombustible`, `idGrupoVehiculo`, `idSucursal`, `activo`) VALUES ('3', 'AC340FY', 'Negro', '2018', '0000-00-00', '7439', '54224', 'aaaaaa888888ddddd', '4', '4', 'N', 'S', 'S', '', '', 'N', '2', '7', '12', '1', '0');
INSERT INTO `vehiculos` (`idVehiculo`, `matricula`, `color`, `anio`, `fechaCompra`, `precioCompra`, `numeroMotor`, `numeroChasis`, `puertas`, `asientos`, `esAutomatico`, `aireAcondicionado`, `dirHidraulica`, `estadoFisicoDelVehiculo`, `kilometraje`, `disponibilidad`, `idModelo`, `idCombustible`, `idGrupoVehiculo`, `idSucursal`, `activo`) VALUES ('6', 'ADCS', 'Negro', '2015', NULL, NULL, '545', 'aaaaaa888888eeeee', '2', '5', 'N', 'S', 'S', NULL, '927 km al 2024-05-06', 'S', '5', '3', '6', '4', '1');
INSERT INTO `vehiculos` (`idVehiculo`, `matricula`, `color`, `anio`, `fechaCompra`, `precioCompra`, `numeroMotor`, `numeroChasis`, `puertas`, `asientos`, `esAutomatico`, `aireAcondicionado`, `dirHidraulica`, `estadoFisicoDelVehiculo`, `kilometraje`, `disponibilidad`, `idModelo`, `idCombustible`, `idGrupoVehiculo`, `idSucursal`, `activo`) VALUES ('7', 'HWUW9', 'Gris', '2012', NULL, NULL, '7575', 'aaaaaa888888fffff', '4', '4', 'N', 'S', 'S', NULL, 'No medido', 'S', '3', '4', '7', '2', '1');
INSERT INTO `vehiculos` (`idVehiculo`, `matricula`, `color`, `anio`, `fechaCompra`, `precioCompra`, `numeroMotor`, `numeroChasis`, `puertas`, `asientos`, `esAutomatico`, `aireAcondicionado`, `dirHidraulica`, `estadoFisicoDelVehiculo`, `kilometraje`, `disponibilidad`, `idModelo`, `idCombustible`, `idGrupoVehiculo`, `idSucursal`, `activo`) VALUES ('18', 'HH667S', 'Negro', '2020', NULL, NULL, '586', 'aaaaaa888888ggggg', '2', '2', 'S', 'S', 'N', NULL, '839 km al 2024-05-06', 'S', '7', '9', '4', '3', '1');
INSERT INTO `vehiculos` (`idVehiculo`, `matricula`, `color`, `anio`, `fechaCompra`, `precioCompra`, `numeroMotor`, `numeroChasis`, `puertas`, `asientos`, `esAutomatico`, `aireAcondicionado`, `dirHidraulica`, `estadoFisicoDelVehiculo`, `kilometraje`, `disponibilidad`, `idModelo`, `idCombustible`, `idGrupoVehiculo`, `idSucursal`, `activo`) VALUES ('19', 'FFFDAS', 'Negro', '2022', NULL, NULL, '475', 'aaaaaa888888hhhhh', '4', '5', 'S', 'S', 'S', NULL, '35728 km al 2024-05-06', 'S', '3', '9', '7', '5', '1');
INSERT INTO `vehiculos` (`idVehiculo`, `matricula`, `color`, `anio`, `fechaCompra`, `precioCompra`, `numeroMotor`, `numeroChasis`, `puertas`, `asientos`, `esAutomatico`, `aireAcondicionado`, `dirHidraulica`, `estadoFisicoDelVehiculo`, `kilometraje`, `disponibilidad`, `idModelo`, `idCombustible`, `idGrupoVehiculo`, `idSucursal`, `activo`) VALUES ('20', 'ASASA3', 'Rojo', '2021', NULL, NULL, '57775', 'aaaaaa888888iiiii', '2', '2', 'N', 'N', 'S', NULL, '3290 km al 2024-05-06', 'S', '10', '9', '1', '3', '1');
INSERT INTO `vehiculos` (`idVehiculo`, `matricula`, `color`, `anio`, `fechaCompra`, `precioCompra`, `numeroMotor`, `numeroChasis`, `puertas`, `asientos`, `esAutomatico`, `aireAcondicionado`, `dirHidraulica`, `estadoFisicoDelVehiculo`, `kilometraje`, `disponibilidad`, `idModelo`, `idCombustible`, `idGrupoVehiculo`, `idSucursal`, `activo`) VALUES ('21', 'HABN32', 'Blanco', '2015', '2024-10-01', '15393.8', '57475', 'bbbbbb888888bbbbb', '4', '4', 'N', 'N', 'S', NULL, '6051 km al 2024-05-06', 'S', '8', '9', '2', '2', '1');
INSERT INTO `vehiculos` (`idVehiculo`, `matricula`, `color`, `anio`, `fechaCompra`, `precioCompra`, `numeroMotor`, `numeroChasis`, `puertas`, `asientos`, `esAutomatico`, `aireAcondicionado`, `dirHidraulica`, `estadoFisicoDelVehiculo`, `kilometraje`, `disponibilidad`, `idModelo`, `idCombustible`, `idGrupoVehiculo`, `idSucursal`, `activo`) VALUES ('23', 'JHGP77F', 'Amarillo', NULL, '2024-10-02', NULL, '57474', 'bbbbbb888888ccccc', '4', '4', 'N', 'S', 'N', NULL, '3211 km al 2024-05-06', 'S', '8', '4', '10', '5', '1');
INSERT INTO `vehiculos` (`idVehiculo`, `matricula`, `color`, `anio`, `fechaCompra`, `precioCompra`, `numeroMotor`, `numeroChasis`, `puertas`, `asientos`, `esAutomatico`, `aireAcondicionado`, `dirHidraulica`, `estadoFisicoDelVehiculo`, `kilometraje`, `disponibilidad`, `idModelo`, `idCombustible`, `idGrupoVehiculo`, `idSucursal`, `activo`) VALUES ('24', 'NE32SR', 'Rojo', '2018', '2024-10-08', NULL, '362', 'bbbbbb888888ddddd', '2', '4', 'N', 'N', 'S', NULL, 'No medido', 'S', '8', '9', '2', '5', '1');
INSERT INTO `vehiculos` (`idVehiculo`, `matricula`, `color`, `anio`, `fechaCompra`, `precioCompra`, `numeroMotor`, `numeroChasis`, `puertas`, `asientos`, `esAutomatico`, `aireAcondicionado`, `dirHidraulica`, `estadoFisicoDelVehiculo`, `kilometraje`, `disponibilidad`, `idModelo`, `idCombustible`, `idGrupoVehiculo`, `idSucursal`, `activo`) VALUES ('25', 'XY909BM', 'Negro', '2020', '2024-10-04', NULL, '868', 'bbbbbb888888eeeee', '4', '5', 'S', 'S', 'N', NULL, '8392 km al 2024-05-06', 'S', '5', '2', '1', '2', '1');
INSERT INTO `vehiculos` (`idVehiculo`, `matricula`, `color`, `anio`, `fechaCompra`, `precioCompra`, `numeroMotor`, `numeroChasis`, `puertas`, `asientos`, `esAutomatico`, `aireAcondicionado`, `dirHidraulica`, `estadoFisicoDelVehiculo`, `kilometraje`, `disponibilidad`, `idModelo`, `idCombustible`, `idGrupoVehiculo`, `idSucursal`, `activo`) VALUES ('28', 'WYS88A', 'Negro', '2022', '2024-11-03', NULL, '2775', 'bbbbbb888888fffff', '4', '5', 'N', 'S', 'N', NULL, '6283 km al 2024-05-06', 'N', '6', '9', '1', '2', '1');
INSERT INTO `vehiculos` (`idVehiculo`, `matricula`, `color`, `anio`, `fechaCompra`, `precioCompra`, `numeroMotor`, `numeroChasis`, `puertas`, `asientos`, `esAutomatico`, `aireAcondicionado`, `dirHidraulica`, `estadoFisicoDelVehiculo`, `kilometraje`, `disponibilidad`, `idModelo`, `idCombustible`, `idGrupoVehiculo`, `idSucursal`, `activo`) VALUES ('30', 'XY33BM', 'Gris', '2017', '2024-11-02', NULL, '7557', 'cccccc888888bbbbb', '4', '5', 'N', 'S', 'S', NULL, 'No medido', 'S', '4', '9', '3', '3', '1');
INSERT INTO `vehiculos` (`idVehiculo`, `matricula`, `color`, `anio`, `fechaCompra`, `precioCompra`, `numeroMotor`, `numeroChasis`, `puertas`, `asientos`, `esAutomatico`, `aireAcondicionado`, `dirHidraulica`, `estadoFisicoDelVehiculo`, `kilometraje`, `disponibilidad`, `idModelo`, `idCombustible`, `idGrupoVehiculo`, `idSucursal`, `activo`) VALUES ('32', 'BLABLA9', 'Negro', '2021', '2024-12-01', NULL, '7525', 'bbbbbb999999bbbbb', '4', '5', 'S', 'S', 'S', NULL, '9838 km al 2024-07-21', 'S', '1', '6', '12', '4', '1');
INSERT INTO `vehiculos` (`idVehiculo`, `matricula`, `color`, `anio`, `fechaCompra`, `precioCompra`, `numeroMotor`, `numeroChasis`, `puertas`, `asientos`, `esAutomatico`, `aireAcondicionado`, `dirHidraulica`, `estadoFisicoDelVehiculo`, `kilometraje`, `disponibilidad`, `idModelo`, `idCombustible`, `idGrupoVehiculo`, `idSucursal`, `activo`) VALUES ('35', 'ROR99C', 'Verde', '2020', '2024-12-03', NULL, '2288', 'bbbbbb999999ccccc', '2', '4', 'N', 'S', 'S', NULL, 'No medido', 'S', '2', '3', '4', '4', '1');
INSERT INTO `vehiculos` (`idVehiculo`, `matricula`, `color`, `anio`, `fechaCompra`, `precioCompra`, `numeroMotor`, `numeroChasis`, `puertas`, `asientos`, `esAutomatico`, `aireAcondicionado`, `dirHidraulica`, `estadoFisicoDelVehiculo`, `kilometraje`, `disponibilidad`, `idModelo`, `idCombustible`, `idGrupoVehiculo`, `idSucursal`, `activo`) VALUES ('36', 'RBA11R', 'Blanco', '2016', '2024-12-07', NULL, '17557', 'bbbbbb999999ddddd', '4', '5', 'N', 'S', 'S', NULL, '3828 km al 2024-08-28', 'S', '9', '7', '8', '1', '1');
INSERT INTO `vehiculos` (`idVehiculo`, `matricula`, `color`, `anio`, `fechaCompra`, `precioCompra`, `numeroMotor`, `numeroChasis`, `puertas`, `asientos`, `esAutomatico`, `aireAcondicionado`, `dirHidraulica`, `estadoFisicoDelVehiculo`, `kilometraje`, `disponibilidad`, `idModelo`, `idCombustible`, `idGrupoVehiculo`, `idSucursal`, `activo`) VALUES ('37', 'ZP19JD', 'Negro', '2021', '2025-04-23', NULL, '157', 'bbbbbb999999eeeee', '4', '7', 'N', 'S', 'S', NULL, '7328 km al 2025-01-17', 'S', '6', '1', '2', '1', '1');
INSERT INTO `vehiculos` (`idVehiculo`, `matricula`, `color`, `anio`, `fechaCompra`, `precioCompra`, `numeroMotor`, `numeroChasis`, `puertas`, `asientos`, `esAutomatico`, `aireAcondicionado`, `dirHidraulica`, `estadoFisicoDelVehiculo`, `kilometraje`, `disponibilidad`, `idModelo`, `idCombustible`, `idGrupoVehiculo`, `idSucursal`, `activo`) VALUES ('38', '0000000', 'Gris', '2024', '2025-04-23', '0', '1657', 'bbbbbb999999fffff', '4', '6', 'N', 'S', 'S', '', '', 'N', '2', '9', '4', '3', '1');
INSERT INTO `vehiculos` (`idVehiculo`, `matricula`, `color`, `anio`, `fechaCompra`, `precioCompra`, `numeroMotor`, `numeroChasis`, `puertas`, `asientos`, `esAutomatico`, `aireAcondicionado`, `dirHidraulica`, `estadoFisicoDelVehiculo`, `kilometraje`, `disponibilidad`, `idModelo`, `idCombustible`, `idGrupoVehiculo`, `idSucursal`, `activo`) VALUES ('39', 'Z83KAJE', NULL, NULL, '2025-05-10', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', '9', '9', '9', '3', '1');
INSERT INTO `vehiculos` (`idVehiculo`, `matricula`, `color`, `anio`, `fechaCompra`, `precioCompra`, `numeroMotor`, `numeroChasis`, `puertas`, `asientos`, `esAutomatico`, `aireAcondicionado`, `dirHidraulica`, `estadoFisicoDelVehiculo`, `kilometraje`, `disponibilidad`, `idModelo`, `idCombustible`, `idGrupoVehiculo`, `idSucursal`, `activo`) VALUES ('42', '11ARNOK', 'Naranja', '2023', '2025-01-01', '13001.4', 'AJ8329KLNE902930LKNE', '999JNANANA828NN', '4', '4', 'N', 'S', 'S', 'Adquirido nuevo, sin defectos.', '200 km al 2025-02-02', 'S', '6', '8', '9', '5', '1');
INSERT INTO `vehiculos` (`idVehiculo`, `matricula`, `color`, `anio`, `fechaCompra`, `precioCompra`, `numeroMotor`, `numeroChasis`, `puertas`, `asientos`, `esAutomatico`, `aireAcondicionado`, `dirHidraulica`, `estadoFisicoDelVehiculo`, `kilometraje`, `disponibilidad`, `idModelo`, `idCombustible`, `idGrupoVehiculo`, `idSucursal`, `activo`) VALUES ('44', 'KN82CHA', 'Amarillo', '2021', '2024-02-02', '9032.4', 'HJKA920PPPP929999', 'NHAHHAKEJEJ77777', '2', '2', 'S', 'S', 'S', 'No se adquirió 0K y presenta algunos defectos en carrocería', '4554km al 04-04-2024', 'S', '5', '5', '11', '2', '1');
INSERT INTO `vehiculos` (`idVehiculo`, `matricula`, `color`, `anio`, `fechaCompra`, `precioCompra`, `numeroMotor`, `numeroChasis`, `puertas`, `asientos`, `esAutomatico`, `aireAcondicionado`, `dirHidraulica`, `estadoFisicoDelVehiculo`, `kilometraje`, `disponibilidad`, `idModelo`, `idCombustible`, `idGrupoVehiculo`, `idSucursal`, `activo`) VALUES ('45', 'zzzzzz', NULL, NULL, '2025-05-10', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'S', '1', '9', '12', '2', '1');

-- --------------------------------------------------------
-- Table structure for table `vendedores`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `vendedores`;
CREATE TABLE `vendedores` (
  `idVendedor` int(11) NOT NULL AUTO_INCREMENT,
  `idEmpleado` int(11) DEFAULT NULL,
  PRIMARY KEY (`idVendedor`),
  KEY `idEmpleado` (`idEmpleado`),
  CONSTRAINT `vendedores_ibfk_1` FOREIGN KEY (`idEmpleado`) REFERENCES `empleados` (`idEmpleado`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------
-- Table structure for table `verificaciones-vehiculos`
-- --------------------------------------------------------

DROP TABLE IF EXISTS `verificaciones-vehiculos`;
CREATE TABLE `verificaciones-vehiculos` (
  `idVerificacion` int(11) NOT NULL AUTO_INCREMENT,
  `nombreVerificacion` varchar(100) NOT NULL,
  `descripcionVerificacion` varchar(200) DEFAULT NULL COMMENT 'Descripción opcional en caso de requerirse',
  `fechaVerificacion` date NOT NULL,
  `resultadoVerificacion` varchar(40) NOT NULL,
  `observacionesVerificacion` varchar(200) DEFAULT NULL COMMENT 'Observaciones sobre el proceso de verificación en caso de requerirse',
  `idVehiculo` int(11) DEFAULT NULL,
  PRIMARY KEY (`idVerificacion`),
  KEY `idVehiculo` (`idVehiculo`),
  CONSTRAINT `verificaciones-vehiculos_ibfk_1` FOREIGN KEY (`idVehiculo`) REFERENCES `vehiculos` (`idVehiculo`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


SET foreign_key_checks = 1;
COMMIT;
