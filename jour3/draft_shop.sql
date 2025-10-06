-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : lun. 06 oct. 2025 à 14:36
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
(1, 'T-shirt Premium', 'T-shirt en coton bio', 29.99, 50, 1, '2025-10-06 14:34:27', '2025-10-06 14:34:27'),
(2, 'Jean Slim', 'Jean de qualité supérieure', 89.95, 25, 1, '2025-10-06 14:34:27', '2025-10-06 14:34:27'),
(3, 'Smartphone Pro', 'Dernière génération', 799.99, 10, 2, '2025-10-06 14:34:27', '2025-10-06 14:34:27'),
(4, 'Ordinateur Gaming', 'PC portable gaming', 1299.00, 5, 2, '2025-10-06 14:34:27', '2025-10-06 14:34:27'),
(5, 'Canapé Scandinave', 'Design nordique', 549.99, 8, 3, '2025-10-06 14:34:27', '2025-10-06 14:34:27');

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
  MODIFY `idProduct` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `fk_product_category` FOREIGN KEY (`idCategory`) REFERENCES `category` (`idCategory`) ON DELETE RESTRICT ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
