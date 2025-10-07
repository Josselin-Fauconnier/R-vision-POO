<?php

require_once 'database.php';
require_once 'Product.php';

try {
    $pdo = getDatabaseConnection();

    $query = "SELECT * FROM product WHERE idProduct = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindValue(':id', 7, PDO::PARAM_INT);
    $stmt->execute();

    $productData = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($productData) {
        
        $product = new Product();
        
        $product->setId($productData['idProduct']);
        $product->setName($productData['name']);
        $product->setDescription($productData['description']);
        $product->setPrice((int)$productData['price']);
        $product->setQuantity($productData['stock']);
        $product->setCreatedAt(new DateTime($productData['createdAt']));
        $product->setUpdatedAt(new DateTime($productData['updatedAt']));
        
        echo "<h2>Produit récupéré avec succès !</h2>";
        echo "<pre>";
        var_dump($product);
        echo "</pre>";
        
        echo "<h3>Détails du produit :</h3>";
        echo "ID : " . $product->getId() . "<br>";
        echo "Nom : " . $product->getName() . "<br>";
        echo "Description : " . $product->getDescription() . "<br>";
        echo "Prix : " . $product->getPrice() . " €<br>";
        echo "Quantité : " . $product->getQuantity() . "<br>";
        echo "Créé le : " . $product->getCreatedAt()->format('d/m/Y H:i:s') . "<br>";
        echo "Mis à jour le : " . $product->getUpdatedAt()->format('d/m/Y H:i:s') . "<br>";
        
    } else {
        echo "<p style='color: red;'>Aucun produit trouvé avec l'ID 7</p>";
        echo "<p>Vérifie que tu as bien inséré des données dans ta base de données.</p>";
    }
    
} catch (PDOException $e) {
    echo "<p style='color: red;'>Erreur de base de données : " . htmlspecialchars($e->getMessage()) . "</p>";
} catch (Exception $e) {
    echo "<p style='color: red;'>Erreur : " . htmlspecialchars($e->getMessage()) . "</p>";
}

?>