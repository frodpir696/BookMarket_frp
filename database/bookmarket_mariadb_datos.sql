-- =====================================================
-- BookMarket - Datos iniciales ampliados para MariaDB
-- =====================================================

USE `bookmarket`;

-- -----------------------------------------------------
-- Limpieza opcional (orden inverso por claves foráneas)
-- -----------------------------------------------------
DELETE FROM `carrito_book`;
DELETE FROM `book`;
DELETE FROM `pedido`;
DELETE FROM `mensaje`;
DELETE FROM `carrito`;
DELETE FROM `categoria`;
DELETE FROM `user`;

-- -----------------------------------------------------
-- Usuarios
-- password de ejemplo para todos: 123456
-- -----------------------------------------------------
INSERT INTO `user` (`id`, `nombre`, `email`, `password`, `rol`, `fecha_registro`) VALUES
(1, 'Admin BookMarket', 'admin@bookmarket.com', '$2y$13$VfnOen5Ah1BJZ0ZHijuSJudtyq04k4hwKBS56Oj1F7XKwlWWmu6i.', 'ROLE_ADMIN', '2026-01-15 10:00:00'),
(2, 'Laura Gómez', 'laura@bookmarket.com', '$2y$13$VfnOen5Ah1BJZ0ZHijuSJudtyq04k4hwKBS56Oj1F7XKwlWWmu6i.', 'ROLE_USER', '2026-01-15 10:10:00'),
(3, 'Carlos Ruiz', 'carlos@bookmarket.com', '$2y$13$VfnOen5Ah1BJZ0ZHijuSJudtyq04k4hwKBS56Oj1F7XKwlWWmu6i.', 'ROLE_USER', '2026-01-15 10:20:00'),
(4, 'Marta Pérez', 'marta@bookmarket.com', '$2y$13$VfnOen5Ah1BJZ0ZHijuSJudtyq04k4hwKBS56Oj1F7XKwlWWmu6i.', 'ROLE_USER', '2026-01-15 10:30:00'),
(5, 'Jorge Díaz', 'jorge@bookmarket.com', '$2y$13$VfnOen5Ah1BJZ0ZHijuSJudtyq04k4hwKBS56Oj1F7XKwlWWmu6i.', 'ROLE_USER', '2026-01-15 10:40:00'),
(6, 'Lucía Martín', 'lucia@bookmarket.com', '$2y$13$VfnOen5Ah1BJZ0ZHijuSJudtyq04k4hwKBS56Oj1F7XKwlWWmu6i.', 'ROLE_USER', '2026-01-15 10:50:00'),
(7, 'Pablo Sánchez', 'pablo@bookmarket.com', '$2y$13$VfnOen5Ah1BJZ0ZHijuSJudtyq04k4hwKBS56Oj1F7XKwlWWmu6i.', 'ROLE_USER', '2026-01-15 11:00:00'),
(8, 'Elena Vidal', 'elena@bookmarket.com', '$2y$13$VfnOen5Ah1BJZ0ZHijuSJudtyq04k4hwKBS56Oj1F7XKwlWWmu6i.', 'ROLE_USER', '2026-01-15 11:10:00'),
(9, 'Sergio Navarro', 'sergio@bookmarket.com', '$2y$13$VfnOen5Ah1BJZ0ZHijuSJudtyq04k4hwKBS56Oj1F7XKwlWWmu6i.', 'ROLE_USER', '2026-01-15 11:20:00'),
(10, 'Nuria Álvarez', 'nuria@bookmarket.com', '$2y$13$VfnOen5Ah1BJZ0ZHijuSJudtyq04k4hwKBS56Oj1F7XKwlWWmu6i.', 'ROLE_USER', '2026-01-15 11:30:00');

-- -----------------------------------------------------
-- Categorías
-- -----------------------------------------------------
INSERT INTO `categoria` (`id`, `nombre`, `descripcion`) VALUES
(1, 'Novela', 'Libros de narrativa y ficción.'),
(2, 'Tecnología', 'Programación, sistemas y desarrollo web.'),
(3, 'Historia', 'Libros históricos y ensayos.'),
(4, 'Ciencia', 'Divulgación científica y teoría.'),
(5, 'Economía', 'Finanzas personales y empresa.'),
(6, 'Fantasía', 'Mundos fantásticos y aventuras épicas.'),
(7, 'Infantil', 'Lecturas para niños y jóvenes.'),
(8, 'Psicología', 'Conducta, hábitos y crecimiento personal.'),
(9, 'Arte', 'Diseño, fotografía, pintura y cine.'),
(10, 'Idiomas', 'Gramática, vocabulario y aprendizaje de lenguas.');

