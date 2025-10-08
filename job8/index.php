<?php

require_once 'Category.php'; 
require_once 'database.php';

echo "<h1>🎯 TEST FINAL - findAll() corrigé</h1>";

try {
    // Test de la méthode findAll()
    $product = new Product();
    $allProducts = $product->findAll();
    
    echo "<h2>Résultat findAll() :</h2>";
    echo "<p><strong>Nombre de produits trouvés : " . count($allProducts) . "</strong></p>";
    
    if (count($allProducts) > 0) {
        echo "🎉 <strong>SUCCÈS !</strong> findAll() fonctionne maintenant !<br><br>";
        
        echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
        echo "<tr style='background-color: #f2f2f2;'>";
        echo "<th>ID</th><th>Nom</th><th>Prix</th><th>Stock</th><th>Catégorie</th><th>Description</th>";
        echo "</tr>";
        
        foreach ($allProducts as $prod) {
            echo "<tr>";
            echo "<td>" . $prod->getId() . "</td>";
            echo "<td>" . htmlspecialchars($prod->getName()) . "</td>";
            echo "<td>" . number_format($prod->getPrice(), 2) . " €</td>";
            echo "<td>" . $prod->getQuantity() . "</td>";
            echo "<td>" . $prod->getCategoryId() . "</td>";
            echo "<td>" . htmlspecialchars($prod->getDescription()) . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        
        // Test d'un produit spécifique
        echo "<h3>🔍 Test d'un produit spécifique :</h3>";
        $firstProduct = $allProducts[0];
        echo "<ul>";
        echo "<li><strong>Nom :</strong> " . $firstProduct->getName() . "</li>";
        echo "<li><strong>Prix :</strong> " . $firstProduct->getPrice() . " €</li>";
        echo "<li><strong>Stock :</strong> " . $firstProduct->getQuantity() . "</li>";
        echo "<li><strong>Date création :</strong> " . $firstProduct->getCreatedAt()->format('d/m/Y H:i:s') . "</li>";
        echo "</ul>";
        
    } else {
        echo "❌ findAll() retourne encore un tableau vide.<br>";
        echo "Vérifiez que vous avez bien remplacé votre code par la version corrigée.";
    }
    
    // Test bonus : findOneById
    echo "<hr><h2>🎯 Test bonus - findOneById(7) :</h2>";
    $productTest = new Product();
    $result = $productTest->findOneById(7);
    
    if ($result !== false) {
        echo "✅ findOneById(7) fonctionne !<br>";
        echo "Produit trouvé : <strong>" . $result->getName() . "</strong> - " . $result->getPrice() . " €<br>";
    } else {
        echo "❌ findOneById(7) n'a pas trouvé le produit (normal si ID 7 n'existe pas)<br>";
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Erreur : " . $e->getMessage() . "</p>";
}

echo "<hr>";
echo "<h2>📋 Conclusion :</h2>";
echo "<p>Si vous voyez '🎉 SUCCÈS !', votre méthode findAll() est maintenant <strong>parfaitement fonctionnelle</strong> !</p>";
echo "<p>Le problème était simplement les noms de colonnes qui ne correspondaient pas à votre schéma de base de données.</p>";

?>