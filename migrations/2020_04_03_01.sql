CREATE TABLE IF NOT EXISTS `inventarios_clasificacion` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Clasificacion` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Estado` int(1) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE IF NOT EXISTS `productos_servicios` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Referencia` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Nombre` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `PrecioVenta` double NOT NULL,
  `idClasificacion` int(11) NOT NULL,
  `Estado` int(1) NOT NULL,
  `idUser` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `Referencia` (`Referencia`),
  KEY `idClasificacion` (`idClasificacion`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


CREATE TABLE IF NOT EXISTS `productos_servicios_imagenes` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `idProducto` bigint(20) NOT NULL,
  `Ruta` varchar(90) COLLATE utf8_spanish_ci NOT NULL,
  `NombreArchivo` text COLLATE utf8_spanish_ci NOT NULL,
  `Extension` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `Tamano` bigint(20) NOT NULL,
  `idUser` int(11) NOT NULL,
  `Created` datetime NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `idProducto` (`idProducto`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;