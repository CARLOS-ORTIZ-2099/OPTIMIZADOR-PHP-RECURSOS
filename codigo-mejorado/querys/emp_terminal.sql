--
-- Estructura de tabla para la tabla `emp_terminal`
--

CREATE TABLE `emp_terminal` (
  `ter_id` int NOT NULL,
  `ter_nombre` varchar(100) DEFAULT NULL,
  `ter_ubigeo` varchar(10) DEFAULT NULL,
  `ter_habilitado` tinyint NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
 

--
-- Indices de la tabla `emp_terminal`
--
ALTER TABLE `emp_terminal`
  ADD PRIMARY KEY (`ter_id`);



ALTER TABLE `emp_terminal`
  MODIFY `ter_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;
COMMIT;

--
-- Volcado de datos para la tabla `emp_terminal`
--

INSERT INTO `emp_terminal` (`ter_id`, `ter_nombre`, `ter_ubigeo`, `ter_habilitado`) VALUES
(1, 'San Isidro', '150132', 1),
(2, 'Miraflores', '150124', 0),
(3, 'Los Olivos', '150113', 1),
(4, 'Surco', '150138', 1),
(5, 'La Molina', '150105', 0),
(6, 'Barranco', '150104', 1),
(7, 'Chorrillos', '150106', 0),
(8, 'San Borja', '150131', 1),
(9, 'San Miguel', '150137', 1),
(10, 'Jesús María', '150111', 0),
(11, 'Pueblo Libre', '150122', 1),
(12, 'Lince', '150110', 1),
(13, 'Rímac', '150119', 0),
(14, 'Callao', '070101', 1),
(15, 'Villa El Salvador', '150142', 0),
(16, 'Villa María del Triunfo', '150143', 1),
(17, 'Breña', '150102', 1),
(18, 'Cercado de Lima', '150101', 0),
(19, 'San Juan de Lurigancho', '150133', 1),
(20, 'San Juan de Miraflores', '150134', 0),
(21, 'Magdalena', '150112', 1),
(22, 'Ate', '150103', 1),
(23, 'El Agustino', '150107', 0),
(24, 'Independencia', '150109', 1),
(25, 'Carabayllo', '150108', 0),
(26, 'Comas', '150116', 1),
(27, 'San Martín de Porres', '150135', 1),
(28, 'Santa Anita', '150140', 0),
(29, 'Chaclacayo', '150105', 1),
(30, 'Lurigancho', '150115', 0),
(31, 'Lurín', '150117', 1),
(32, 'Pachacamac', '150120', 1),
(33, 'Pucusana', '150121', 0),
(34, 'Puente Piedra', '150123', 1),
(35, 'Santa María del Mar', '150141', 0),
(36, 'Santa Rosa', '150139', 1),
(37, 'Cieneguilla', '150114', 0),
(38, 'San Luis', '150136', 1),
(39, 'Mi Perú', '070107', 1),
(40, 'Ventanilla', '070106', 0),
(41, 'Bellavista', '070102', 1),
(42, 'Carmen de la Legua', '070103', 0),
(43, 'La Perla', '070104', 1),
(44, 'La Punta', '070105', 1),
(45, 'Ancón', '150101', 0),
(46, 'Santa Eulalia', '150126', 1),
(47, 'Ricardo Palma', '150128', 0),
(48, 'San Pedro de Casta', '150130', 1),
(49, 'San Bartolo', '150129', 1),
(50, 'Punta Hermosa', '150125', 0),
(51, 'Punta Negra', '150127', 1),
(52, 'San Andrés', '110201', 1),
(53, 'Paracas', '110204', 0),
(54, 'Pisco', '110205', 1),
(55, 'Ica', '110101', 1),
(56, 'Chincha Alta', '110201', 0),
(57, 'Nazca', '110301', 1),
(58, 'Mala', '150601', 0),
(59, 'Asia', '150602', 1),
(60, 'San Antonio', '150604', 1),
(61, 'Cañete', '150603', 0),
(62, 'Imperial', '150605', 1),
(63, 'San Vicente de Cañete', '150606', 1),
(64, 'Nuevo Imperial', '150607', 0),
(65, 'San Luis de Cañete', '150608', 1),
(66, 'Pacarán', '150609', 0),
(67, 'Quilmana', '150610', 1),
(68, 'Zúñiga', '150611', 1),
(69, 'Calango', '150612', 0),
(70, 'Coayllo', '150613', 1);

