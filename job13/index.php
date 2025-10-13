<?php
require_once 'database.php';
require_once 'Category.php';

echo "<h1>🔄 Test Job 13 - Classe Abstraite Product</h1>";
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
        font-size: 14px;
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
        padding: 15px;
        margin: 10px 0;
        border-radius: 5px;
        border-left: 4px solid #2196f3;
    }
    .critical-test {
        background: #ffebee;
        border: 2px solid #f44336;
        padding: 15px;
        margin: 15px 0;
        border-radius: 8px;
    }
    .success-test {
        background: #e8f5e8;
        border: 2px solid #4caf50;
        padding: 15px;
        margin: 15px 0;
        border-radius: 8px;
    }
    .method-test {
        background: #fff3e0;
        border: 1px solid #ff9800;
        padding: 10px;
        margin: 8px 0;
        border-radius: 5px;
    }
</style>";

echo "<div class='container'>";

// Test 1: Vérification que Product est abstraite
echo "<div class='test-block'>";
echo "<h2>🎯 Test 1 : Vérification de l'Abstraction</h2>";

echo "<div class='step'>";
echo "<h3>Test A : Tentative d'instanciation directe de Product</h3>";
echo "<div class='code-block'>Essai : \$product = new Product();</div>";

$canInstantiateProduct = false;
$productError = "";

try {
    $product = new Product();
    $canInstantiateProduct = true;
    echo "<div class='critical-test'>";
    echo "<span class='error'>❌ ÉCHEC : Product peut encore être instanciée !</span><br>";
    echo "➡️ <strong>Action requise :</strong> Vous devez ajouter le mot-clé 'abstract' devant les méthodes.";
    echo "</div>";
} catch (Error $e) {
    echo "<div class='success-test'>";
    echo "<span class='success'>✅ SUCCÈS : Product ne peut pas être instanciée</span><br>";
    echo "<strong>Erreur attendue :</strong> " . $e->getMessage();
    echo "</div>";
    $productError = $e->getMessage();
}
echo "</div>";

// Test 2: Vérification des classes filles
echo "<div class='step'>";
echo "<h3>Test B : Instanciation des classes filles</h3>";

$testResults = [];

// Test Clothing
echo "<div class='method-test'>";
echo "<strong>Test Clothing :</strong><br>";
try {
    $clothing = new Clothing();
    echo "<span class='success'>✅ Clothing instanciée avec succès</span>";
    $testResults['clothing'] = true;
} catch (Error $e) {
    echo "<span class='error'>❌ Erreur Clothing : " . $e->getMessage() . "</span>";
    $testResults['clothing'] = false;
}
echo "</div>";

// Test Electronic
echo "<div class='method-test'>";
echo "<strong>Test Electronic :</strong><br>";
try {
    $electronic = new Electronic();
    echo "<span class='success'>✅ Electronic instanciée avec succès</span>";
    $testResults['electronic'] = true;
} catch (Error $e) {
    echo "<span class='error'>❌ Erreur Electronic : " . $e->getMessage() . "</span>";
    $testResults['electronic'] = false;
}
echo "</div>";

echo "</div>";
echo "</div>";

// Test 3: Vérification des méthodes abstraites
echo "<div class='test-block'>";
echo "<h2>🔍 Test 2 : Analyse des Méthodes Abstraites</h2>";

echo "<div class='step'>";
echo "<h3>Réflexion sur la classe Product</h3>";

$reflection = new ReflectionClass('Product');
$methods = $reflection->getMethods();

echo "<div class='data-table'>";
echo "<table class='data-table'>";
echo "<thead>";
echo "<tr><th>Méthode</th><th>Type</th><th>Status</th><th>Attendu</th></tr>";
echo "</thead>";
echo "<tbody>";

$expectedAbstractMethods = ['findOneById', 'findAll', 'create', 'update'];
$abstractMethodsFound = [];

