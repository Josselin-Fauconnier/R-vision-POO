<?php

// Inclure la classe Product
require_once 'Product.php';

echo "====================================\n";
echo "   TESTS CLASSE PRODUCT - JOB 01\n";
echo "====================================\n\n";

// Test 1 : Création d'un produit
echo "1. Test de création d'un produit\n";
echo "--------------------------------\n";

$product = new Product(
    1,                                    // id
    "T-shirt Premium",                    // name
    ["photo1.jpg", "photo2.jpg"],         // photos
    2500,                                 // price (25€ en centimes)
    "Un magnifique T-shirt en coton",     // description
    15,                                   // quantity
    new DateTime('2024-01-15 10:30:00'),  // createdAt
    new DateTime('2024-01-15 10:30:00')   // updatedAt
);

echo "✅ Produit créé avec succès !\n\n";

// Test 2 : Vérification des getters
echo "2. Test des getters (lecture)\n";
echo "-----------------------------\n";

echo "ID : ";
var_dump($product->getId());

echo "Nom : ";
var_dump($product->getName());

echo "Prix : ";
var_dump($product->getPrice());

echo "Quantité : ";
var_dump($product->getQuantity());

echo "Photos : ";
var_dump($product->getPhotos());

echo "Description : ";
var_dump($product->getDescription());

echo "Date création : " . $product->getCreatedAt()->format('Y-m-d H:i:s') . "\n";
echo "Date mise à jour : " . $product->getUpdatedAt()->format('Y-m-d H:i:s') . "\n\n";

// Test 3 : Modification avec les setters
echo "3. Test des setters (modification)\n";
echo "----------------------------------\n";

echo "Changement du nom...\n";
$product->setName("T-shirt Super Premium");
echo "Nouveau nom : ";
var_dump($product->getName());

echo "Changement du prix...\n";
$product->setPrice(3500);
echo "Nouveau prix : ";
var_dump($product->getPrice());

echo "Ajout d'une photo...\n";
$product->setPhotos(["photo1.jpg", "photo2.jpg", "photo3.jpg"]);
echo "Nouvelles photos : ";
var_dump($product->getPhotos());

echo "\n";

// Test 4 : Test des validations (si présentes)
echo "4. Test des validations\n";
echo "-----------------------\n";

echo "Test prix négatif : ";
try {
    $product->setPrice(-100);
    echo "❌ ERREUR - Prix négatif accepté !\n";
} catch (Exception $e) {
    echo "✅ OK - " . $e->getMessage() . "\n";
}

echo "Test quantité négative : ";
try {
    $product->setQuantity(-5);
    echo "❌ ERREUR - Quantité négative acceptée !\n";
} catch (Exception $e) {
    echo "✅ OK - " . $e->getMessage() . "\n";
}

echo "\n";

// Test 5 : Création d'un second produit
echo "5. Test avec un second produit\n";
echo "------------------------------\n";

$product2 = new Product(
    2,
    "Pantalon Jeans",
    [],  // Pas de photos
    4500,
    "Pantalon en denim",
    8,
    new DateTime(),
    new DateTime()
);

echo "Produit 1 - Nom : " . $product->getName() . " | Prix : " . $product->getPrice() . "\n";
echo "Produit 2 - Nom : " . $product2->getName() . " | Prix : " . $product2->getPrice() . "\n\n";

// Test 6 : Résumé final
echo "6. Résumé des objets créés\n";
echo "-------------------------\n";

echo "=== PRODUIT 1 ===\n";
echo "ID: " . $product->getId() . "\n";
echo "Nom: " . $product->getName() . "\n";
echo "Prix: " . $product->getPrice() . " centimes\n";
echo "Quantité: " . $product->getQuantity() . "\n";
echo "Photos: " . count($product->getPhotos()) . " photo(s)\n";

echo "\n=== PRODUIT 2 ===\n";
echo "ID: " . $product2->getId() . "\n";
echo "Nom: " . $product2->getName() . "\n";
echo "Prix: " . $product2->getPrice() . " centimes\n";
echo "Quantité: " . $product2->getQuantity() . "\n";
echo "Photos: " . count($product2->getPhotos()) . " photo(s)\n";

echo "\n====================================\n";
echo "        TESTS TERMINÉS ✅\n";
echo "====================================\n";

?>