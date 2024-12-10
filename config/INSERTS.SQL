-- Arrancan los inserts
INSERT INTO Categoria (Categoria, Color) VALUES ('Arte', 'Naranja');
INSERT INTO Categoria (Categoria, Color) VALUES ('Cine', 'Morado');
INSERT INTO Categoria (Categoria, Color) VALUES ('Deporte', 'Rojo');
INSERT INTO Categoria (Categoria, Color) VALUES ('Historia', 'Amarillo');
INSERT INTO Categoria (Categoria, Color) VALUES ('Ciencia', 'Verde');
INSERT INTO Categoria (Categoria, Color) VALUES ('Geografía', 'Azul');

-- Preguntas de Arte
INSERT INTO Pregunta (Pregunta, Dificultad, Categoria_id) VALUES ('¿Quién pintó "La noche estrellada"?', 1, 1);
INSERT INTO Pregunta (Pregunta, Dificultad, Categoria_id) VALUES ('¿Cuál de estos artistas es conocido por sus "móviles"?', 2, 1);
INSERT INTO Pregunta (Pregunta, Dificultad, Categoria_id) VALUES ('¿En qué siglo nació Leonardo da Vinci?', 1, 1);
INSERT INTO Pregunta (Pregunta, Dificultad, Categoria_id) VALUES ('¿Quién pintó "Guernica"?', 1, 1);
INSERT INTO Pregunta (Pregunta, Dificultad, Categoria_id) VALUES ('¿Cuál de estos no es un color primario en pintura?', 1, 1);
INSERT INTO Pregunta (Pregunta, Dificultad, Categoria_id) VALUES ('¿Qué artista es famoso por sus latas de sopa Campbell?', 1, 1);
INSERT INTO Pregunta (Pregunta, Dificultad, Categoria_id) VALUES ('¿Qué movimiento artístico fundó Piet Mondrian?', 2, 1);
INSERT INTO Pregunta (Pregunta, Dificultad, Categoria_id) VALUES ('¿Quién esculpió "El Pensador"?', 2, 1);
INSERT INTO Pregunta (Pregunta, Dificultad, Categoria_id) VALUES ('¿En qué ciudad italiana se encuentra "La Última Cena" de Leonardo da Vinci?', 3, 1);
INSERT INTO Pregunta (Pregunta, Dificultad, Categoria_id) VALUES ('¿Qué artista cortó parte de su propia oreja?', 3, 1);

-- Respuestas de Arte
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Vincent van Gogh', TRUE, 1);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Pablo Picasso', FALSE, 1);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Claude Monet', FALSE, 1);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Salvador Dalí', FALSE, 1);

INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Alexander Calder', TRUE, 2);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Jackson Pollock', FALSE, 2);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Andy Warhol', FALSE, 2);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Mark Rothko', FALSE, 2);

INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Siglo XV', TRUE, 3);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Siglo XIV', FALSE, 3);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Siglo XVI', FALSE, 3);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Siglo XVII', FALSE, 3);

INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Pablo Picasso', TRUE, 4);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Salvador Dalí', FALSE, 4);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Joan Miró', FALSE, 4);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Francisco Goya', FALSE, 4);

INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Verde', TRUE, 5);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Rojo', FALSE, 5);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Azul', FALSE, 5);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Amarillo', FALSE, 5);

INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Andy Warhol', TRUE, 6);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Roy Lichtenstein', FALSE, 6);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Keith Haring', FALSE, 6);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Jean-Michel Basquiat', FALSE, 6);

INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Neoplasticismo', TRUE, 7);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Cubismo', FALSE, 7);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Surrealismo', FALSE, 7);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Expresionismo', FALSE, 7);

INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Auguste Rodin', TRUE, 8);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Michelangelo', FALSE, 8);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Donatello', FALSE, 8);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Bernini', FALSE, 8);

INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Milán', TRUE, 9);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Roma', FALSE, 9);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Florencia', FALSE, 9);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Venecia', FALSE, 9);

INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Vincent van Gogh', TRUE, 10);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Paul Gauguin', FALSE, 10);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Édouard Manet', FALSE, 10);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Claude Monet', FALSE, 10);

