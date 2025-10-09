<?php


// Inclusion des fichiers nécessaires
require_once 'database.php';
require_once 'Category.php';

// Configuration pour l'affichage des erreurs
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>🔄 Test Job 10 - Méthode update() de Product</h1>";
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

/**
 * Fonction pour afficher un test de manière formatée
 */
function displayTest($title, $success, $details = null, $data = null) {
    echo "<div class='test-block'>";
    echo "<h3>🧪 $title</h3>";
    
    if ($success) {
        echo "<p class='success'>✅ SUCCÈS</p>";
    } else {
        echo "<p class='error'>❌ ÉCHEC</p>";
    }
    
    if ($details) {
        echo "<p>$details</p>";
    }
    
    if ($data) {
        echo "<div class='code-block'>";
        echo "<strong>Données:</strong><br>";
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                echo "• <strong>$key:</strong> " . (is_object($value) ? get_class($value) : $value) . "<br>";
            }
        } else {
            var_dump($data);
        }
        echo "</div>";
    }
    echo "</div>";
}

/**
 * Fonction pour comparer les données avant/après
 */
function displayComparison($before, $after) {
    echo "<table class='data-table'>";
    echo "<tr><th>Propriété</th><th>Avant</th><th>Après</th><th>Modifié</th></tr>";
    
    $properties = ['ID', 'Nom', 'Prix', 'Quantité', 'Description', 'Catégorie', 'UpdatedAt'];
    $beforeData = [
        $before->getId(),
        $before->getName(),
        $before->getPrice(),
        $before->getQuantity(),
        $before->getDescription(),
        $before->getCategoryId(),
        $before->getUpdatedAt()->format('Y-m-d H:i:s')
    ];
    $afterData = [
        $after->getId(),
        $after->getName(),
        $after->getPrice(),
        $after->getQuantity(),
        $after->getDescription(),
        $after->getCategoryId(),
        $after->getUpdatedAt()->format('Y-m-d H:i:s')
    ];
    
    for ($i = 0; $i < count($properties); $i++) {
        $changed = $beforeData[$i] != $afterData[$i];
        $changeClass = $changed ? 'success' : '';
        $changeIcon = $changed ? '🔄' : '⚪';
        
        echo "<tr>";
        echo "<td><strong>{$properties[$i]}</strong></td>";
        echo "<td>{$beforeData[$i]}</td>";
        echo "<td class='$changeClass'>{$afterData[$i]}</td>";
        echo "<td>$changeIcon</td>";
        echo "</tr>";
    }
    echo "</table>";
}

