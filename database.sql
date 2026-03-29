-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 29/03/2026 às 16:45
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `hubsong_db`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `song_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `song_id` int(11) NOT NULL,
  `reviewer_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `review_scores`
--

CREATE TABLE `review_scores` (
  `id` int(11) NOT NULL,
  `review_id` int(11) NOT NULL,
  `factor` enum('composicao','letra','producao','arranjo','performance','engajamento','potencial') NOT NULL,
  `score` int(11) NOT NULL CHECK (`score` between 1 and 10),
  `comment` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `songs`
--

CREATE TABLE `songs` (
  `id` int(11) NOT NULL,
  `artist_id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `songs`
--

INSERT INTO `songs` (`id`, `artist_id`, `title`, `filename`, `description`, `uploaded_at`) VALUES
(14, 1, 'The wind', 'song_6953c3267a86d.mp3', 'Música Gospel gerada por Inteligência Artificial', '2025-12-30 12:18:46'),
(15, 1, 'Across the Oceans', 'song_6953c3b4beddc.mp3', 'Música em inglês gerada a partir de IA', '2025-12-30 12:21:08');

-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('artist','listener') DEFAULT 'listener',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `avatar` varchar(255) DEFAULT 'default.png',
  `karma` int(11) DEFAULT 0,
  `google_id` varchar(255) DEFAULT NULL,
  `provider` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`, `avatar`, `karma`, `google_id`, `provider`) VALUES
(1, 'Matheus', 'Itsbalog.mb@gmail.com', '$2y$10$5D2yW4UTVDncR/7DxJlpruZZysla77j6kEzfZv7pnOcJfBnULs7ae', 'artist', '2025-12-16 16:04:55', 'default.png', 0, NULL, NULL),
(2, 'MATHEUS 2', 'itsbalog.sat@gmail.com', '$2y$10$WLZc18rNEV7PwRdFymo//u0vxtG5jMYlfFjPEGs16TDadFiv0spBW', 'listener', '2025-12-16 16:33:49', 'default.png', 0, NULL, NULL),
(3, 'Andréia', 'andreia.balog@gmail.com', '$2y$10$yry5.PkwywEpgAWmm.3zluVnPn4/BbtbiqDSnkOcXxWL8EKvFWlyq', 'artist', '2025-12-17 13:00:00', 'default.png', 0, NULL, NULL),
(5, 'wFSAV', 'andreiabalog@gmail.com', '$2y$10$lP.vfNYwZxi2URH2mMdzN.nrd25idEPepxOhynW3kEv6enWSsxPKa', 'artist', '2025-12-17 13:06:43', 'avatar_6942aae340974.jpeg', 0, NULL, NULL),
(6, 'Ladybug', 'itsbalog@gmail.com', '$2y$10$5rpJCSQgEJn2wT6ZrumLIOkt2T7Vx39xtdxCsayGmvIdjeNkvvSl.', 'artist', '2025-12-30 11:44:13', 'avatar_6953bb0d5ace7.jpeg', 1, NULL, NULL),
(7, 'Artista', 'artista@email.com', '$2y$10$NuAwkYPpJfkAMCvl1oLUK./6vTcKjosAL3EYAzcU1OSXaPZgT69Ey', 'artist', '2025-12-30 20:14:39', 'default.png', 0, NULL, NULL),
(8, 'Artista', 'artista@artista.com', '$2y$10$mjb3oAgZNxSGfphsIEPeWucEG7YQnuXE9MvWQfL84DKmje7QMANdK', 'artist', '2025-12-31 18:01:38', 'default.png', 0, NULL, NULL),
(9, 'Thiago Whyte', 'thiwhyte2@gmail.com', '$2y$10$D8PskdMdKy0o7GKd/nydL.bxiDEsgaNafyNNVIp57c12FjBOTztcC', 'artist', '2026-01-08 02:17:37', 'default.png', 0, NULL, NULL),
(14, 'Matheus Gomes Pereira Balog', '12345@email.com', '$2y$10$t3XwIW1fikvR0ruep0TA9uq2ZMsaGwAMwMQSFMNKc6x745BZG1JR2', 'artist', '2026-01-27 20:52:42', 'default.png', 0, NULL, NULL),
(15, 'yondaimeb4@gmail.com', 'yondaimeb4@gmail.com', '$2y$10$8yz7ITRj.rN0BAt9PUKskuzEVNnqQ4Be/So4MiQ7WGgK4M9Nr4XEy', 'artist', '2026-02-01 22:02:17', 'avatar_697fcd6930cb7.jpg', 0, NULL, NULL),
(16, 'Breno Arantes', 'brenooliveira.p.arantes@gmail.com', '$2y$10$APF2FVjAwmbxj0Wn1ZnTW.glv3NwzeP36X1jVv1mxjz7wB0rtbAwG', 'artist', '2026-02-02 15:12:29', 'avatar_6980bedd6bfbd.jpg', 0, NULL, NULL),
(17, 'EDUARDO BALOG', 'gomesbalog@gmail.com', '', 'listener', '2026-02-18 15:09:14', 'avatar_6995d61a41199.jpg', 0, '109262738911732317571', 'google'),
(19, 'Kauangomes', 'kauangomesbalog@gmail.com', '', 'artist', '2026-02-18 15:18:20', 'avatar_6995d83c91d97.jpg', 0, '113326439317677660432', 'google'),
(20, 'Matheus Balog', 'balog.servicos@gmail.com', '', 'artist', '2026-02-18 15:25:31', 'avatar_6995d9eb04127.jpg', 0, '110311008866573381024', 'google'),
(21, 'Pedro Nicastro', 'pedro.bedeschi.nicastro@gmail.com', '', 'artist', '2026-02-18 16:43:28', 'avatar_6995ec2fab614.jpg', 0, '103478387718591988807', 'google'),
(24, 'balog Matheus', 'balog.edicaodevideos@gmail.com', '', 'artist', '2026-03-02 23:10:21', 'avatar_69a618dd68444.jpg', 0, '100959306070420831318', 'google');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `song_id` (`song_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Índices de tabela `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `song_id` (`song_id`,`reviewer_id`),
  ADD KEY `reviewer_id` (`reviewer_id`);

--
-- Índices de tabela `review_scores`
--
ALTER TABLE `review_scores`
  ADD PRIMARY KEY (`id`),
  ADD KEY `review_id` (`review_id`);

--
-- Índices de tabela `songs`
--
ALTER TABLE `songs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `artist_id` (`artist_id`);

--
-- Índices de tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `review_scores`
--
ALTER TABLE `review_scores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT de tabela `songs`
--
ALTER TABLE `songs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`song_id`) REFERENCES `songs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`song_id`) REFERENCES `songs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`reviewer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `review_scores`
--
ALTER TABLE `review_scores`
  ADD CONSTRAINT `review_scores_ibfk_1` FOREIGN KEY (`review_id`) REFERENCES `reviews` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `songs`
--
ALTER TABLE `songs`
  ADD CONSTRAINT `songs_ibfk_1` FOREIGN KEY (`artist_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
