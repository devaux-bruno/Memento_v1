-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  jeu. 03 oct. 2019 à 14:20
-- Version du serveur :  10.1.37-MariaDB
-- Version de PHP :  7.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `memento`
--

-- --------------------------------------------------------

--
-- Structure de la table `articles`
--

CREATE TABLE `articles` (
  `article_id` int(11) NOT NULL,
  `article_user_id` int(11) NOT NULL,
  `article_language_id` int(11) NOT NULL,
  `article_valid` varchar(60) NOT NULL,
  `article_picture` varchar(255) DEFAULT NULL,
  `article_description` text NOT NULL,
  `article_text` int(11) NOT NULL,
  `article_create_at` int(11) NOT NULL,
  `article_title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(11) NOT NULL,
  `comment_user_id` int(11) NOT NULL,
  `comment_article_id` int(11) NOT NULL,
  `comment_text` longtext NOT NULL,
  `comment_status` varchar(60) NOT NULL,
  `comment_created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `languages`
--

CREATE TABLE `languages` (
  `lang_id` int(11) NOT NULL,
  `lang_program` varchar(60) NOT NULL,
  `lang_created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `likesystem`
--

CREATE TABLE `likesystem` (
  `like_id` int(11) NOT NULL,
  `like_user_id` int(11) NOT NULL,
  `like_article_id` int(11) NOT NULL,
  `like_note` varchar(60) NOT NULL,
  `like_created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_pseudo` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_firstname` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_lastname` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_email` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_registration` datetime NOT NULL,
  `user_job` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_birthday` date NOT NULL,
  `user_city` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_status` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_picture` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_description` longtext COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`article_id`),
  ADD KEY `article_user_id` (`article_user_id`),
  ADD KEY `article_language_id` (`article_language_id`);

--
-- Index pour la table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `comment_user_id` (`comment_user_id`),
  ADD KEY `comment_user_article` (`comment_article_id`);

--
-- Index pour la table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`lang_id`);

--
-- Index pour la table `likesystem`
--
ALTER TABLE `likesystem`
  ADD PRIMARY KEY (`like_id`),
  ADD KEY `like_user_id` (`like_user_id`),
  ADD KEY `like_article_id` (`like_article_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `memento_pseudo` (`user_pseudo`),
  ADD UNIQUE KEY `memento_email` (`user_email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `articles`
--
ALTER TABLE `articles`
  MODIFY `article_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `languages`
--
ALTER TABLE `languages`
  MODIFY `lang_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `likesystem`
--
ALTER TABLE `likesystem`
  MODIFY `like_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `articles_ibfk_1` FOREIGN KEY (`article_user_id`) REFERENCES `users` (`user_id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `articles_ibfk_2` FOREIGN KEY (`article_language_id`) REFERENCES `languages` (`lang_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`comment_user_id`) REFERENCES `users` (`user_id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`comment_article_id`) REFERENCES `articles` (`article_id`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Contraintes pour la table `likesystem`
--
ALTER TABLE `likesystem`
  ADD CONSTRAINT `likesystem_ibfk_1` FOREIGN KEY (`like_user_id`) REFERENCES `users` (`user_id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `likesystem_ibfk_2` FOREIGN KEY (`like_article_id`) REFERENCES `articles` (`article_id`) ON DELETE NO ACTION ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