-- -----------------------------------------------------
-- Carritos (1 por usuario)
-- -----------------------------------------------------
INSERT INTO `carrito` (`id`, `usuario_id`, `fecha_creacion`, `total`) VALUES
(1, 1, '2026-01-15 10:01:00', 0.00),
(2, 2, '2026-01-15 10:11:00', 41.30),
(3, 3, '2026-01-15 10:21:00', 27.50),
(4, 4, '2026-01-15 10:31:00', 58.70),
(5, 5, '2026-01-15 10:41:00', 0.00),
(6, 6, '2026-01-15 10:51:00', 19.90),
(7, 7, '2026-01-15 11:01:00', 24.00),
(8, 8, '2026-01-15 11:11:00', 36.40),
(9, 9, '2026-01-15 11:21:00', 12.50),
(10, 10, '2026-01-15 11:31:00', 44.80);

-- -----------------------------------------------------
-- Libros
-- -----------------------------------------------------
INSERT INTO `book` (`id`, `categoria_id`, `usuario_id`, `titulo`, `autor`, `descripcion`, `precio`, `estado`, `fecha_publicacion`) VALUES
(1, 2, 2, 'Introducción a Symfony 6', 'Ana Torres', 'Manual práctico para empezar con Symfony.', 22.50, 'Usado - Buen estado', '2026-01-16 09:30:00'),
(2, 1, 3, 'La sombra del viento', 'Carlos Ruiz Zafón', 'Edición bolsillo con leves marcas de uso.', 12.00, 'Usado - Muy buen estado', '2026-01-16 10:15:00'),
(3, 3, 2, 'Historia de Roma', 'Mary Beard', 'Libro con subrayado ligero en algunos capítulos.', 15.00, 'Usado - Estado aceptable', '2026-01-16 11:00:00'),
(4, 2, 4, 'Clean Code', 'Robert C. Martin', 'Clásico de buenas prácticas de programación.', 24.80, 'Usado - Buen estado', '2026-01-17 09:20:00'),
(5, 4, 5, 'Breves respuestas a las grandes preguntas', 'Stephen Hawking', 'Divulgación científica para todos los públicos.', 10.90, 'Usado - Muy buen estado', '2026-01-17 09:45:00'),
(6, 6, 6, 'El nombre del viento', 'Patrick Rothfuss', 'Primera parte de la saga Crónica del Asesino de Reyes.', 14.60, 'Usado - Buen estado', '2026-01-17 10:10:00'),
(7, 7, 7, 'El monstruo de colores', 'Anna Llenas', 'Libro infantil ilustrado sobre emociones.', 8.50, 'Como nuevo', '2026-01-17 10:35:00'),
(8, 5, 8, 'Padre rico, padre pobre', 'Robert T. Kiyosaki', 'Iniciación a educación financiera personal.', 9.70, 'Usado - Buen estado', '2026-01-17 11:00:00'),
(9, 8, 9, 'Hábitos atómicos', 'James Clear', 'Mejora de hábitos y productividad.', 13.20, 'Usado - Muy buen estado', '2026-01-17 11:25:00'),
(10, 9, 10, 'La historia del arte', 'E. H. Gombrich', 'Obra de referencia sobre historia del arte.', 16.40, 'Usado - Estado aceptable', '2026-01-17 11:40:00'),
(11, 10, 2, 'English Grammar in Use', 'Raymond Murphy', 'Gramática inglesa para nivel intermedio.', 18.20, 'Usado - Buen estado', '2026-01-18 09:00:00'),
(12, 1, 3, 'El alquimista', 'Paulo Coelho', 'Novela breve de crecimiento personal.', 7.90, 'Usado - Buen estado', '2026-01-18 09:20:00'),
(13, 1, 4, '1984', 'George Orwell', 'Distopía clásica en castellano.', 11.30, 'Usado - Muy buen estado', '2026-01-18 09:40:00'),
(14, 3, 5, 'Sapiens', 'Yuval Noah Harari', 'Breve historia de la humanidad.', 14.50, 'Usado - Buen estado', '2026-01-18 10:00:00'),
(15, 2, 6, 'JavaScript: The Good Parts', 'Douglas Crockford', 'Buenas prácticas en JavaScript.', 17.00, 'Usado - Estado aceptable', '2026-01-18 10:20:00'),
(16, 2, 7, 'Aprendiendo SQL', 'Alan Beaulieu', 'Fundamentos de bases de datos relacionales.', 19.50, 'Usado - Muy buen estado', '2026-01-18 10:40:00'),
(17, 4, 8, 'Cosmos', 'Carl Sagan', 'Viaje por el universo y la ciencia.', 12.70, 'Usado - Buen estado', '2026-01-18 11:00:00'),
(18, 6, 9, 'Elantris', 'Brandon Sanderson', 'Novela de fantasía autoconclusiva.', 13.60, 'Usado - Buen estado', '2026-01-18 11:20:00'),
(19, 7, 10, 'Matilda', 'Roald Dahl', 'Clásico infantil en tapa blanda.', 6.90, 'Usado - Buen estado', '2026-01-18 11:40:00'),
(20, 8, 2, 'El hombre en busca de sentido', 'Viktor Frankl', 'Psicología existencial y resiliencia.', 11.80, 'Usado - Muy buen estado', '2026-01-18 12:00:00'),
(21, 9, 3, 'Steal Like an Artist', 'Austin Kleon', 'Creatividad para artistas y desarrolladores.', 9.40, 'Usado - Buen estado', '2026-01-19 09:10:00'),
(22, 10, 4, 'Grammaire Progressive du Français', 'Maia Grégoire', 'Gramática francesa por niveles.', 21.30, 'Usado - Buen estado', '2026-01-19 09:30:00'),
(23, 5, 5, 'La psicología del dinero', 'Morgan Housel', 'Comportamiento humano y finanzas.', 12.40, 'Usado - Muy buen estado', '2026-01-19 09:50:00'),
(24, 5, 6, 'El inversor inteligente', 'Benjamin Graham', 'Inversión en valor para largo plazo.', 20.10, 'Usado - Estado aceptable', '2026-01-19 10:10:00'),
(25, 4, 7, 'Una breve historia del tiempo', 'Stephen Hawking', 'Conceptos clave de física moderna.', 11.50, 'Usado - Buen estado', '2026-01-19 10:30:00'),
(26, 3, 8, 'Los mitos griegos', 'Robert Graves', 'Compilación de mitología clásica.', 15.90, 'Usado - Buen estado', '2026-01-19 10:50:00'),
(27, 1, 9, 'Don Quijote de la Mancha', 'Miguel de Cervantes', 'Edición abreviada para lectura ágil.', 13.10, 'Usado - Estado aceptable', '2026-01-19 11:10:00'),
(28, 6, 10, 'El hobbit', 'J. R. R. Tolkien', 'Aventura previa al Señor de los Anillos.', 10.20, 'Usado - Muy buen estado', '2026-01-19 11:30:00'),
(29, 2, 2, 'Docker para desarrolladores', 'Luis Ortega', 'Contenedores para entornos de desarrollo.', 18.80, 'Usado - Buen estado', '2026-01-19 11:50:00'),
(30, 8, 3, 'Pensar rápido, pensar despacio', 'Daniel Kahneman', 'Sesgos cognitivos y toma de decisiones.', 14.20, 'Usado - Buen estado', '2026-01-19 12:10:00');