-- Preguntas de Cine
INSERT INTO Pregunta (Pregunta, Dificultad, Categoria_id) VALUES ('¿Quién dirigió la película "Pulp Fiction"?', 1, 2);
INSERT INTO Pregunta (Pregunta, Dificultad, Categoria_id) VALUES ('¿En qué año se estrenó la primera película de "Star Wars"?', 1, 2);
INSERT INTO Pregunta (Pregunta, Dificultad, Categoria_id) VALUES ('¿Qué actor interpretó a Tony Stark/Iron Man en el Universo Cinematográfico de Marvel?', 1, 2);
INSERT INTO Pregunta (Pregunta, Dificultad, Categoria_id) VALUES ('¿Cuál de estas películas ganó el Oscar a Mejor Película en 2020?', 1, 2);
INSERT INTO Pregunta (Pregunta, Dificultad, Categoria_id) VALUES ('¿Quién dirigió "El Padrino"?', 1, 2);
INSERT INTO Pregunta (Pregunta, Dificultad, Categoria_id) VALUES ('¿En qué película aparece la frase "Hasta la vista, baby"?', 1, 2);
INSERT INTO Pregunta (Pregunta, Dificultad, Categoria_id) VALUES ('¿Qué actor interpretó a Jack Dawson en "Titanic"?', 2, 2);
INSERT INTO Pregunta (Pregunta, Dificultad, Categoria_id) VALUES ('¿Cuál fue la primera película de Pixar?', 2, 2);
INSERT INTO Pregunta (Pregunta, Dificultad, Categoria_id) VALUES ('¿Quién dirigió la trilogía de "El Señor de los Anillos"?', 3, 2);
INSERT INTO Pregunta (Pregunta, Dificultad, Categoria_id) VALUES ('¿En qué año se estrenó "Ciudadano Kane" de Orson Welles?', 3, 2);

-- Respuestas de Cine
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Quentin Tarantino', TRUE, 11);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Martin Scorsese', FALSE, 11);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Steven Spielberg', FALSE, 11);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Christopher Nolan', FALSE, 11);

INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('1977', TRUE, 12);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('1980', FALSE, 12);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('1975', FALSE, 12);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('1979', FALSE, 12);

INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Robert Downey Jr.', TRUE, 13);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Chris Evans', FALSE, 13);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Chris Hemsworth', FALSE, 13);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Mark Ruffalo', FALSE, 13);

INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Parásitos', TRUE, 14);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('1917', FALSE, 14);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Joker', FALSE, 14);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Érase una vez en... Hollywood', FALSE, 14);

INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Francis Ford Coppola', TRUE, 15);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Martin Scorsese', FALSE, 15);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Steven Spielberg', FALSE, 15);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Alfred Hitchcock', FALSE, 15);

INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Terminator 2: El juicio final', TRUE, 16);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Terminator', FALSE, 16);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Depredador', FALSE, 16);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Comando', FALSE, 16);

INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Leonardo DiCaprio', TRUE, 17);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Brad Pitt', FALSE, 17);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Matt Damon', FALSE, 17);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Johnny Depp', FALSE, 17);

INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Toy Story', TRUE, 18);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Bichos', FALSE, 18);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Monsters, Inc.', FALSE, 18);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Buscando a Nemo', FALSE, 18);

INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Peter Jackson', TRUE, 19);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Christopher Nolan', FALSE, 19);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('James Cameron', FALSE, 19);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('George Lucas', FALSE, 19);

INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('1941', TRUE, 20);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('1939', FALSE, 20);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('1945', FALSE, 20);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('1950', FALSE, 20);

-- Preguntas de Deportes
INSERT INTO Pregunta (Pregunta, Dificultad, Categoria_id) VALUES ('¿En qué deporte se utiliza un disco?', 1, 3);
INSERT INTO Pregunta (Pregunta, Dificultad, Categoria_id) VALUES ('¿Cuántos jugadores tiene un equipo de fútbol en el campo?', 1, 3);
INSERT INTO Pregunta (Pregunta, Dificultad, Categoria_id) VALUES ('¿En qué deporte se usa el término "smash"?', 1, 3);
INSERT INTO Pregunta (Pregunta, Dificultad, Categoria_id) VALUES ('¿Cuál es el país de origen del sumo?', 1, 3);
INSERT INTO Pregunta (Pregunta, Dificultad, Categoria_id) VALUES ('¿En qué deporte se compite por la Copa Stanley?', 1, 3);
INSERT INTO Pregunta (Pregunta, Dificultad, Categoria_id) VALUES ('¿Cuántos puntos vale un touchdown en fútbol americano?', 1, 3);
INSERT INTO Pregunta (Pregunta, Dificultad, Categoria_id) VALUES ('¿Quién es considerado el mejor jugador de baloncesto de todos los tiempos?', 2, 3);
INSERT INTO Pregunta (Pregunta, Dificultad, Categoria_id) VALUES ('¿En qué año se celebraron los primeros Juegos Olímpicos modernos?', 2, 3);
INSERT INTO Pregunta (Pregunta, Dificultad, Categoria_id) VALUES ('¿Cuál es el récord mundial de los 100 metros lisos masculinos?', 3, 3);
INSERT INTO Pregunta (Pregunta, Dificultad, Categoria_id) VALUES ('¿Quién ganó el Mundial de Fútbol de 2022?', 3, 3);