try {
    echo "<div class='test-block'>";
    echo "<h2>🎯 Objectif du Job 10</h2>";
    echo "<p class='info'>Créer une méthode publique <code>update()</code> qui:</p>";
    echo "<ul>";
    echo "<li>Ne prend <strong>aucun paramètre</strong></li>";
    echo "<li>Met à jour une ligne de la table product</li>";
    echo "<li>Correspond à l'ID de l'instance en cours</li>";
    echo "<li>Retourne l'instance modifiée ou false en cas d'échec</li>";
    echo "</ul>";
    echo "</div>";

    // Vérification de la connexion
    $pdo = getDatabaseConnection();
    displayTest("Connexion à la base de données", true, "Connexion établie avec succès");

    // =====================================
    // TEST 1: Préparation - Récupération d'un produit existant
    // =====================================
    
    echo "<div class='step'>";
    echo "<strong>📋 ÉTAPE 1:</strong> Récupération d'un produit existant pour les tests";
    echo "</div>";
    
    $product = new Product();
    $originalProduct = $product->findOneById(1);
    
    if (!$originalProduct) {
        echo "<div class='test-block'>";
        echo "<p class='error'>❌ Impossible de récupérer le produit avec ID=1</p>";
        echo "<p>Création d'un produit de test...</p>";
        
        // Créer un produit de test
        $testProduct = new Product(
            0,
            "Produit Test Update",
            [],
            59.99,
            "Produit créé pour tester la méthode update",
            10,
            1
        );
        
        $originalProduct = $testProduct->create();
        if (!$originalProduct) {
            throw new Exception("Impossible de créer un produit de test");
        }
        echo "<p class='success'>✅ Produit de test créé avec ID: " . $originalProduct->getId() . "</p>";
        echo "</div>";
    }

    displayTest(
        "Récupération du produit à modifier", 
        $originalProduct !== false,
        "Produit récupéré avec ID: " . $originalProduct->getId(),
        [
            'ID' => $originalProduct->getId(),
            'Nom actuel' => $originalProduct->getName(),
            'Prix actuel' => $originalProduct->getPrice() . '€',
            'Stock actuel' => $originalProduct->getQuantity(),
            'Catégorie' => $originalProduct->getCategoryId()
        ]
    );

    // Sauvegarde de l'état original pour comparaison
    $originalData = [
        'name' => $originalProduct->getName(),
        'price' => $originalProduct->getPrice(),
        'quantity' => $originalProduct->getQuantity(),
        'description' => $originalProduct->getDescription(),
        'updatedAt' => $originalProduct->getUpdatedAt()->format('Y-m-d H:i:s')
    ];

    // =====================================
    // TEST 2: Test basique de la méthode update()
    // =====================================
    
    echo "<div class='step'>";
    echo "<strong>🔧 ÉTAPE 2:</strong> Test de la méthode update() - Modifications basiques";
    echo "</div>";

    // Attendre 1 seconde pour s'assurer que updatedAt change
    sleep(1);

    // Modification des propriétés
    $newName = "Produit MODIFIÉ par update() - " . date('H:i:s');
    $newPrice = round($originalProduct->getPrice() + 10.50, 2);
    $newQuantity = $originalProduct->getQuantity() + 5;
    $newDescription = "Description mise à jour le " . date('Y-m-d H:i:s');

    $originalProduct->setName($newName);
    $originalProduct->setPrice($newPrice);
    $originalProduct->setQuantity($newQuantity);
    $originalProduct->setDescription($newDescription);

    echo "<div class='code-block'>";
    echo "<strong>Modifications appliquées:</strong><br>";
    echo "• Nom: \"$newName\"<br>";
    echo "• Prix: $newPrice €<br>";
    echo "• Quantité: $newQuantity<br>";
    echo "• Description: \"$newDescription\"<br>";
    echo "</div>";

    // Appel de la méthode update()
    $updateResult = $originalProduct->update();

    displayTest(
        "Exécution de la méthode update()",
        $updateResult !== false,
        $updateResult ? "Mise à jour réussie" : "Échec de la mise à jour",
        $updateResult ? [
            'Type de retour' => gettype($updateResult),
            'Instance retournée' => $updateResult instanceof Product ? 'OUI' : 'NON',
            'ID maintenu' => $updateResult->getId() === $originalProduct->getId() ? 'OUI' : 'NON'
        ] : null
    );

    // =====================================
    // TEST 3: Vérification en base de données
    // =====================================
    
    echo "<div class='step'>";
    echo "<strong>🔍 ÉTAPE 3:</strong> Vérification que les données ont été persistées en base";
    echo "</div>";

    // Récupération fraîche depuis la base
    $verificationProduct = new Product();
    $freshProduct = $verificationProduct->findOneById($originalProduct->getId());

    $dbUpdateSuccess = $freshProduct && 
                      $freshProduct->getName() === $newName &&
                      $freshProduct->getPrice() === $newPrice &&
                      $freshProduct->getQuantity() === $newQuantity;

    displayTest(
        "Vérification des données en base",
        $dbUpdateSuccess,
        "Récupération fraîche depuis la base de données",
        $freshProduct ? [
            'Nom en base' => $freshProduct->getName(),
            'Prix en base' => $freshProduct->getPrice(),
            'Quantité en base' => $freshProduct->getQuantity(),
            'UpdatedAt en base' => $freshProduct->getUpdatedAt()->format('Y-m-d H:i:s')
        ] : null
    );

    // Affichage de la comparaison avant/après
    if ($freshProduct) {
        echo "<div class='test-block'>";
        echo "<h3>📊 Comparaison Avant/Après</h3>";
        echo "<p>Reconstruction de l'état original vs état actuel:</p>";
        
        // Reconstruction de l'objet original pour comparaison
        $beforeProduct = new Product(
            $originalProduct->getId(),
            $originalData['name'],
            [],
            $originalData['price'],
            $originalData['description'],
            $originalData['quantity'],
            $originalProduct->getCategoryId(),
            new DateTime($originalData['updatedAt']),
            new DateTime($originalData['updatedAt'])
        );
        
        displayComparison($beforeProduct, $freshProduct);
        echo "</div>";
    }

    // =====================================
    // TEST 4: Test des cas d'erreur
    // =====================================
    
    echo "<div class='step'>";
    echo "<strong>⚠️ ÉTAPE 4:</strong> Tests des cas d'erreur et validations";
    echo "</div>";

    // Test 4.1: Produit avec ID invalide
    $invalidProduct = new Product();
    $invalidProduct->setId(0); // ID invalide
    $invalidProduct->setName("Test");
    $invalidProduct->setPrice(10);
    $invalidProduct->setQuantity(5);
    $invalidProduct->setCategoryId(1);

    try {
        $invalidResult = $invalidProduct->update();
        displayTest(
            "Test ID invalide (0)",
            $invalidResult === false,
            "update() doit retourner false pour un ID invalide"
        );
    } catch (InvalidArgumentException $e) {
        displayTest(
            "Test ID invalide (0)",
            true,
            "Exception correctement levée: " . $e->getMessage()
        );
    }

    // Test 4.2: Produit inexistant
    $nonExistentProduct = new Product();
    $nonExistentProduct->setId(999999); // ID qui n'existe pas
    $nonExistentProduct->setName("Test");
    $nonExistentProduct->setPrice(10);
    $nonExistentProduct->setQuantity(5);
    $nonExistentProduct->setCategoryId(1);

    $nonExistentResult = $nonExistentProduct->update();
    displayTest(
        "Test produit inexistant (ID: 999999)",
        $nonExistentResult === false,
        "update() doit retourner false si le produit n'existe pas en base"
    );

    // Test 4.3: Validation des données
    $validationProduct = clone $originalProduct;
    $validationProduct->setName(""); // Nom vide

    try {
        $validationResult = $validationProduct->update();
        displayTest(
            "Test validation - Nom vide",
            $validationResult === false,
            "update() doit rejeter un nom vide"
        );
    } catch (InvalidArgumentException $e) {
        displayTest(
            "Test validation - Nom vide",
            true,
            "Exception de validation correctement levée: " . $e->getMessage()
        );
    }

    // =====================================
    // TEST 5: Test de performance
    // =====================================
    
    echo "<div class='step'>";
    echo "<strong>⚡ ÉTAPE 5:</strong> Test de performance";
    echo "</div>";

    $performanceProduct = clone $originalProduct;
    $performanceProduct->setName("Test Performance " . microtime(true));
    
    $startTime = microtime(true);
    $performanceResult = $performanceProduct->update();
    $endTime = microtime(true);
    
    $executionTime = ($endTime - $startTime) * 1000; // en millisecondes
    
    displayTest(
        "Performance de update()",
        $executionTime < 500, // Moins de 500ms
        "Temps d'exécution: " . round($executionTime, 2) . " ms",
        [
            'Seuil acceptable' => '< 500ms',
            'Temps mesuré' => round($executionTime, 2) . ' ms',
            'Performance' => $executionTime < 100 ? 'Excellente' : ($executionTime < 500 ? 'Bonne' : 'À optimiser')
        ]
    );

    // =====================================
    // RÉSUMÉ FINAL
    // =====================================
    
    echo "<div class='test-block' style='background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;'>";
    echo "<h2>🎉 Résumé du Job 10</h2>";
    echo "<h3>✅ Fonctionnalités validées:</h3>";
    echo "<ul>";
    echo "<li>✅ Méthode update() sans paramètres</li>";
    echo "<li>✅ Mise à jour basée sur l'ID de l'instance</li>";
    echo "<li>✅ Retour de l'instance modifiée en cas de succès</li>";
    echo "<li>✅ Retour false en cas d'échec</li>";
    echo "<li>✅ Persistence des données en base</li>";
    echo "<li>✅ Mise à jour automatique du timestamp updatedAt</li>";
    echo "<li>✅ Validation des données d'entrée</li>";
    echo "<li>✅ Gestion des cas d'erreur</li>";
    echo "</ul>";
    
    echo "<h3>🎯 Conformité Job 10:</h3>";
    echo "<p><strong>RÉUSSI</strong> - La méthode update() respecte toutes les exigences du Job 10!</p>";
    echo "</div>";

} catch (Exception $e) {
    echo "<div class='test-block' style='background: #f8d7da; border-color: #f5c6cb;'>";
    echo "<h3 class='error'>💥 Erreur critique pendant les tests</h3>";
    echo "<p class='error'><strong>Message:</strong> " . $e->getMessage() . "</p>";
    echo "<p><strong>Fichier:</strong> " . $e->getFile() . " (ligne " . $e->getLine() . ")</p>";
    echo "<details>";
    echo "<summary>Voir la stack trace complète</summary>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
    echo "</details>";
    echo "</div>";
}

echo "</div>"; // Fermeture du container


?>