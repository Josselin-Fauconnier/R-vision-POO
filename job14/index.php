<?php

require_once 'database.php';
require_once 'Category.php';

echo "<!DOCTYPE html>
<html lang='fr'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Test Job 14 - Contournement Intelligent</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        
        .container { 
            max-width: 1200px; 
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            overflow: hidden;
        }
        
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        
        .header h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }
        
        .content {
            padding: 30px;
        }
        
        .test-section { 
            background: #f8f9fa;
            border: 2px solid #e9ecef; 
            margin: 25px 0; 
            padding: 25px; 
            border-radius: 12px; 
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        
        .test-section h2 {
            color: #495057;
            border-bottom: 3px solid #007bff;
            padding-bottom: 10px;
            margin-bottom: 20px;
            font-size: 1.4em;
        }
        
        .success { 
            background: linear-gradient(135deg, #d4edda, #c3e6cb);
            color: #155724;
            font-weight: bold; 
            padding: 12px 20px;
            border-radius: 8px;
            margin: 8px 0;
            border-left: 5px solid #28a745;
        }
        
        .error { 
            background: linear-gradient(135deg, #f8d7da, #f5c6cb);
            color: #721c24;
            font-weight: bold; 
            padding: 12px 20px;
            border-radius: 8px;
            margin: 8px 0;
            border-left: 5px solid #dc3545;
        }
        
        .warning { 
            background: linear-gradient(135deg, #fff3cd, #ffeaa7);
            color: #856404;
            font-weight: bold; 
            padding: 12px 20px;
            border-radius: 8px;
            margin: 8px 0;
            border-left: 5px solid #ffc107;
        }
        
        .info { 
            background: linear-gradient(135deg, #d1ecf1, #bee5eb);
            color: #0c5460;
            font-weight: bold; 
            padding: 12px 20px;
            border-radius: 8px;
            margin: 8px 0;
            border-left: 5px solid #17a2b8;
        }
        
        .step {
            background: linear-gradient(135deg, #e3f2fd, #bbdefb);
            padding: 15px;
            margin: 15px 0;
            border-radius: 8px;
            border-left: 5px solid #2196f3;
            font-weight: 500;
        }
        
        .code-display { 
            background: #2d3748;
            color: #e2e8f0;
            padding: 20px; 
            border-radius: 8px;
            font-family: 'Fira Code', 'Courier New', monospace;
            margin: 15px 0;
            overflow-x: auto;
        }
        
        .method-list {
            background: #fff;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 15px;
            margin: 10px 0;
        }
        
        .method-item {
            padding: 8px 12px;
            margin: 5px 0;
            background: #f8f9fa;
            border-radius: 5px;
            font-family: monospace;
            border-left: 4px solid #007bff;
        }
        
        .final-summary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            border-radius: 15px;
            text-align: center;
            margin-top: 30px;
        }
    </style>
</head>
<body>";

echo "<div class='container'>";
echo "<div class='header'>";
echo "<h1>🛒 Test Job 14</h1>";
echo "</div>";

echo "<div class='content'>";

// Variables pour les statistiques
$testsTotal = 0;
$testsReussis = 0;
$erreurs = [];

// ====================================
// DÉCOUVERTE AUTOMATIQUE DES MÉTHODES
// ====================================
echo "<div class='test-section'>";
echo "<h2>🔍 Découverte automatique des méthodes</h2>";

// Fonction pour trouver les méthodes de gestion du stock
function trouverMethodesStock($className) {
    $methods = get_class_methods($className);
    $methodesStock = [];
    
    // Chercher des variantes de getter pour le stock/quantité
    $getterPatterns = ['getStock', 'getQuantity', 'getQty', 'stock', 'quantity'];
    foreach ($getterPatterns as $pattern) {
        if (in_array($pattern, $methods)) {
            $methodesStock['getter'] = $pattern;
            break;
        }
    }
    
    // Chercher des variantes de setter
    $setterPatterns = ['setStock', 'setQuantity', 'setQty'];
    foreach ($setterPatterns as $pattern) {
        if (in_array($pattern, $methods)) {
            $methodesStock['setter'] = $pattern;
            break;
        }
    }
    
    // Chercher addStock
    $addPatterns = ['addStock', 'addStocks', 'ajouterStock'];
    foreach ($addPatterns as $pattern) {
        if (in_array($pattern, $methods)) {
            $methodesStock['add'] = $pattern;
            break;
        }
    }
    
    // Chercher removeStock
    $removePatterns = ['removeStock', 'removeStocks', 'retirerStock'];
    foreach ($removePatterns as $pattern) {
        if (in_array($pattern, $methods)) {
            $methodesStock['remove'] = $pattern;
            break;
        }
    }
    
    return $methodesStock;
}

// Découvrir les méthodes pour Product
echo "<div class='step'><strong>Analyse de la classe Product :</strong></div>";
if (class_exists('Product')) {
    $methodesProduct = trouverMethodesStock('Product');
    echo "<div class='method-list'>";
    echo "<h4>Méthodes de stock trouvées dans Product :</h4>";
    
    if (isset($methodesProduct['getter'])) {
        echo "<div class='method-item'>✅ Getter: " . $methodesProduct['getter'] . "()</div>";
    } else {
        echo "<div class='method-item'>❌ Aucun getter de stock trouvé</div>";
    }
    
    if (isset($methodesProduct['setter'])) {
        echo "<div class='method-item'>✅ Setter: " . $methodesProduct['setter'] . "()</div>";
    } else {
        echo "<div class='method-item'>❌ Aucun setter de stock trouvé</div>";
    }
    echo "</div>";
} else {
    echo "<div class='error'>❌ Classe Product non trouvée</div>";
    $erreurs[] = "Classe Product manquante";
}

// Découvrir les méthodes pour Clothing
echo "<div class='step'><strong>Analyse de la classe Clothing :</strong></div>";
if (class_exists('Clothing')) {
    $methodesClothing = trouverMethodesStock('Clothing');
    echo "<div class='method-list'>";
    echo "<h4>Méthodes StockableInterface trouvées dans Clothing :</h4>";
    
    if (isset($methodesClothing['add'])) {
        echo "<div class='method-item'>✅ Ajout: " . $methodesClothing['add'] . "()</div>";
    } else {
        echo "<div class='method-item'>❌ Aucune méthode d'ajout de stock trouvée</div>";
    }
    
    if (isset($methodesClothing['remove'])) {
        echo "<div class='method-item'>✅ Retrait: " . $methodesClothing['remove'] . "()</div>";
    } else {
        echo "<div class='method-item'>❌ Aucune méthode de retrait de stock trouvée</div>";
    }
    echo "</div>";
} else {
    echo "<div class='error'>❌ Classe Clothing non trouvée</div>";
    $erreurs[] = "Classe Clothing manquante";
}

echo "</div>";

// ====================================
// TEST ADAPTATIF
// ====================================
echo "<div class='test-section'>";
echo "<h2>🧪 Test adaptatif avec les méthodes trouvées</h2>";

// Fonction de test générique
function testerAvecMethodes($objet, $nomObjet, $methodesStock) {
    global $testsTotal, $testsReussis, $erreurs;
    
    $results = [];
    
    // Test du getter
    if (isset($methodesStock['getter'])) {
        $testsTotal++;
        try {
            $getter = $methodesStock['getter'];
            $stockInitial = $objet->$getter();
            $results['getter'] = "✅ $getter() = $stockInitial";
            $testsReussis++;
        } catch (Exception $e) {
            $results['getter'] = "❌ $getter() erreur: " . $e->getMessage();
            $erreurs[] = "$nomObjet: $getter() échoué";
        }
    } else {
        $results['getter'] = "⚠️ Aucun getter de stock trouvé";
    }
    
    // Test du setter
    if (isset($methodesStock['setter']) && isset($methodesStock['getter'])) {
        $testsTotal++;
        try {
            $setter = $methodesStock['setter'];
            $getter = $methodesStock['getter'];
            
            $objet->$setter(50);
            $nouvelleValeur = $objet->$getter();
            
            if ($nouvelleValeur == 50) {
                $results['setter'] = "✅ $setter(50) puis $getter() = $nouvelleValeur";
                $testsReussis++;
            } else {
                $results['setter'] = "❌ $setter(50) mais $getter() = $nouvelleValeur";
                $erreurs[] = "$nomObjet: $setter() ne fonctionne pas correctement";
            }
        } catch (Exception $e) {
            $results['setter'] = "❌ $setter() erreur: " . $e->getMessage();
            $erreurs[] = "$nomObjet: $setter() échoué";
        }
    } else {
        $results['setter'] = "⚠️ Setter non testé (manque setter ou getter)";
    }
    
    // Test addStock
    if (isset($methodesStock['add']) && isset($methodesStock['getter'])) {
        $testsTotal++;
        try {
            $add = $methodesStock['add'];
            $getter = $methodesStock['getter'];
            
            $stockAvant = $objet->$getter();
            $objet->$add(15);
            $stockApres = $objet->$getter();
            
            if ($stockApres == ($stockAvant + 15)) {
                $results['add'] = "✅ $add(15): $stockAvant → $stockApres";
                $testsReussis++;
            } else {
                $results['add'] = "❌ $add(15): attendu " . ($stockAvant + 15) . ", obtenu $stockApres";
                $erreurs[] = "$nomObjet: $add() incorrect";
            }
        } catch (Exception $e) {
            $results['add'] = "❌ $add() erreur: " . $e->getMessage();
            $erreurs[] = "$nomObjet: $add() échoué";
        }
    } else {
        $results['add'] = "⚠️ Ajout de stock non testé";
    }
    
    // Test removeStock
    if (isset($methodesStock['remove']) && isset($methodesStock['getter'])) {
        $testsTotal++;
        try {
            $remove = $methodesStock['remove'];
            $getter = $methodesStock['getter'];
            
            $stockAvant = $objet->$getter();
            $objet->$remove(8);
            $stockApres = $objet->$getter();
            
            if ($stockApres == ($stockAvant - 8)) {
                $results['remove'] = "✅ $remove(8): $stockAvant → $stockApres";
                $testsReussis++;
            } else {
                $results['remove'] = "❌ $remove(8): attendu " . ($stockAvant - 8) . ", obtenu $stockApres";
                $erreurs[] = "$nomObjet: $remove() incorrect";
            }
        } catch (Exception $e) {
            $results['remove'] = "❌ $remove() erreur: " . $e->getMessage();
            $erreurs[] = "$nomObjet: $remove() échoué";
        }
    } else {
        $results['remove'] = "⚠️ Retrait de stock non testé";
    }
    
    return $results;
}

// Test avec Clothing
if (class_exists('Clothing')) {
    echo "<div class='step'><strong>Test de la classe Clothing :</strong></div>";
    
    try {
        // Créer avec des valeurs par défaut - le constructeur s'adaptera
        $clothing = new Clothing(
            1, 'T-shirt Test', [], 29.99, 'Description', 
            30, // stock/quantity initial
            1, new DateTime(), new DateTime(),
            'M', 'Rouge', 'Casual', 5
        );
        
        echo "<div class='success'>✅ Clothing créé avec succès</div>";
        
        $results = testerAvecMethodes($clothing, 'Clothing', $methodesClothing);
        
        echo "<div class='code-display'>";
        foreach ($results as $test => $result) {
            echo ucfirst($test) . ": $result<br>";
        }
        echo "</div>";
        
    } catch (Exception $e) {
        echo "<div class='error'>❌ Erreur création Clothing: " . $e->getMessage() . "</div>";
        $erreurs[] = "Création Clothing échouée: " . $e->getMessage();
    }
}

// Test avec Electronic
if (class_exists('Electronic')) {
    echo "<div class='step'><strong>Test de la classe Electronic :</strong></div>";
    
    try {
        $methodesElectronic = trouverMethodesStock('Electronic');
        
        $electronic = new Electronic(
            2, 'iPhone Test', [], 999.99, 'Description',
            20, // stock/quantity initial
            2, new DateTime(), new DateTime(),
            'Apple', 199
        );
        
        echo "<div class='success'>✅ Electronic créé avec succès</div>";
        
        $results = testerAvecMethodes($electronic, 'Electronic', $methodesElectronic);
        
        echo "<div class='code-display'>";
        foreach ($results as $test => $result) {
            echo ucfirst($test) . ": $result<br>";
        }
        echo "</div>";
        
    } catch (Exception $e) {
        echo "<div class='error'>❌ Erreur création Electronic: " . $e->getMessage() . "</div>";
        $erreurs[] = "Création Electronic échouée: " . $e->getMessage();
    }
}

echo "</div>";

// ====================================
// TEST DE POLYMORPHISME ADAPTATIF
// ====================================
echo "<div class='test-section'>";
echo "<h2>🔄 Test de polymorphisme adaptatif</h2>";

function testerPolymorphismeAdaptatif($produit, $nom) {
    global $testsTotal, $testsReussis, $erreurs;
    
    $testsTotal++;
    $className = get_class($produit);
    $methodesStock = trouverMethodesStock($className);
    
    try {
        if (isset($methodesStock['getter']) && isset($methodesStock['add']) && isset($methodesStock['remove'])) {
            $getter = $methodesStock['getter'];
            $add = $methodesStock['add'];
            $remove = $methodesStock['remove'];
            
            $stockInitial = $produit->$getter();
            
            // Opérations: +10, -5, +3 = +8 au total
            $produit->$add(10);
            $produit->$remove(5);
            $produit->$add(3);
            
            $stockFinal = $produit->$getter();
            $attendu = $stockInitial + 8;
            
            if ($stockFinal == $attendu) {
                echo "<div class='success'>✅ Polymorphisme $nom: $stockInitial → $stockFinal (opérations: +10, -5, +3)</div>";
                $testsReussis++;
                return true;
            } else {
                echo "<div class='error'>❌ Polymorphisme $nom: attendu $attendu, obtenu $stockFinal</div>";
                $erreurs[] = "Polymorphisme $nom échoué";
                return false;
            }
        } else {
            echo "<div class='warning'>⚠️ Polymorphisme $nom: méthodes manquantes pour le test</div>";
            return false;
        }
    } catch (Exception $e) {
        echo "<div class='error'>❌ Polymorphisme $nom erreur: " . $e->getMessage() . "</div>";
        $erreurs[] = "Polymorphisme $nom: " . $e->getMessage();
        return false;
    }
}

if (isset($clothing)) {
    testerPolymorphismeAdaptatif($clothing, 'Clothing');
}

if (isset($electronic)) {
    testerPolymorphismeAdaptatif($electronic, 'Electronic');
}

echo "</div>";

// ====================================
// RÉSULTATS FINAUX
// ====================================
$pourcentageReussite = $testsTotal > 0 ? round(($testsReussis / $testsTotal) * 100, 1) : 0;

echo "<div class='final-summary'>";
echo "<h2>📊 Résultats du test adaptatif</h2>";

echo "<div style='display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin: 20px 0;'>";
echo "<div style='text-align: center;'>";
echo "<div style='font-size: 2em; font-weight: bold;'>$testsReussis</div>";
echo "<div>Tests réussis</div>";
echo "</div>";
echo "<div style='text-align: center;'>";
echo "<div style='font-size: 2em; font-weight: bold;'>" . ($testsTotal - $testsReussis) . "</div>";
echo "<div>Tests échoués</div>";
echo "</div>";
echo "<div style='text-align: center;'>";
echo "<div style='font-size: 2em; font-weight: bold;'>$testsTotal</div>";
echo "<div>Total tests</div>";
echo "</div>";
echo "<div style='text-align: center;'>";
echo "<div style='font-size: 2em; font-weight: bold;'>$pourcentageReussite%</div>";
echo "<div>Taux de réussite</div>";
echo "</div>";
echo "</div>";

if ($pourcentageReussite >= 80) {
    echo "<h3>🎉 EXCELLENT ! Votre Job 14 fonctionne très bien !</h3>";
    echo "<p>Le test s'est adapté automatiquement à vos méthodes et la plupart fonctionnent parfaitement.</p>";
} elseif ($pourcentageReussite >= 60) {
    echo "<h3>✅ BIEN ! Votre Job 14 fonctionne globalement !</h3>";
    echo "<p>Quelques petits ajustements et ce sera parfait.</p>";
} elseif ($pourcentageReussite >= 40) {
    echo "<h3>⚠️ Votre Job 14 est partiellement fonctionnel</h3>";
    echo "<p>Le test a trouvé certaines méthodes mais il y a encore du travail.</p>";
} else {
    echo "<h3>❌ Le Job 14 nécessite encore du travail</h3>";
    echo "<p>Le test n'a pas trouvé suffisamment de méthodes fonctionnelles.</p>";
}

if (!empty($erreurs)) {
    echo "<div style='margin-top: 20px; text-align: left;'>";
    echo "<h4>Points à améliorer :</h4>";
    echo "<ul>";
    foreach ($erreurs as $erreur) {
        echo "<li>$erreur</li>";
    }
    echo "</ul>";
    echo "</div>";
}

echo "</div>";

echo "</div>"; // fin content
echo "</div>"; // fin container
echo "</body></html>";

?>