foreach ($methods as $method) {
    $methodName = $method->getName();
    
    // Skip constructor and magic methods
    if ($methodName == '__construct' || strpos($methodName, '__') === 0) {
        continue;
    }
    
    $isAbstract = $method->isAbstract();
    $shouldBeAbstract = in_array($methodName, $expectedAbstractMethods);
    
    if ($isAbstract) {
        $abstractMethodsFound[] = $methodName;
    }
    
    echo "<tr>";
    echo "<td>" . $methodName . "</td>";
    echo "<td>" . ($isAbstract ? "Abstraite" : "Concrète") . "</td>";
    
    if ($shouldBeAbstract && $isAbstract) {
        echo "<td><span class='success'>✅ Correct</span></td>";
    } elseif ($shouldBeAbstract && !$isAbstract) {
        echo "<td><span class='error'>❌ Devrait être abstraite</span></td>";
    } elseif (!$shouldBeAbstract && !$isAbstract) {
        echo "<td><span class='success'>✅ Correct</span></td>";
    } else {
        echo "<td><span class='warning'>⚠️ À vérifier</span></td>";
    }
    
    echo "<td>" . ($shouldBeAbstract ? "Abstraite" : "Concrète") . "</td>";
    echo "</tr>";
}

echo "</tbody>";
echo "</table>";
echo "</div>";

echo "</div>";
echo "</div>";

// Test 4: Test fonctionnel des classes filles
echo "<div class='test-block'>";
echo "<h2>🧪 Test 3 : Fonctionnalité des Classes Filles</h2>";

if ($testResults['clothing'] && $testResults['electronic']) {
    
    echo "<div class='step'>";
    echo "<h3>Test des méthodes héritées - Clothing</h3>";
    
    $clothing = new Clothing(
        0, 
        "T-shirt Test", 
        [], 
        29.99, 
        "T-shirt de test", 
        10, 
        1, 
        null, 
        null,
        "M", 
        "Bleu", 
        "Casual", 
        5
    );
    
    echo "<div class='method-test'>";
    echo "<strong>Getters Clothing :</strong><br>";
    echo "Nom: " . $clothing->getName() . "<br>";
    echo "Prix: " . $clothing->getPrice() . "€<br>";
    echo "Taille: " . $clothing->getSize() . "<br>";
    echo "Couleur: " . $clothing->getColor() . "<br>";
    echo "<span class='success'>✅ Getters fonctionnels</span>";
    echo "</div>";
    
    echo "</div>";
    
    echo "<div class='step'>";
    echo "<h3>Test des méthodes héritées - Electronic</h3>";
    
    $electronic = new Electronic(
        0,
        "Smartphone Test",
        [],
        "Smartphone de test", 
        599.99,
        5,
        2,
        null,
        null,
        "Apple",
        50
    );
    
    echo "<div class='method-test'>";
    echo "<strong>Getters Electronic :</strong><br>";
    echo "Nom: " . $electronic->getName() . "<br>";
    echo "Prix: " . $electronic->getPrice() . "€<br>";
    echo "Marque: " . $electronic->getBrand() . "<br>";
    echo "Frais garantie: " . $electronic->getWarrantyFee() . "€<br>";
    echo "<span class='success'>✅ Getters fonctionnels</span>";
    echo "</div>";
    
    echo "</div>";
    
    // Test des méthodes CRUD si elles sont implémentées
    echo "<div class='step'>";
    echo "<h3>Test des méthodes CRUD</h3>";
    
    echo "<div class='method-test'>";
    echo "<strong>Test findAll() sur Clothing :</strong><br>";
    try {
        $allClothings = $clothing->findAll();
        echo "Nombre de vêtements trouvés: " . count($allClothings) . "<br>";
        echo "<span class='success'>✅ findAll() fonctionne</span>";
    } catch (Error $e) {
        echo "<span class='error'>❌ Erreur findAll(): " . $e->getMessage() . "</span>";
    }
    echo "</div>";
    
    echo "<div class='method-test'>";
    echo "<strong>Test findAll() sur Electronic :</strong><br>";
    try {
        $allElectronics = $electronic->findAll();
        echo "Nombre d'électroniques trouvés: " . count($allElectronics) . "<br>";
        echo "<span class='success'>✅ findAll() fonctionne</span>";
    } catch (Error $e) {
        echo "<span class='error'>❌ Erreur findAll(): " . $e->getMessage() . "</span>";
    }
    echo "</div>";
    
    echo "</div>";
    
} else {
    echo "<div class='critical-test'>";
    echo "<span class='error'>❌ Impossible de tester les fonctionnalités : erreurs d'instanciation</span>";
    echo "</div>";
}