-- Respuestas de Deportes
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Hockey', TRUE, 21);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Baloncesto', FALSE, 21);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Fútbol', FALSE, 21);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Tenis', FALSE, 21);

INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('11', TRUE, 22);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('10', FALSE, 22);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('9', FALSE, 22);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('12', FALSE, 22);

INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Bádminton', TRUE, 23);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Tenis', FALSE, 23);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Voleibol', FALSE, 23);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Squash', FALSE, 23);

INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Japón', TRUE, 24);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('China', FALSE, 24);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Corea del Sur', FALSE, 24);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Mongolia', FALSE, 24);

INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Hockey sobre hielo', TRUE, 25);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Fútbol', FALSE, 25);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Baloncesto', FALSE, 25);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Béisbol', FALSE, 25);

INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('6', TRUE, 26);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('7', FALSE, 26);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('5', FALSE, 26);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('4', FALSE, 26);

INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Michael Jordan', TRUE, 27);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('LeBron James', FALSE, 27);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Kobe Bryant', FALSE, 27);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Magic Johnson', FALSE, 27);

INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('1896', TRUE, 28);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('1900', FALSE, 28);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('1904', FALSE, 28);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('1892', FALSE, 28);

INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('9.58 segundos', TRUE, 29);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('9.63 segundos', FALSE, 29);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('9.69 segundos', FALSE, 29);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('9.74 segundos', FALSE, 29);

INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Argentina', TRUE, 30);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Francia', FALSE, 30);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Brasil', FALSE, 30);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Alemania', FALSE, 30);

-- Preguntas de Historia
INSERT INTO Pregunta (Pregunta, Dificultad, Categoria_id) VALUES ('¿En qué año comenzó la Primera Guerra Mundial?', 1, 4);
INSERT INTO Pregunta (Pregunta, Dificultad, Categoria_id) VALUES ('¿Quién fue el primer presidente de Estados Unidos?', 1, 4);
INSERT INTO Pregunta (Pregunta, Dificultad, Categoria_id) VALUES ('¿En qué año cayó el Muro de Berlín?', 1, 4);
INSERT INTO Pregunta (Pregunta, Dificultad, Categoria_id) VALUES ('¿Quién fue Julio César?', 1, 4);
INSERT INTO Pregunta (Pregunta, Dificultad, Categoria_id) VALUES ('¿En qué año se produjo la Revolución Francesa?', 1, 4);
INSERT INTO Pregunta (Pregunta, Dificultad, Categoria_id) VALUES ('¿Quién pintó la Mona Lisa?', 1, 4);
INSERT INTO Pregunta (Pregunta, Dificultad, Categoria_id) VALUES ('¿Cuál fue la capital del Imperio Inca?', 2, 4);
INSERT INTO Pregunta (Pregunta, Dificultad, Categoria_id) VALUES ('¿En qué año se firmó la Declaración de Independencia de Estados Unidos?', 2, 4);
INSERT INTO Pregunta (Pregunta, Dificultad, Categoria_id) VALUES ('¿Quién fue el último zar de Rusia?', 3, 4);
INSERT INTO Pregunta (Pregunta, Dificultad, Categoria_id) VALUES ('¿En qué año se produjo la caída de Constantinopla?', 3, 4);

-- Respuestas de Historia
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('1914', TRUE, 31);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('1918', FALSE, 31);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('1939', FALSE, 31);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('1945', FALSE, 31);

INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('George Washington', TRUE, 32);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Thomas Jefferson', FALSE, 32);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Abraham Lincoln', FALSE, 32);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('John Adams', FALSE, 32);

INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('1989', TRUE, 33);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('1991', FALSE, 33);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('1987', FALSE, 33);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('1990', FALSE, 33);

INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Un emperador romano', TRUE, 34);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Un filósofo griego', FALSE, 34);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Un rey egipcio', FALSE, 34);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Un general cartaginés', FALSE, 34);

INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('1789', TRUE, 35);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('1799', FALSE, 35);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('1769', FALSE, 35);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('1809', FALSE, 35);

INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Leonardo da Vinci', TRUE, 36);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Miguel Ángel', FALSE, 36);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Rafael', FALSE, 36);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Donatello', FALSE, 36);

INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Cuzco', TRUE, 37);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Machu Picchu', FALSE, 37);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Lima', FALSE, 37);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Quito', FALSE, 37);

INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('1776', TRUE, 38);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('1789', FALSE, 38);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('1783', FALSE, 38);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('1770', FALSE, 38);

INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Nicolás II', TRUE, 39);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Alejandro III', FALSE, 39);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Pedro el Grande', FALSE, 39);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Iván el Terrible', FALSE, 39);

INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('1453', TRUE, 40);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('1492', FALSE, 40);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('1204', FALSE, 40);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('1517', FALSE, 40);

-- Preguntas de Ciencia
INSERT INTO Pregunta (Pregunta, Dificultad, Categoria_id) VALUES ('¿Cuál es el elemento químico más abundante en el universo?', 1, 5);
INSERT INTO Pregunta (Pregunta, Dificultad, Categoria_id) VALUES ('¿Cuál es la fórmula química del agua?', 1, 5);
INSERT INTO Pregunta (Pregunta, Dificultad, Categoria_id) VALUES ('¿Qué planeta es conocido como el planeta rojo?', 1, 5);
INSERT INTO Pregunta (Pregunta, Dificultad, Categoria_id) VALUES ('¿Cuál es la unidad básica de la herencia?', 1, 5);
INSERT INTO Pregunta (Pregunta, Dificultad, Categoria_id) VALUES ('¿Qué tipo de radiación emite el sol?', 1, 5);
INSERT INTO Pregunta (Pregunta, Dificultad, Categoria_id) VALUES ('¿Cuál es el hueso más largo del cuerpo humano?', 1, 5);
INSERT INTO Pregunta (Pregunta, Dificultad, Categoria_id) VALUES ('¿Qué científico propuso la teoría de la relatividad?', 2, 5);
INSERT INTO Pregunta (Pregunta, Dificultad, Categoria_id) VALUES ('¿Cuál es la partícula subatómica con carga positiva?', 2, 5);
INSERT INTO Pregunta (Pregunta, Dificultad, Categoria_id) VALUES ('¿Qué es un agujero negro?', 3, 5);
INSERT INTO Pregunta (Pregunta, Dificultad, Categoria_id) VALUES ('¿Qué es la fusión nuclear?', 3, 5);

-- Respuestas de Ciencia
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Hidrógeno', TRUE, 41);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Helio', FALSE, 41);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Oxígeno', FALSE, 41);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Carbono', FALSE, 41);

INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('H2O', TRUE, 42);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('CO2', FALSE, 42);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('NaCl', FALSE, 42);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('CH4', FALSE, 42);

INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Marte', TRUE, 43);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Venus', FALSE, 43);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Júpiter', FALSE, 43);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Saturno', FALSE, 43);

INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Gen', TRUE, 44);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Célula', FALSE, 44);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Cromosoma', FALSE, 44);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('ADN', FALSE, 44);

INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Electromagnética', TRUE, 45);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Gamma', FALSE, 45);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Alfa', FALSE, 45);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Beta', FALSE, 45);

INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Fémur', TRUE, 46);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Tibia', FALSE, 46);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Húmero', FALSE, 46);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Columna vertebral', FALSE, 46);

INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Albert Einstein', TRUE, 47);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Isaac Newton', FALSE, 47);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Stephen Hawking', FALSE, 47);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Niels Bohr', FALSE, 47);

INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Protón', TRUE, 48);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Electrón', FALSE, 48);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Neutrón', FALSE, 48);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Fotón', FALSE, 48);

INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Una región del espacio con gravedad tan intensa que nada puede escapar de ella', TRUE, 49);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Un tipo de estrella muy brillante', FALSE, 49);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Un planeta sin luz', FALSE, 49);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Un túnel en el espacio-tiempo', FALSE, 49);

INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('La unión de núcleos atómicos ligeros para formar núcleos más pesados', TRUE, 50);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('La división de núcleos atómicos pesados', FALSE, 50);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('La combinación de átomos para formar moléculas', FALSE, 50);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('La desintegración de partículas subatómicas', FALSE, 50);

