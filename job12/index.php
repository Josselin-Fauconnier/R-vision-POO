<?php
require_once 'database.php';
require_once 'Category.php';

echo "<h1>🔄 Test Job 12 - Classes Clothing et Electronic</h1>";
echo "<style>
    body { font-family: Arial, sans-serif; margin: 20px; background-color: #f8f9fa; }
    .container { max-width: 1200px; margin: 0 auto; }
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
    .category-clothing { border-left-color: #ff6b6b; }
    .category-electronic { border-left-color: #4ecdc4; }
    .method-test { border-left-color: #45b7d1; }
</style>";

echo "<div class='container'>";

// ===============================
// SECTION 1: TESTS DE LA CLASSE CLOTHING
// ===============================

echo "<div class='test-block category-clothing'>";
echo "<h2>👕 Tests de la classe Clothing</h2>";

echo "<div class='step'>";
echo "<h3>Étape 1: Test de la méthode create() pour Clothing</h3>";

try {
    // Création d'un nouveau vêtement
    $clothing = new Clothing();
    $clothing->setName("T-shirt Bio Premium");
    $clothing->setDescription("T-shirt en coton bio certifié GOTS");
    $clothing->setPrice(29.99);
    $clothing->setQuantity(50);
    $clothing->setCategoryId(1); // Catégorie Vêtements
    
    // Propriétés spécifiques aux vêtements
    $clothing->setSize("M");
    $clothing->setColor("Bleu Marine");
    $clothing->setType("T-shirt");
    $clothing->setMaterialFee(5);

    echo "<div class='code-block'>";
    echo "Création d'un nouveau vêtement:<br>";
    echo "Nom: " . $clothing->getName() . "<br>";
    echo "Taille: " . $clothing->getSize() . "<br>";
    echo "Couleur: " . $clothing->getColor() . "<br>";
    echo "Type: " . $clothing->getType() . "<br>";
    echo "Frais matériel: " . $clothing->getMaterialFee() . "€<br>";
    echo "</div>";

    $result = $clothing->create();
    
    if ($result) {
        echo "<p class='success'>✅ Vêtement créé avec succès ! ID: " . $result->getId() . "</p>";
        $newClothingId = $result->getId();
    } else {
        echo "<p class='error'>❌ Échec de la création du vêtement</p>";
        $newClothingId = null;
    }
    
} catch (Exception $e) {
    echo "<p class='error'>❌ Erreur lors de la création: " . $e->getMessage() . "</p>";
    $newClothingId = null;
}
echo "</div>";

echo "<div class='step'>";
echo "<h3>Étape 2: Test de la méthode findOneById() pour Clothing</h3>";

if ($newClothingId) {
    try {
        $clothingTest = new Clothing();
        $foundClothing = $clothingTest->findOneById($newClothingId);
        
        if ($foundClothing) {
            echo "<p class='success'>✅ Vêtement trouvé avec l'ID $newClothingId</p>";
            
            echo "<table class='data-table'>";
            echo "<tr><th>Propriété</th><th>Valeur</th></tr>";
            echo "<tr><td>ID</td><td>" . $foundClothing->getId() . "</td></tr>";
            echo "<tr><td>Nom</td><td>" . $foundClothing->getName() . "</td></tr>";
            echo "<tr><td>Prix</td><td>" . $foundClothing->getPrice() . "€</td></tr>";
            echo "<tr><td>Stock</td><td>" . $foundClothing->getQuantity() . "</td></tr>";
            echo "<tr><td>Taille</td><td>" . $foundClothing->getSize() . "</td></tr>";
            echo "<tr><td>Couleur</td><td>" . $foundClothing->getColor() . "</td></tr>";
            echo "<tr><td>Type</td><td>" . $foundClothing->getType() . "</td></tr>";
            echo "<tr><td>Frais matériel</td><td>" . $foundClothing->getMaterialFee() . "€</td></tr>";
            echo "</table>";
        } else {
            echo "<p class='error'>❌ Aucun vêtement trouvé avec l'ID $newClothingId</p>";
        }
        
    } catch (Exception $e) {
        echo "<p class='error'>❌ Erreur lors de la recherche: " . $e->getMessage() . "</p>";
    }
} else {
    echo "<p class='warning'>⚠️ Impossible de tester findOneById car aucun ID disponible</p>";
}
echo "</div>";

echo "<div class='step'>";
echo "<h3>Étape 3: Test de la méthode update() pour Clothing</h3>";

if ($newClothingId && isset($foundClothing)) {
    try {
        // Modification des propriétés
        $foundClothing->setName("T-shirt Bio Premium - Édition Limitée");
        $foundClothing->setPrice(34.99);
        $foundClothing->setQuantity(45);
        $foundClothing->setSize("L");
        $foundClothing->setColor("Rouge");
        $foundClothing->setMaterialFee(7);
        
        echo "<div class='code-block'>";
        echo "Modifications apportées:<br>";
        echo "Nouveau nom: " . $foundClothing->getName() . "<br>";
        echo "Nouveau prix: " . $foundClothing->getPrice() . "€<br>";
        echo "Nouvelle taille: " . $foundClothing->getSize() . "<br>";
        echo "Nouvelle couleur: " . $foundClothing->getColor() . "<br>";
        echo "</div>";
        
        $updateResult = $foundClothing->update();
        
        if ($updateResult) {
            echo "<p class='success'>✅ Vêtement mis à jour avec succès !</p>";
            
            // Vérification des modifications
            $verifyClothing = new Clothing();
            $verifiedClothing = $verifyClothing->findOneById($newClothingId);
            
            if ($verifiedClothing) {
                echo "<h4>Vérification des modifications:</h4>";
                echo "<table class='data-table'>";
                echo "<tr><th>Propriété</th><th>Nouvelle valeur</th></tr>";
                echo "<tr><td>Nom</td><td>" . $verifiedClothing->getName() . "</td></tr>";
                echo "<tr><td>Prix</td><td>" . $verifiedClothing->getPrice() . "€</td></tr>";
                echo "<tr><td>Taille</td><td>" . $verifiedClothing->getSize() . "</td></tr>";
                echo "<tr><td>Couleur</td><td>" . $verifiedClothing->getColor() . "</td></tr>";
                echo "</table>";
            }
        } else {
            echo "<p class='error'>❌ Échec de la mise à jour du vêtement</p>";
        }
        
    } catch (Exception $e) {
        echo "<p class='error'>❌ Erreur lors de la mise à jour: " . $e->getMessage() . "</p>";
    }
} else {
    echo "<p class='warning'>⚠️ Impossible de tester update car aucun vêtement disponible</p>";
}
echo "</div>";

echo "<div class='step'>";
echo "<h3>Étape 4: Test de la méthode findAll() pour Clothing</h3>";

try {
    $clothingCollection = new Clothing();
    $allClothings = $clothingCollection->findAll();
    
    echo "<p class='info'>📊 Nombre total de vêtements trouvés: " . count($allClothings) . "</p>";
    
    if (count($allClothings) > 0) {
        echo "<table class='data-table'>";
        echo "<tr><th>ID</th><th>Nom</th><th>Taille</th><th>Couleur</th><th>Type</th><th>Prix</th><th>Stock</th></tr>";
        
        foreach ($allClothings as $clothing) {
            echo "<tr>";
            echo "<td>" . $clothing->getId() . "</td>";
            echo "<td>" . $clothing->getName() . "</td>";
            echo "<td>" . $clothing->getSize() . "</td>";
            echo "<td>" . $clothing->getColor() . "</td>";
            echo "<td>" . $clothing->getType() . "</td>";
            echo "<td>" . $clothing->getPrice() . "€</td>";
            echo "<td>" . $clothing->getQuantity() . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "<p class='success'>✅ Tous les vêtements ont été récupérés avec succès</p>";
    } else {
        echo "<p class='warning'>⚠️ Aucun vêtement trouvé dans la base de données</p>";
    }
    
} catch (Exception $e) {
    echo "<p class='error'>❌ Erreur lors de la récupération des vêtements: " . $e->getMessage() . "</p>";
}
echo "</div>";

echo "</div>";

// ===============================
// SECTION 2: TESTS DE LA CLASSE ELECTRONIC
// ===============================

echo "<div class='test-block category-electronic'>";
echo "<h2>📱 Tests de la classe Electronic</h2>";

echo "<div class='step'>";
echo "<h3>Étape 1: Test de la méthode create() pour Electronic</h3>";

try {
    // Création d'un nouveau produit électronique
    $electronic = new Electronic();
    $electronic->setName("Smartphone Galaxy Ultra");
    $electronic->setDescription("Dernier modèle avec 5G et appareil photo 108MP");
    $electronic->setPrice(899.99);
    $electronic->setQuantity(25);
    $electronic->setCategoryId(2); // Catégorie Électronique
    
    // Propriétés spécifiques aux électroniques
    $electronic->setBrand("Samsung");
    $electronic->setWarrantyFee(99);

    echo "<div class='code-block'>";
    echo "Création d'un nouveau produit électronique:<br>";
    echo "Nom: " . $electronic->getName() . "<br>";
    echo "Marque: " . $electronic->getBrand() . "<br>";
    echo "Frais de garantie: " . $electronic->getWarrantyFee() . "€<br>";
    echo "Prix: " . $electronic->getPrice() . "€<br>";
    echo "</div>";

    $result = $electronic->create();
    
    if ($result) {
        echo "<p class='success'>✅ Produit électronique créé avec succès ! ID: " . $result->getId() . "</p>";
        $newElectronicId = $result->getId();
    } else {
        echo "<p class='error'>❌ Échec de la création du produit électronique</p>";
        $newElectronicId = null;
    }
    
} catch (Exception $e) {
    echo "<p class='error'>❌ Erreur lors de la création: " . $e->getMessage() . "</p>";
    $newElectronicId = null;
}
echo "</div>";

echo "<div class='step'>";
echo "<h3>Étape 2: Test de la méthode findOneById() pour Electronic</h3>";

if ($newElectronicId) {
    try {
        $electronicTest = new Electronic();
        $foundElectronic = $electronicTest->findOneById($newElectronicId);
        
        if ($foundElectronic) {
            echo "<p class='success'>✅ Produit électronique trouvé avec l'ID $newElectronicId</p>";
            
            echo "<table class='data-table'>";
            echo "<tr><th>Propriété</th><th>Valeur</th></tr>";
            echo "<tr><td>ID</td><td>" . $foundElectronic->getId() . "</td></tr>";
            echo "<tr><td>Nom</td><td>" . $foundElectronic->getName() . "</td></tr>";
            echo "<tr><td>Prix</td><td>" . $foundElectronic->getPrice() . "€</td></tr>";
            echo "<tr><td>Stock</td><td>" . $foundElectronic->getQuantity() . "</td></tr>";
            echo "<tr><td>Marque</td><td>" . $foundElectronic->getBrand() . "</td></tr>";
            echo "<tr><td>Frais garantie</td><td>" . $foundElectronic->getWarrantyFee() . "€</td></tr>";
            echo "</table>";
        } else {
            echo "<p class='error'>❌ Aucun produit électronique trouvé avec l'ID $newElectronicId</p>";
        }
        
    } catch (Exception $e) {
        echo "<p class='error'>❌ Erreur lors de la recherche: " . $e->getMessage() . "</p>";
    }
} else {
    echo "<p class='warning'>⚠️ Impossible de tester findOneById car aucun ID disponible</p>";
}
echo "</div>";

echo "<div class='step'>";
echo "<h3>Étape 3: Test de la méthode update() pour Electronic</h3>";

if ($newElectronicId && isset($foundElectronic)) {
    try {
        // Modification des propriétés
        $foundElectronic->setName("Smartphone Galaxy Ultra Pro Max");
        $foundElectronic->setPrice(1199.99);
        $foundElectronic->setQuantity(20);
        $foundElectronic->setBrand("Samsung Pro");
        $foundElectronic->setWarrantyFee(149);
        
        echo "<div class='code-block'>";
        echo "Modifications apportées:<br>";
        echo "Nouveau nom: " . $foundElectronic->getName() . "<br>";
        echo "Nouveau prix: " . $foundElectronic->getPrice() . "€<br>";
        echo "Nouvelle marque: " . $foundElectronic->getBrand() . "<br>";
        echo "Nouveaux frais garantie: " . $foundElectronic->getWarrantyFee() . "€<br>";
        echo "</div>";
        
        $updateResult = $foundElectronic->update();
        
        if ($updateResult) {
            echo "<p class='success'>✅ Produit électronique mis à jour avec succès !</p>";
            
            // Vérification des modifications
            $verifyElectronic = new Electronic();
            $verifiedElectronic = $verifyElectronic->findOneById($newElectronicId);
            
            if ($verifiedElectronic) {
                echo "<h4>Vérification des modifications:</h4>";
                echo "<table class='data-table'>";
                echo "<tr><th>Propriété</th><th>Nouvelle valeur</th></tr>";
                echo "<tr><td>Nom</td><td>" . $verifiedElectronic->getName() . "</td></tr>";
                echo "<tr><td>Prix</td><td>" . $verifiedElectronic->getPrice() . "€</td></tr>";
                echo "<tr><td>Marque</td><td>" . $verifiedElectronic->getBrand() . "</td></tr>";
                echo "<tr><td>Frais garantie</td><td>" . $verifiedElectronic->getWarrantyFee() . "€</td></tr>";
                echo "</table>";
            }
        } else {
            echo "<p class='error'>❌ Échec de la mise à jour du produit électronique</p>";
        }
        
    } catch (Exception $e) {
        echo "<p class='error'>❌ Erreur lors de la mise à jour: " . $e->getMessage() . "</p>";
    }
} else {
    echo "<p class='warning'>⚠️ Impossible de tester update car aucun produit électronique disponible</p>";
}
echo "</div>";

echo "<div class='step'>";
echo "<h3>Étape 4: Test de la méthode findAll() pour Electronic</h3>";

try {
    $electronicCollection = new Electronic();
    $allElectronics = $electronicCollection->findAll();
    
    echo "<p class='info'>📊 Nombre total de produits électroniques trouvés: " . count($allElectronics) . "</p>";
    
    if (count($allElectronics) > 0) {
        echo "<table class='data-table'>";
        echo "<tr><th>ID</th><th>Nom</th><th>Marque</th><th>Prix</th><th>Stock</th><th>Garantie</th></tr>";
        
        foreach ($allElectronics as $electronic) {
            echo "<tr>";
            echo "<td>" . $electronic->getId() . "</td>";
            echo "<td>" . $electronic->getName() . "</td>";
            echo "<td>" . $electronic->getBrand() . "</td>";
            echo "<td>" . $electronic->getPrice() . "€</td>";
            echo "<td>" . $electronic->getQuantity() . "</td>";
            echo "<td>" . $electronic->getWarrantyFee() . "€</td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "<p class='success'>✅ Tous les produits électroniques ont été récupérés avec succès</p>";
    } else {
        echo "<p class='warning'>⚠️ Aucun produit électronique trouvé dans la base de données</p>";
    }
    
} catch (Exception $e) {
    echo "<p class='error'>❌ Erreur lors de la récupération des produits électroniques: " . $e->getMessage() . "</p>";
}
echo "</div>";

echo "</div>";

// ===============================
// SECTION 3: TESTS DE VALIDATION ET ERREURS
// ===============================

echo "<div class='test-block method-test'>";
echo "<h2>🔬 Tests de validation et gestion d'erreurs</h2>";

echo "<div class='step'>";
echo "<h3>Test 1: Validation des données obligatoires pour Clothing</h3>";

try {
    $invalidClothing = new Clothing();
    // On n'assigne pas de nom (obligatoire)
    $invalidClothing->setPrice(25.99);
    $invalidClothing->setQuantity(10);
    $invalidClothing->setCategoryId(1);
    $invalidClothing->setSize("M");
    $invalidClothing->setColor(""); // Couleur vide (devrait échouer)
    
    $result = $invalidClothing->create();
    
    if (!$result) {
        echo "<p class='success'>✅ Validation correcte: création refusée pour données invalides</p>";
    } else {
        echo "<p class='error'>❌ Problème de validation: création acceptée malgré données invalides</p>";
    }
    
} catch (Exception $e) {
    echo "<p class='success'>✅ Exception capturée correctement: " . $e->getMessage() . "</p>";
}
echo "</div>";

echo "<div class='step'>";
echo "<h3>Test 2: Test avec ID inexistant pour findOneById</h3>";

try {
    $clothingTest = new Clothing();
    $result = $clothingTest->findOneById(99999); // ID qui n'existe probablement pas
    
    if ($result === false) {
        echo "<p class='success'>✅ Comportement correct: false retourné pour ID inexistant</p>";
    } else {
        echo "<p class='error'>❌ Problème: un résultat a été retourné pour un ID inexistant</p>";
    }
    
} catch (Exception $e) {
    echo "<p class='error'>❌ Exception inattendue: " . $e->getMessage() . "</p>";
}
echo "</div>";

echo "<div class='step'>";
echo "<h3>Test 3: Validation des frais négatifs</h3>";

try {
    $electronicTest = new Electronic();
    $electronicTest->setWarrantyFee(-50); // Frais négatifs (devrait lever une exception)
    
    echo "<p class='error'>❌ Problème: frais négatifs acceptés</p>";
    
} catch (InvalidArgumentException $e) {
    echo "<p class='success'>✅ Validation correcte: exception levée pour frais négatifs</p>";
    echo "<div class='code-block'>Message d'erreur: " . $e->getMessage() . "</div>";
} catch (Exception $e) {
    echo "<p class='warning'>⚠️ Exception différente capturée: " . $e->getMessage() . "</p>";
}
echo "</div>";

echo "</div>";

// ===============================
// SECTION 4: RÉSUMÉ ET RECOMMANDATIONS
// ===============================

echo "<div class='test-block'>";
echo "<h2>📝 Résumé des tests et recommandations</h2>";

echo "<div class='step'>";
echo "<h3>✅ Points positifs observés:</h3>";
echo "<ul>";
echo "<li><strong>Héritage fonctionnel:</strong> Les classes Clothing et Electronic étendent correctement Product</li>";
echo "<li><strong>Spécialisation réussie:</strong> Chaque classe gère ses propriétés spécifiques</li>";
echo "<li><strong>CRUD complet:</strong> Toutes les opérations de base sont implémentées</li>";
echo "<li><strong>Gestion transactionnelle:</strong> Utilisation de transactions pour l'intégrité des données</li>";
echo "<li><strong>Validation des données:</strong> Contrôles des valeurs avant insertion/mise à jour</li>";
echo "</ul>";
echo "</div>";

echo "<div class='step'>";
echo "<h3>🔧 Recommandations d'amélioration:</h3>";
echo "<ul>";
echo "<li><strong>Sécurité:</strong> Implémenter la validation côté base de données avec des contraintes CHECK</li>";
echo "<li><strong>Performance:</strong> Ajouter des index sur les colonnes de recherche fréquente (size, color, brand)</li>";
echo "<li><strong>Logging:</strong> Améliorer les logs avec des niveaux de sévérité (DEBUG, INFO, WARNING, ERROR)</li>";
echo "<li><strong>Tests unitaires:</strong> Créer des tests automatisés avec PHPUnit</li>";
echo "<li><strong>Documentation:</strong> Ajouter des commentaires PHPDoc pour toutes les méthodes</li>";
echo "<li><strong>Green IT:</strong> Optimiser les requêtes pour réduire la consommation énergétique</li>";
echo "</ul>";
echo "</div>";

echo "<div class='step'>";
echo "<h3>🛡️ Aspects sécurité à considérer:</h3>";
echo "<ul>";
echo "<li><strong>Injection SQL:</strong> Bien utiliser les requêtes préparées (déjà fait ✅)</li>";
echo "<li><strong>Validation input:</strong> Vérifier les types et formats de données en entrée</li>";
echo "<li><strong>Gestion des erreurs:</strong> Ne pas exposer les détails techniques en production</li>";
echo "<li><strong>Audit trail:</strong> Enregistrer qui fait quoi et quand</li>";
echo "</ul>";
echo "</div>";


?>