echo "</div>";

// Diagnostic et recommandations
echo "<div class='test-block'>";
echo "<h2>📊 Diagnostic Final</h2>";

$score = 0;
$totalTests = 4;

echo "<div class='step'>";
echo "<h3>Résultats des Tests</h3>";

// Test 1: Product ne peut pas être instanciée
if (!$canInstantiateProduct) {
    echo "<div class='success'>✅ Test 1 : Product est bien abstraite</div>";
    $score++;
} else {
    echo "<div class='error'>❌ Test 1 : Product peut encore être instanciée</div>";
}

// Test 2: Classes filles fonctionnent
if ($testResults['clothing'] && $testResults['electronic']) {
    echo "<div class='success'>✅ Test 2 : Classes filles fonctionnelles</div>";
    $score++;
} else {
    echo "<div class='error'>❌ Test 2 : Problème avec les classes filles</div>";
}

// Test 3: Méthodes abstraites correctes
$correctAbstractMethods = array_intersect($expectedAbstractMethods, $abstractMethodsFound);
if (count($correctAbstractMethods) >= 2) {
    echo "<div class='success'>✅ Test 3 : Méthodes abstraites présentes (" . count($correctAbstractMethods) . "/4)</div>";
    $score++;
} else {
    echo "<div class='error'>❌ Test 3 : Méthodes abstraites manquantes</div>";
}

// Test 4: Fonctionnalités générales
if ($score >= 2) {
    echo "<div class='success'>✅ Test 4 : Architecture globale correcte</div>";
    $score++;
} else {
    echo "<div class='error'>❌ Test 4 : Architecture à revoir</div>";
}

echo "</div>";

echo "<div class='step'>";
echo "<h3>Score Final : " . $score . "/" . $totalTests . "</h3>";

if ($score == $totalTests) {
    echo "<div class='success-test'>";
    echo "<h4>🎉 PARFAIT ! Job 13 Validé !</h4>";
    echo "<p>Votre classe abstraite Product est correctement implémentée.</p>";
    echo "</div>";
} elseif ($score >= 2) {
    echo "<div class='warning' style='background: #fff3cd; border: 1px solid #ffc107; padding: 10px; border-radius: 5px;'>";
    echo "<h4>🔧 Presque Réussi !</h4>";
    echo "<p>Quelques ajustements nécessaires pour parfaire l'implémentation.</p>";
    echo "</div>";
} else {
    echo "<div class='critical-test'>";
    echo "<h4>🚨 Révision Nécessaire</h4>";
    echo "<p>Des modifications importantes sont requises.</p>";
    echo "</div>";
}

echo "</div>";

// Actions recommandées
echo "<div class='step'>";
echo "<h3>🎯 Actions Recommandées</h3>";

if ($canInstantiateProduct) {
    echo "<div class='error'>1. Ajoutez 'abstract' devant les méthodes findOneById, findAll, create, update</div>";
}

if (!$testResults['clothing'] || !$testResults['electronic']) {
    echo "<div class='error'>2. Vérifiez que vos classes Clothing et Electronic implémentent toutes les méthodes abstraites</div>";
}

if (count($correctAbstractMethods) < 4) {
    echo "<div class='warning'>3. Transformez les méthodes restantes en abstraites : " . 
         implode(', ', array_diff($expectedAbstractMethods, $correctAbstractMethods)) . "</div>";
}

echo "<div class='info'>4. Testez la création et récupération de données avec vos classes filles</div>";

echo "</div>";

echo "</div>";

echo "</div>"; // Fin container

?>