-- -----------------------------------------------------
-- Relación N:M carrito-libro
-- -----------------------------------------------------
INSERT INTO `carrito_book` (`carrito_id`, `book_id`) VALUES
(2, 2), (2, 8), (2, 20),
(3, 3), (3, 12), (3, 19),
(4, 4), (4, 11), (4, 17),
(6, 5), (6, 7),
(7, 6), (7, 18),
(8, 9), (8, 10), (8, 21),
(9, 25),
(10, 13), (10, 23), (10, 29);

-- -----------------------------------------------------
-- Pedidos
-- -----------------------------------------------------
INSERT INTO `pedido` (`id`, `usuario_id`, `fecha`, `total`, `estado`) VALUES
(1, 2, '2026-01-20 12:00:00', 41.30, 'Pendiente'),
(2, 3, '2026-01-20 12:15:00', 27.50, 'Confirmado'),
(3, 4, '2026-01-20 12:30:00', 58.70, 'Pendiente'),
(4, 6, '2026-01-20 12:45:00', 19.90, 'Confirmado'),
(5, 8, '2026-01-20 13:00:00', 36.40, 'Enviado'),
(6, 10, '2026-01-20 13:15:00', 44.80, 'Pendiente');

-- -----------------------------------------------------
-- Mensajes
-- -----------------------------------------------------
INSERT INTO `mensaje` (`id`, `contenido`, `fecha`) VALUES
(1, 'Bienvenido/a a BookMarket. Ya puedes publicar tu primer libro.', '2026-01-15 10:30:00'),
(2, 'Recuerda revisar el estado del libro antes de confirmar un pedido.', '2026-01-15 10:45:00'),
(3, 'Hemos añadido nuevas categorías para organizar mejor el catálogo.', '2026-01-16 09:00:00'),
(4, 'Consejo: incluye una descripción clara para vender más rápido.', '2026-01-16 14:00:00'),
(5, 'Tu pedido ha cambiado de estado. Revisa la sección de pedidos.', '2026-01-17 18:30:00'),
(6, 'BookMarket: mantenimiento programado el domingo a las 02:00.', '2026-01-18 20:15:00');

-- =====================================================
-- Fin del archivo de datos para MariaDB
-- =====================================================
