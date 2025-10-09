<?php


require_once 'database.php';
require_once 'Category.php';

try {
    // 1. Créer un nouveau produit
    $newProduct = new Product(
        0, // ID = 0 pour un nouveau produit
        'MacBook Pro M3',
        [], // Photos vides pour l'instant
        2499.99,
        'Ordinateur portable Apple avec puce M3',
        5, // Quantité en stock
        2, // ID de la catégorie "Électronique"
        null, // createdAt sera défini automatiquement
        null  // updatedAt sera défini automatiquement
    );
    
    // 2. Tenter de sauvegarder en base
    $result = $newProduct->create();
    
    if ($result !== false) {
        echo "✅ Produit créé avec succès !<br>";
        echo "ID généré: " . $newProduct->getId() . "<br>";
        echo "Nom: " . $newProduct->getName() . "<br>";
        echo "Prix: " . $newProduct->getPrice() . "€<br>";
        echo "Créé le: " . $newProduct->getCreatedAt()->format('d/m/Y H:i:s') . "<br>";
        
        // Affichage pour debug
        var_dump($newProduct);
        
    } else {
        echo "❌ Échec de la création du produit<br>";
    }
    
} catch (Exception $e) {
    echo "❌ Erreur: " . $e->getMessage();
}

// 3. Exemple avec des données invalides
echo "<hr><h3>Test avec données invalides:</h3>";

try {
    $invalidProduct = new Product(
        0,
        '', // Nom vide - devrait échouer
        [],
        -10, // Prix négatif - devrait échouer
        'Description test',
        5,
        0 // ID catégorie invalide - devrait échouer
    );
    
    $result = $invalidProduct->create();
    
    if ($result === false) {
        echo "✅ Validation fonctionnelle : produit invalide rejeté<br>";
    } else {
        echo "❌ Problème : produit invalide accepté<br>";
    }
    
} catch (Exception $e) {
    echo "✅ Exception capturée : " . $e->getMessage() . "<br>";
}

?>