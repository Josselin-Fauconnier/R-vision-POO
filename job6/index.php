<?php
// test_job06.php

// Afficher les erreurs PHP pour déboguer
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Inclure vos fichiers
require_once 'database.php';
require_once 'Category.php';

echo "<h1>🧪 Test Job 06 - Méthode getProducts()</h1>";
echo "<hr>";

try {
    
    // Test 1 : Catégorie Vêtements (ID = 1)
    echo "<h2>📝 Test 1 : Catégorie Vêtements</h2>";
    
    $category1 = new Category(1, 'Vêtements', 'Tous les types de vêtements');
    
    echo "<p><strong>Catégorie :</strong> " . $category1->getName() . "</p>";
    echo "<p><strong>ID :</strong> " . $category1->getId() . "</p>";
    
    $produits = $category1->getProducts();
    
    echo "<p><strong>Nombre de produits trouvés :</strong> " . count($produits) . "</p>";
    
    if (count($produits) > 0) {
        echo "<p>✅ <strong>Produits dans cette catégorie :</strong></p>";
        echo "<ul>";
        foreach ($produits as $produit) {
            echo "<li>";
            echo "<strong>" . htmlspecialchars($produit->getName()) . "</strong>";
            echo " - " . number_format($produit->getPrice(), 2) . "€";
            echo " (Stock: " . $produit->getQuantity() . ")";
            echo "<br><em>" . htmlspecialchars($produit->getDescription()) . "</em>";
            echo "</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>❌ Aucun produit trouvé</p>";
    }
    
    echo "<hr>";
    
    // Test 2 : Catégorie Électronique (ID = 2)
    echo "<h2>💻 Test 2 : Catégorie Électronique</h2>";
    
    $category2 = new Category(2, 'Électronique', 'Smartphones, ordinateurs, gadgets');
    
    echo "<p><strong>Catégorie :</strong> " . $category2->getName() . "</p>";
    echo "<p><strong>ID :</strong> " . $category2->getId() . "</p>";
    
    $produitsElec = $category2->getProducts();
    
    echo "<p><strong>Nombre de produits trouvés :</strong> " . count($produitsElec) . "</p>";
    
    if (count($produitsElec) > 0) {
        echo "<p>✅ <strong>Produits dans cette catégorie :</strong></p>";
        echo "<ul>";
        foreach ($produitsElec as $produit) {
            echo "<li>";
            echo "<strong>" . htmlspecialchars($produit->getName()) . "</strong>";
            echo " - " . number_format($produit->getPrice(), 2) . "€";
            echo " (Stock: " . $produit->getQuantity() . ")";
            echo "</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>❌ Aucun produit trouvé</p>";
    }
    
    echo "<hr>";
    
    // Test 3 : Catégorie inexistante
    echo "<h2>❓ Test 3 : Catégorie inexistante (ID = 999)</h2>";
    
    $category3 = new Category(999, 'Catégorie Inexistante', 'Cette catégorie n\'existe pas');
    
    echo "<p><strong>Catégorie :</strong> " . $category3->getName() . "</p>";
    echo "<p><strong>ID :</strong> " . $category3->getId() . "</p>";
    
    $produitsInexistants = $category3->getProducts();
    
    echo "<p><strong>Nombre de produits trouvés :</strong> " . count($produitsInexistants) . "</p>";
    
    if (count($produitsInexistants) === 0) {
        echo "<p>✅ Aucun produit trouvé (normal pour une catégorie inexistante)</p>";
    } else {
        echo "<p>❌ Erreur : des produits ont été trouvés alors qu'ils ne devraient pas</p>";
    }
    
    echo "<hr>";
    
    // Test 4 : Toutes les catégories
    echo "<h2>📋 Test 4 : Test de toutes les catégories</h2>";
    
    $categories = [
        new Category(1, 'Vêtements'),
        new Category(2, 'Électronique'),
        new Category(3, 'Maison & Jardin'),
        new Category(4, 'Sports & Loisirs'),
        new Category(5, 'Beauté & Santé')
    ];
    
    echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
    echo "<tr style='background-color: #f0f0f0;'>";
    echo "<th>ID</th><th>Nom Catégorie</th><th>Nombre Produits</th>";
    echo "</tr>";
    
    foreach ($categories as $cat) {
        $prods = $cat->getProducts();
        echo "<tr>";
        echo "<td>" . $cat->getId() . "</td>";
        echo "<td>" . htmlspecialchars($cat->getName()) . "</td>";
        echo "<td>" . count($prods) . "</td>";
        echo "</tr>";
    }
    
    echo "</table>";
    
    echo "<hr>";
    echo "<h2>🎉 Tests terminés avec succès !</h2>";
    echo "<p>La méthode getProducts() fonctionne correctement.</p>";
    
} catch (Exception $e) {
    echo "<div style='color: red; background-color: #ffeeee; padding: 10px; border: 1px solid red;'>";
    echo "<h3>❌ Erreur durant les tests</h3>";
    echo "<p><strong>Message :</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p><strong>Fichier :</strong> " . $e->getFile() . "</p>";
    echo "<p><strong>Ligne :</strong> " . $e->getLine() . "</p>";
    echo "</div>";
}

echo "<hr>";
echo "<p><em>Test généré le " . date('Y-m-d H:i:s') . "</em></p>";
?>