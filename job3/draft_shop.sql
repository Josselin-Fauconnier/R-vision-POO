-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : jeu. 09 oct. 2025 à 11:55
-- Version du serveur : 8.4.3
-- Version de PHP : 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `draft_shop`
--

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

CREATE TABLE `category` (
  `idCategory` int NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `createdAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `category`
--

INSERT INTO `category` (`idCategory`, `name`, `description`, `createdAt`, `updatedAt`) VALUES
(1, 'Vêtements', 'Tous les types de vêtements', '2025-10-06 14:33:53', '2025-10-06 14:33:53'),
(2, 'Électronique', 'Smartphones, ordinateurs, gadgets', '2025-10-06 14:33:53', '2025-10-06 14:33:53'),
(3, 'Maison & Jardin', 'Décoration, mobilier, outils', '2025-10-06 14:33:53', '2025-10-06 14:33:53'),
(4, 'Sports & Loisirs', 'Équipements sportifs et loisirs', '2025-10-06 14:33:53', '2025-10-06 14:33:53'),
(5, 'Beauté & Santé', 'Cosmétiques et produits de soins', '2025-10-06 14:33:53', '2025-10-06 14:33:53');

-- --------------------------------------------------------

--
-- Structure de la table `clothing`
--

CREATE TABLE `clothing` (
  `product_id` int NOT NULL,
  `size` varchar(50) NOT NULL,
  `color` varchar(50) NOT NULL,
  `type` varchar(100) DEFAULT NULL,
  `material_fee` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `electronic`
--

CREATE TABLE `electronic` (
  `product_id` int NOT NULL,
  `brand` varchar(100) NOT NULL,
  `warranty_fee` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `product`
--

CREATE TABLE `product` (
  `idProduct` int NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `price` decimal(8,2) NOT NULL,
  `stock` int DEFAULT '0',
  `idCategory` int NOT NULL,
  `createdAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `product`
--

INSERT INTO `product` (`idProduct`, `name`, `description`, `price`, `stock`, `idCategory`, `createdAt`, `updatedAt`) VALUES
(1, 'Test Performance 1760002783.8956', 'Description mise à jour le 2025-10-09 09:39:43', 50.99, 60, 1, '2025-10-06 14:34:27', '2025-10-09 07:39:43'),
(2, 'Jean Slim', 'Jean de qualité supérieure', 89.95, 25, 1, '2025-10-06 14:34:27', '2025-10-06 14:34:27'),
(3, 'Smartphone Pro', 'Dernière génération', 799.99, 10, 2, '2025-10-06 14:34:27', '2025-10-06 14:34:27'),
(4, 'Ordinateur Gaming', 'PC portable gaming', 1299.00, 5, 2, '2025-10-06 14:34:27', '2025-10-06 14:34:27'),
(5, 'Canapé Scandinave', 'Design nordique', 549.99, 8, 3, '2025-10-06 14:34:27', '2025-10-06 14:34:27'),
(6, 'Chaussures Running Pro', 'Chaussures de course haute performance avec semelle amortissante', 129.99, 15, 4, '2025-10-07 12:05:41', '2025-10-07 12:05:41'),
(7, 'Écouteurs Bluetooth Elite', 'Écouteurs sans fil avec réduction de bruit active et autonomie 24h', 159.00, 30, 2, '2025-10-07 12:05:41', '2025-10-07 12:05:41'),
(8, 'Lampe LED Design', 'Lampe de bureau moderne avec intensité réglable et port USB', 79.90, 20, 3, '2025-10-07 12:05:41', '2025-10-07 12:05:41'),
(9, 'MacBook Pro M3', 'Ordinateur portable Apple avec puce M3', 2499.99, 5, 2, '2025-10-09 05:06:29', '2025-10-09 05:06:29');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`idCategory`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Index pour la table `clothing`
--
ALTER TABLE `clothing`
  ADD PRIMARY KEY (`product_id`);

--
-- Index pour la table `electronic`
--
ALTER TABLE `electronic`
  ADD PRIMARY KEY (`product_id`);

--
-- Index pour la table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`idProduct`),
  ADD KEY `idx_product_category` (`idCategory`),
  ADD KEY `idx_product_name` (`name`),
  ADD KEY `idx_product_price` (`price`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `category`
--
ALTER TABLE `category`
  MODIFY `idCategory` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `product`
--
ALTER TABLE `product`
  MODIFY `idProduct` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `clothing`
--
ALTER TABLE `clothing`
  ADD CONSTRAINT `fk_clothing_product` FOREIGN KEY (`product_id`) REFERENCES `product` (`idProduct`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `electronic`
--
ALTER TABLE `electronic`
  ADD CONSTRAINT `fk_electronic_product` FOREIGN KEY (`product_id`) REFERENCES `product` (`idProduct`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `fk_product_category` FOREIGN KEY (`idCategory`) REFERENCES `category` (`idCategory`) ON DELETE RESTRICT ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
