-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Client :  localhost:8889
-- Généré le :  Ven 07 Octobre 2016 à 16:58
-- Version du serveur :  5.6.28
-- Version de PHP :  7.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données :  `cloud`
--

-- --------------------------------------------------------

--
-- Structure de la table `files`
--

CREATE TABLE `files` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `folder` text COLLATE utf8_unicode_ci NOT NULL,
  `file` text COLLATE utf8_unicode_ci NOT NULL,
  `type` text COLLATE utf8_unicode_ci NOT NULL,
  `taille` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `files`
--

INSERT INTO `files` (`id`, `user_id`, `folder`, `file`, `type`, `taille`, `created_at`, `updated_at`) VALUES
(6, 1, 'default', '72926.jpg', 'jpg', 94788, '2016-10-07 11:42:26', '2016-10-07 11:42:26'),
(7, 1, 'default', '56989.mp3', 'mp3', 1670127, '2016-10-07 12:33:29', '2016-10-07 12:33:29'),
(8, 1, 'default', '35034.mp4', 'mp4', 1977976, '2016-10-07 12:46:05', '2016-10-07 12:46:05'),
(9, 1, 'default', '96109.html', 'html', 35560, '2016-10-07 12:50:56', '2016-10-07 12:50:56');

-- --------------------------------------------------------

--
-- Structure de la table `migrations`
--

CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2014_10_12_000000_create_users_table', 1),
('2014_10_12_100000_create_password_resets_table', 1),
('2016_10_03_085804_create_files_table', 1),
('2016_10_04_140454_create_share_table', 1);

-- --------------------------------------------------------

--
-- Structure de la table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `share`
--

CREATE TABLE `share` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `user_share` int(10) UNSIGNED NOT NULL,
  `folder` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `firstname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `birthdate` date NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `taille` int(11) NOT NULL DEFAULT '0',
  `admin` int(11) NOT NULL DEFAULT '1',
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `username`, `firstname`, `lastname`, `email`, `birthdate`, `password`, `taille`, `admin`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'DiokzZ', 'paul', 'roos', 'paul.roos@hotmail.fr', '1997-05-20', '$2y$10$LacYTHBf.KTbjCKIXMubxuMXBpSceCE/3AuAb.B/U4EYNxETd9iE2', 3778451, 2, 'TxBYnyyMpOCgS7U5TwRVR8csfNXKVxTWKIN8QCMNr1aT8KbquBsVyjog2kvt', '2016-10-07 06:04:43', '2016-10-07 12:54:11'),
(2, 'swagmaster', 'paul', 'roos', 'paul.roos@epitech.eu', '1997-05-20', '$2y$10$qiljoOxV6bTw9BsJNMs41.ubtI8D8MTazwSqs9IA9V408n4IacEo6', 0, 1, 'FACB2ErDhB0rAcAUK6Z3FVQ0BvQDVIDalYQ9jNfFO6EGZzAHgJEUtiDB1OHK', '2016-10-07 12:27:12', '2016-10-07 12:33:07'),
(9, 'test', 'paul', 'roos', 'swqswq@sqsqw.fr', '1997-05-20', '$2y$10$1DCQur.Nt6vlAqTvKZKGyOjsKNsyZL.aUA2yCRkSqobdqW9o/wGs2', 0, 2, '82XfMDu6CMVW5t3S9J6dC60EYYsQ0oJ47Eky9WmsHVDrDnNJpgv3hYDfPMh9', '2016-10-07 12:51:21', '2016-10-07 12:53:17');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `files_user_id_foreign` (`user_id`);

--
-- Index pour la table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`),
  ADD KEY `password_resets_token_index` (`token`);

--
-- Index pour la table `share`
--
ALTER TABLE `share`
  ADD PRIMARY KEY (`id`),
  ADD KEY `share_user_id_foreign` (`user_id`),
  ADD KEY `share_user_share_foreign` (`user_share`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `files`
--
ALTER TABLE `files`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT pour la table `share`
--
ALTER TABLE `share`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `files`
--
ALTER TABLE `files`
  ADD CONSTRAINT `files_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `share`
--
ALTER TABLE `share`
  ADD CONSTRAINT `share_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `share_user_share_foreign` FOREIGN KEY (`user_share`) REFERENCES `users` (`id`);

