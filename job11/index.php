<?php
require_once 'database.php';
require_once 'Category.php';

echo "<h1>🔄 Test Job 11 - Classes d'héritage Clothing et Electronic</h1>";
echo "<style>
    body { font-family: Arial, sans-serif; margin: 20px; background-color: #f8f9fa; }
    .container { max-width: 1000px; margin: 0 auto; }
    .test-block { 
        background: white;
        border: 2px solid #007bff; 
        margin: 20px 0; 
        padding: 20px; 
        border-radius: 10px; 
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    .success { color: #28a745; font-weight: bold; }
    .error { color: #dc3545; font-weight: bold; }
    .warning { color: #ffc107; font-weight: bold; }
    .info { color: #007bff; font-weight: bold; }
    .code-block { 
        background: #f8f9fa; 
        padding: 15px; 
        border-radius: 5px; 
        border-left: 4px solid #007bff;
        margin: 10px 0;
        font-family: 'Courier New', monospace;
    }
    .data-table {
        width: 100%;
        border-collapse: collapse;
        margin: 10px 0;
    }
    .data-table th, .data-table td {
        border: 1px solid #dee2e6;
        padding: 8px 12px;
        text-align: left;
    }
    .data-table th {
        background-color: #e9ecef;
        font-weight: bold;
    }
    .step {
        background: #e3f2fd;
        padding: 10px;
        margin: 10px 0;
        border-radius: 5px;
        border-left: 4px solid #2196f3;
    }
</style>";

echo "<div class='container'>";

// Test 1: Création d'instance Clothing
echo "<div class='test-block'>";
echo "<h2>🧥 Test 1 - Création d'une instance Clothing</h2>";

try {
    $tshirt = new Clothing(
        0,                              // id
        'T-shirt Premium Bio',          // name
        ['tshirt1.jpg', 'tshirt2.jpg'], // photos
        29.99,                          // price
        'T-shirt en coton biologique',  // description
        50,                             // quantity
        1,                              // category_id (Vêtements)
        null,                           // createdAt
        null,                           // updatedAt
        'L',                            // size
        'Bleu marine',                  // color
        'T-shirt',                      // type
        5                               // material_fee
    );
    
    echo "<p class='success'>✅ Instance Clothing créée avec succès</p>";
    
    echo "<h3>Propriétés héritées de Product :</h3>";
    echo "<div class='code-block'>";
    echo "Nom : " . $tshirt->getName() . "<br>";
    echo "Prix : " . $tshirt->getPrice() . "€<br>";
    echo "Description : " . $tshirt->getDescription() . "<br>";
    echo "Quantité : " . $tshirt->getQuantity() . "<br>";
    echo "Catégorie ID : " . $tshirt->getCategoryId() . "<br>";
    echo "</div>";
    
    echo "<h3>Propriétés spécifiques à Clothing :</h3>";
    echo "<div class='code-block'>";
    echo "Taille : " . $tshirt->getSize() . "<br>";
    echo "Couleur : " . $tshirt->getColor() . "<br>";
    echo "Type : " . $tshirt->getType() . "<br>";
    echo "Frais matériau : " . $tshirt->getMaterialFee() . "€<br>";
    echo "</div>";
    
} catch (Exception $e) {
    echo "<p class='error'>❌ Erreur lors de la création de Clothing : " . $e->getMessage() . "</p>";
}
echo "</div>";

// Test 2: Création d'instance Electronic
echo "<div class='test-block'>";
echo "<h2>📱 Test 2 - Création d'une instance Electronic</h2>";

try {
    $smartphone = new Electronic(
        0,                                      // id
        'iPhone 15 Pro Max',                    // name
        ['iphone1.jpg', 'iphone2.jpg'],         // photos
        1299.00,                                // price
        'Smartphone haut de gamme Apple',       // description
        15,                                     // quantity
        2,                                      // category_id (Électronique)
        null,                                   // createdAt
        null,                                   // updatedAt
        'Apple',                                // brand
        149                                     // warranty_fee
    );
    
    echo "<p class='success'>✅ Instance Electronic créée avec succès</p>";
    
    echo "<h3>Propriétés héritées de Product :</h3>";
    echo "<div class='code-block'>";
    echo "Nom : " . $smartphone->getName() . "<br>";
    echo "Prix : " . $smartphone->getPrice() . "€<br>";
    echo "Description : " . $smartphone->getDescription() . "<br>";
    echo "Quantité : " . $smartphone->getQuantity() . "<br>";
    echo "Catégorie ID : " . $smartphone->getCategoryId() . "<br>";
    echo "</div>";
    
    echo "<h3>Propriétés spécifiques à Electronic :</h3>";
    echo "<div class='code-block'>";
    echo "Marque : " . $smartphone->getBrand() . "<br>";
    echo "Frais garantie : " . $smartphone->getWarrantyFee() . "€<br>";
    echo "</div>";
    
} catch (Exception $e) {
    echo "<p class='error'>❌ Erreur lors de la création d'Electronic : " . $e->getMessage() . "</p>";
}
echo "</div>";

// Test 3: Test des setters avec validation
echo "<div class='test-block'>";
echo "<h2>🔧 Test 3 - Validation des setters</h2>";

echo "<div class='step'>";
echo "<h4>Test modification des propriétés Clothing :</h4>";
try {
    $tshirt->setSize('XL');
    $tshirt->setColor('Rouge');
    $tshirt->setMaterialFee(8);
    
    echo "<p class='success'>✅ Modifications Clothing réussies</p>";
    echo "<div class='code-block'>";
    echo "Nouvelle taille : " . $tshirt->getSize() . "<br>";
    echo "Nouvelle couleur : " . $tshirt->getColor() . "<br>";
    echo "Nouveaux frais matériau : " . $tshirt->getMaterialFee() . "€<br>";
    echo "</div>";
} catch (Exception $e) {
    echo "<p class='error'>❌ Erreur modification Clothing : " . $e->getMessage() . "</p>";
}
echo "</div>";

echo "<div class='step'>";
echo "<h4>Test modification des propriétés Electronic :</h4>";
try {
    $smartphone->setBrand('Samsung');
    $smartphone->setWarrantyFee(199);
    
    echo "<p class='success'>✅ Modifications Electronic réussies</p>";
    echo "<div class='code-block'>";
    echo "Nouvelle marque : " . $smartphone->getBrand() . "<br>";
    echo "Nouveaux frais garantie : " . $smartphone->getWarrantyFee() . "€<br>";
    echo "</div>";
} catch (Exception $e) {
    echo "<p class='error'>❌ Erreur modification Electronic : " . $e->getMessage() . "</p>";
}
echo "</div>";

// Test validation des valeurs négatives
echo "<div class='step'>";
echo "<h4>Test validation des valeurs négatives :</h4>";
echo "<p class='info'>Test avec material_fee négatif...</p>";
try {
    $tshirt->setMaterialFee(-10);
    echo "<p class='error'>❌ La validation a échoué, valeur négative acceptée</p>";
} catch (InvalidArgumentException $e) {
    echo "<p class='success'>✅ Validation OK : " . $e->getMessage() . "</p>";
}

echo "<p class='info'>Test avec warranty_fee négatif...</p>";
try {
    $smartphone->setWarrantyFee(-50);
    echo "<p class='error'>❌ La validation a échoué, valeur négative acceptée</p>";
} catch (InvalidArgumentException $e) {
    echo "<p class='success'>✅ Validation OK : " . $e->getMessage() . "</p>";
}
echo "</div>";
echo "</div>";

// Test 4: Vérification de l'héritage
echo "<div class='test-block'>";
echo "<h2>🔗 Test 4 - Vérification de l'héritage</h2>";

echo "<div class='step'>";
echo "<h4>Test instanceof :</h4>";
echo "<div class='code-block'>";
echo "Clothing instanceof Product : " . ($tshirt instanceof Product ? '✅ OUI' : '❌ NON') . "<br>";
echo "Electronic instanceof Product : " . ($smartphone instanceof Product ? '✅ OUI' : '❌ NON') . "<br>";
echo "Clothing instanceof Electronic : " . ($tshirt instanceof Electronic ? '✅ OUI' : '❌ NON') . "<br>";
echo "</div>";
echo "</div>";

echo "<div class='step'>";
echo "<h4>Test accès aux méthodes héritées :</h4>";
try {
    // Test modification via méthodes héritées
    $tshirt->setPrice(39.99);
    $tshirt->setQuantity(75);
    $smartphone->setPrice(1099.00);
    $smartphone->setQuantity(20);
    
    echo "<p class='success'>✅ Accès aux méthodes héritées réussi</p>";
    echo "<div class='code-block'>";
    echo "Nouveau prix T-shirt : " . $tshirt->getPrice() . "€<br>";
    echo "Nouvelle quantité T-shirt : " . $tshirt->getQuantity() . "<br>";
    echo "Nouveau prix Smartphone : " . $smartphone->getPrice() . "€<br>";
    echo "Nouvelle quantité Smartphone : " . $smartphone->getQuantity() . "<br>";
    echo "</div>";
} catch (Exception $e) {
    echo "<p class='error'>❌ Erreur accès méthodes héritées : " . $e->getMessage() . "</p>";
}
echo "</div>";
echo "</div>";

// Test 5: Récapitulatif des objets créés
echo "<div class='test-block'>";
echo "<h2>📊 Test 5 - Récapitulatif des objets créés</h2>";

echo "<table class='data-table'>";
echo "<tr>
        <th>Propriété</th>
        <th>Clothing (T-shirt)</th>
        <th>Electronic (Smartphone)</th>
      </tr>";
echo "<tr><td><strong>Nom</strong></td><td>" . $tshirt->getName() . "</td><td>" . $smartphone->getName() . "</td></tr>";
echo "<tr><td><strong>Prix</strong></td><td>" . $tshirt->getPrice() . "€</td><td>" . $smartphone->getPrice() . "€</td></tr>";
echo "<tr><td><strong>Quantité</strong></td><td>" . $tshirt->getQuantity() . "</td><td>" . $smartphone->getQuantity() . "</td></tr>";
echo "<tr><td><strong>Catégorie ID</strong></td><td>" . $tshirt->getCategoryId() . "</td><td>" . $smartphone->getCategoryId() . "</td></tr>";
echo "<tr><td><strong>Spécificité 1</strong></td><td>Taille: " . $tshirt->getSize() . "</td><td>Marque: " . $smartphone->getBrand() . "</td></tr>";
echo "<tr><td><strong>Spécificité 2</strong></td><td>Couleur: " . $tshirt->getColor() . "</td><td>Garantie: " . $smartphone->getWarrantyFee() . "€</td></tr>";
echo "<tr><td><strong>Spécificité 3</strong></td><td>Type: " . $tshirt->getType() . "</td><td>-</td></tr>";
echo "<tr><td><strong>Frais supplémentaires</strong></td><td>Matériau: " . $tshirt->getMaterialFee() . "€</td><td>Garantie: " . $smartphone->getWarrantyFee() . "€</td></tr>";
echo "</table>";
echo "</div>";

// Résumé final
echo "<div class='test-block'>";
echo "<h2>🎯 Résumé des tests Job 11</h2>";
echo "<div class='step'>";
echo "<p class='success'><strong>✅ Tests réussis :</strong></p>";
echo "<ul>";
echo "<li>Création des classes Clothing et Electronic avec héritage</li>";
echo "<li>Constructeurs avec appel du parent</li>";
echo "<li>Getters et setters spécifiques fonctionnels</li>";
echo "<li>Validation des valeurs négatives</li>";
echo "<li>Accès aux méthodes héritées de Product</li>";
echo "<li>Vérification de l'héritage avec instanceof</li>";
echo "</ul>";
echo "</div>";


?>