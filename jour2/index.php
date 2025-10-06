<?php

require_once 'Category.php';

echo "<h1>🧪 Test de la classe Category</h1>";

// ==============================================
// Création d'une catégorie avec tous les paramètres
// ==============================================
echo "<h2>📋 Catégorie 1 - Vêtements</h2>";

$category1 = new Category(1, 'Vêtements', 'Tous les types de vêtements', new DateTime(), new DateTime());

echo "<strong>Objet créé avec succès !</strong><br>";
echo "<pre>";
var_dump($category1);
echo "</pre>";

// ==============================================
// Création d'une autre catégorie
// ==============================================
echo "<h2>📋 Catégorie 2 - Électronique</h2>";

$category2 = new Category(2, 'Électronique', 'Produits électroniques', new DateTime(), new DateTime());

echo "<strong>Deuxième catégorie créée !</strong><br>";
echo "<pre>";
var_dump($category2);
echo "</pre>";

// ==============================================
// Test des getters
// ==============================================
echo "<h2>🔍 Test des getters (Catégorie 1)</h2>";

echo "<table border='1' cellpadding='8' cellspacing='0' style='border-collapse: collapse;'>";
echo "<tr style='background-color: #f0f0f0;'><th>Propriété</th><th>Valeur</th></tr>";
echo "<tr><td><strong>ID</strong></td><td>" . $category1->getId() . "</td></tr>";
echo "<tr><td><strong>Nom</strong></td><td>" . $category1->getName() . "</td></tr>";
echo "<tr><td><strong>Description</strong></td><td>" . $category1->getDescription() . "</td></tr>";
echo "<tr><td><strong>Créé le</strong></td><td>" . $category1->getCreatedAt()->format('Y-m-d H:i:s') . "</td></tr>";
echo "<tr><td><strong>Modifié le</strong></td><td>" . $category1->getUpdatedAt()->format('Y-m-d H:i:s') . "</td></tr>";
echo "</table>";

// ==============================================
// Test des setters
// ==============================================
echo "<h2>⚙️ Test des setters (Catégorie 2)</h2>";

echo "<p><em>Modification de la catégorie Électronique...</em></p>";

$category2->setName('High-Tech & Électronique');
$category2->setDescription('Smartphones, ordinateurs, gadgets électroniques');
$category2->setUpdatedAt(new DateTime());

echo "<strong>✅ Modifications appliquées !</strong><br>";
echo "<table border='1' cellpadding='8' cellspacing='0' style='border-collapse: collapse;'>";
echo "<tr style='background-color: #f0f0f0;'><th>Propriété</th><th>Nouvelle valeur</th></tr>";
echo "<tr><td><strong>ID</strong></td><td>" . $category2->getId() . "</td></tr>";
echo "<tr><td><strong>Nom</strong></td><td>" . $category2->getName() . "</td></tr>";
echo "<tr><td><strong>Description</strong></td><td>" . $category2->getDescription() . "</td></tr>";
echo "<tr><td><strong>Modifié le</strong></td><td>" . $category2->getUpdatedAt()->format('Y-m-d H:i:s') . "</td></tr>";
echo "</table>";

echo "<h2>🎉 Tests terminés avec succès !</h2>";

?>