-- Preguntas de Geografía
INSERT INTO Pregunta (Pregunta, Dificultad, Categoria_id) VALUES ('¿Cuál es el río más largo del mundo?', 1, 6);
INSERT INTO Pregunta (Pregunta, Dificultad, Categoria_id) VALUES ('¿Cuál es el país más grande del mundo por área terrestre?', 1, 6);
INSERT INTO Pregunta (Pregunta, Dificultad, Categoria_id) VALUES ('¿En qué continente se encuentra Egipto?', 1, 6);
INSERT INTO Pregunta (Pregunta, Dificultad, Categoria_id) VALUES ('¿Cuál es la capital de Australia?', 1, 6);
INSERT INTO Pregunta (Pregunta, Dificultad, Categoria_id) VALUES ('¿Qué océano se encuentra entre América y Europa?', 1, 6);
INSERT INTO Pregunta (Pregunta, Dificultad, Categoria_id) VALUES ('¿Cuál es el desierto más grande del mundo?', 1, 6);
INSERT INTO Pregunta (Pregunta, Dificultad, Categoria_id) VALUES ('¿Cuál es el punto más alto de la Tierra?', 2, 6);
INSERT INTO Pregunta (Pregunta, Dificultad, Categoria_id) VALUES ('¿En qué país se encuentra el lago Titicaca?', 2, 6);
INSERT INTO Pregunta (Pregunta, Dificultad, Categoria_id) VALUES ('¿Cuál es el país con más islas en el mundo?', 3, 6);
INSERT INTO Pregunta (Pregunta, Dificultad, Categoria_id) VALUES ('¿Qué país es el único que se encuentra en los cuatro hemisferios?', 3, 6);

-- Respuestas de Geografía
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Amazonas', TRUE, 51);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Nilo', FALSE, 51);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Yangtsé', FALSE, 51);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Misisipi', FALSE, 51);

INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Rusia', TRUE, 52);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Canadá', FALSE, 52);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('China', FALSE, 52);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Estados Unidos', FALSE, 52);

INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('África', TRUE, 53);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Asia', FALSE, 53);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Europa', FALSE, 53);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Medio Oriente', FALSE, 53);

INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Canberra', TRUE, 54);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Sídney', FALSE, 54);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Melbourne', FALSE, 54);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Brisbane', FALSE, 54);

INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Océano Atlántico', TRUE, 55);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Océano Pacífico', FALSE, 55);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Océano Índico', FALSE, 55);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Océano Ártico', FALSE, 55);

INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Sáhara', TRUE, 56);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Gobi', FALSE, 56);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Atacama', FALSE, 56);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Kalahari', FALSE, 56);

INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Monte Everest', TRUE, 57);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('K2', FALSE, 57);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Kangchenjunga', FALSE, 57);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Lhotse', FALSE, 57);

INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Perú y Bolivia', TRUE, 58);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Argentina y Chile', FALSE, 58);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Ecuador y Colombia', FALSE, 58);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Brasil y Paraguay', FALSE, 58);

INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Suecia', TRUE, 59);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Indonesia', FALSE, 59);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Filipinas', FALSE, 59);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Grecia', FALSE, 59);

INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Kiribati', TRUE, 60);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Ecuador', FALSE, 60);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Indonesia', FALSE, 60);
INSERT INTO Respuesta (Texto_respuesta, Es_correcta, Pregunta_id) VALUES ('Reino Unido', FALSE, 60);

-- Crear tres usuarios
INSERT INTO Usuario (nombre, nombre_usuario, contrasenia, fecha_nacimiento, pais, sexo, ciudad, email, Path_img_perfil, activo, token, latitudMapa, longitudMapa, rol)
VALUES
    ('admin', 'admin', '$2y$10$SarjfMTLpHKo3qAOOdn4Q.WlXRI5uXZSGw5OuF2YMg6FbEqtTI0f2', '1968-08-12', 'Argentina', 'masculino', 'Buenos Aires', 'estevezgaston01@gmail.com', 'admin.jpg', 1, NULL, NULL, NULL, 3),
    ('editor', 'editor', '$2y$10$Yl8F0Hz6XESgaRqFiwzHX.fH2V.d5JU8VkL8/plaPlFSKFcDIcBE2', '1970-04-22', 'Argentina', 'femenino', 'Buenos Aires', 'estevezgaston01@gmail.com', 'editor.jpg', 1, NULL, NULL, NULL, 2);