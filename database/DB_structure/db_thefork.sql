-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-02-2022 a las 23:06:20
-- Versión del servidor: 10.4.14-MariaDB
-- Versión de PHP: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `db_thefork`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_carta`
--

CREATE TABLE `tbl_carta` (
  `id` int(11) NOT NULL,
  `precio_medio` decimal(5,2) NOT NULL,
  `id_restaurante_fk` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tbl_carta`
--

INSERT INTO `tbl_carta` (`id`, `precio_medio`, `id_restaurante_fk`) VALUES
(1, '50.00', 4),
(2, '20.00', 3),
(3, '40.00', 2),
(4, '60.00', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_imagen`
--

CREATE TABLE `tbl_imagen` (
  `id` int(11) NOT NULL,
  `imagen` varchar(150) NOT NULL,
  `id_restaurante_fk` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_restaurante`
--

CREATE TABLE `tbl_restaurante` (
  `id` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `descripcion` text NOT NULL,
  `direccion` varchar(100) NOT NULL,
  `correo_responsable` varchar(70) NOT NULL,
  `correo_restaurante` varchar(70) DEFAULT NULL,
  `id_tipo_cocina` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tbl_restaurante`
--

INSERT INTO `tbl_restaurante` (`id`, `nombre`, `descripcion`, `direccion`, `correo_responsable`, `correo_restaurante`, `id_tipo_cocina`) VALUES
(1, 'Fonda España by Martín Berasategui - Hotel España', 'Al restaurant Fonda España, Martín Berasategui recupera l\'antic concepte de les fondes apostant per la cuina més tradicional de la terra amb un gest d\'actualitat. Al capdavant dels fogons de la Fonda España hi ha el xef German Espinosa, amb anys d\'experiència sota la direcció de Martín Berasategui.\r\n\r\nEl restaurant s’ubica al menjador modernista originalment projectat i decorat per Domènech i Montaner, un entorn d’un ric interès patrimonial en què els elements històrics potencien i inspiren els nous.\r\n\r\nCap de cuina: German Espinosa\r\nCap de sala: Nuno Antunes', 'Carrer de Sant Pau, 9, 08001 Barcelona', 'alfredoblumtorres@gmail.com', NULL, 2),
(2, 'Port Vela', 'Este agradable restaurante, también conocido como la cervecería del rompeolas, está especializado en tapas, brasas y pescados frescos, y cuenta con una de las terrazas más apetecibles del Puerto. Sentarse a disfrutar de las vistas en un entorno marinero y poder comer relajadamente, a pesar de estar en una zona tan concurrida, es un plus. La clientela, que acude con asiduidad, recomienda tomarse un vermut y acompañarlo con un montadito de croissant crujiente de paletilla ibérica, con un montado de crema de queso manchego con confitura, con una gildas del País Vasco o con unas berenjenas con miel de caña. ¡Plan perfecto!', 'Passeig de Joan de Borbó, 103, Local 7/8, 08039 Barcelona', '100006207.joan23@fje.edu', NULL, 2),
(3, 'Bar Bar - The Indian Gastronomía', 'Bar Bar és un nou bar i restaurant gastronòmic indi situat al bulliciós barri de l’Eixample. Inspirat en els nostres desitjos intrínsecs per a la cuina índia i en els antecedents nòmades dels fundadors-Bar Bar creu en posar el menjar indi a la paleta mundial amb un toc audaç per desafiar-lo percepció, però segueixen sent apologèticament autèntiques i fidels a les nostres arrels. Et convidem a prendre un mos i deixar-te transportar a una celebració de l’Índia El patrimoni a través dels ulls de Barcelona.', 'Carrer d\'Aribau, 146, 08036 Barcelona', '7100.joan23@fje.edu', NULL, 7),
(4, 'Assunta Barcelona\r\n', 'Assunta es originalmente el nombre de una paranza utilizada para la pesca en las aguas que rodean la isla de Ponza , un mar cristalino e incontaminado con un olor inconfundible, casi etéreo, el mismo olor que hemos decidido traer de vuelta a nuestros platos.\r\nAssunta llega a Barcelona con una única misión: crear un lugar cálido y dinámico, donde las propuestas de una cocina tradicional y sustanciosa se encuentran con las emociones de nuestros comensales, a través de una carta que cambia todos los días, porque nunca sabes lo que te puede dar el mar.\r\nNuestra voluntad es ofrecer el saber de nuestras madres y abuelas a los paladares internacionales de nuestros comensales, en una cocina sin florituras innecesarias, pero tradicional, ligera y sabrosa, donde el único protagonista es el pescado : crudo, a la plancha, a la sal, guisado, cacciatore, para concluir con nuestra fritura, todo lo demás pasa a un segundo plano.\r\nEntonces, ¿qué se contrata en Barcelona? Es un restaurante donde el lujo se encuentra con la tradición, una pescadería con sólo productos de la lonja del día , un fish bar, un bar de ostras, una crustaceria, una cicchetteria, una tienda de especialidades marineras gourmet para llevar a casa... todo esto es Assunta, la tradición italiana del pescado.', 'C/ de Provença, 300, 08008 Barcelona', '100006203.joan23@fje.edu', NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_tipo_cocina`
--

CREATE TABLE `tbl_tipo_cocina` (
  `id` int(11) NOT NULL,
  `tipo_cocina` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tbl_tipo_cocina`
--

INSERT INTO `tbl_tipo_cocina` (`id`, `tipo_cocina`) VALUES
(1, 'Italiana'),
(2, 'Española'),
(3, 'Francesa'),
(4, 'Árabe'),
(5, 'Inglesa'),
(6, 'Alemana'),
(7, 'Asiática');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_usuario`
--

CREATE TABLE `tbl_usuario` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellidos` varchar(70) NOT NULL,
  `email` varchar(60) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `rol` enum('Admin','Cliente') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tbl_usuario`
--

INSERT INTO `tbl_usuario` (`id`, `nombre`, `apellidos`, `email`, `pass`, `rol`) VALUES
(1, 'Alfredo', 'Blum Torres', 'blum@admon.net', 'qwe123', 'Admin'),
(2, 'Xavier', 'Gómez Gallego', 'lamaricona97@admon.net', 'asd123', 'Admin'),
(3, 'Marc', 'Ortíz Gonzalez', 'ortiz@admon.net', 'qaz123', 'Admin'),
(4, 'Daniel', 'Larrea', 'larri@client.es', 'wsx123', 'Cliente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_valoracion`
--

CREATE TABLE `tbl_valoracion` (
  `id` int(11) NOT NULL,
  `comentario` text DEFAULT NULL,
  `valoracion` int(11) DEFAULT NULL,
  `id_restaurante_fk` int(11) DEFAULT NULL,
  `id_usuario_fk` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tbl_valoracion`
--

INSERT INTO `tbl_valoracion` (`id`, `comentario`, `valoracion`, `id_restaurante_fk`, `id_usuario_fk`) VALUES
(1, 'Comida bastante buena, sitio bien ubicado y con muy buenas vistas, bastante moderno y trato muy increíble, Gracias por vuestra profesionalidad, volveré seguro', NULL, 1, 4);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tbl_carta`
--
ALTER TABLE `tbl_carta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_carta_restaurante_idx` (`id_restaurante_fk`);

--
-- Indices de la tabla `tbl_imagen`
--
ALTER TABLE `tbl_imagen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_foto_restaurante_idx` (`id_restaurante_fk`);

--
-- Indices de la tabla `tbl_restaurante`
--
ALTER TABLE `tbl_restaurante`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_restaurante_tipo_cocina_idx` (`id_tipo_cocina`);

--
-- Indices de la tabla `tbl_tipo_cocina`
--
ALTER TABLE `tbl_tipo_cocina`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tbl_usuario`
--
ALTER TABLE `tbl_usuario`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tbl_valoracion`
--
ALTER TABLE `tbl_valoracion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_valoracion_restaurante_idx` (`id_restaurante_fk`),
  ADD KEY `fk_valoracion_usuario_idx` (`id_usuario_fk`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tbl_carta`
--
ALTER TABLE `tbl_carta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tbl_restaurante`
--
ALTER TABLE `tbl_restaurante`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tbl_tipo_cocina`
--
ALTER TABLE `tbl_tipo_cocina`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `tbl_usuario`
--
ALTER TABLE `tbl_usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tbl_valoracion`
--
ALTER TABLE `tbl_valoracion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tbl_carta`
--
ALTER TABLE `tbl_carta`
  ADD CONSTRAINT `id_carta_restaurante` FOREIGN KEY (`id_restaurante_fk`) REFERENCES `tbl_restaurante` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `tbl_imagen`
--
ALTER TABLE `tbl_imagen`
  ADD CONSTRAINT `fk_foto_restaurante` FOREIGN KEY (`id_restaurante_fk`) REFERENCES `tbl_restaurante` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `tbl_restaurante`
--
ALTER TABLE `tbl_restaurante`
  ADD CONSTRAINT `fk_restaurante_tipo_cocina` FOREIGN KEY (`id_tipo_cocina`) REFERENCES `tbl_tipo_cocina` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `tbl_valoracion`
--
ALTER TABLE `tbl_valoracion`
  ADD CONSTRAINT `fk_valoracion_restaurante` FOREIGN KEY (`id_restaurante_fk`) REFERENCES `tbl_restaurante` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_valoracion_usuario` FOREIGN KEY (`id_usuario_fk`) REFERENCES `tbl_usuario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
