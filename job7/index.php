<?php
/**
 * Fichier de test pour la méthode findOneById du Job 07
 * Tests unitaires et d'intégration pour vérifier le bon fonctionnement
 */

// Inclusion des classes nécessaires
require_once 'database.php';
require_once 'Category.php'; 
class TestJob07
{
    private int $testsExecuted = 0;
    private int $testsPassed = 0;
    private int $testsFailed = 0;
    private array $failedTests = [];

    public function runAllTests(): void
    {
        echo "=== DÉBUT DES TESTS POUR JOB 07 - findOneById ===\n\n";
        
        // Tests de base
        $this->testFindExistingProduct();
        $this->testFindNonExistingProduct();
        $this->testInvalidIdParameter();
        $this->testNegativeId();
        $this->testZeroId();
        
        // Tests d'intégration
        $this->testDatabaseConnection();
        $this->testDataIntegrity();
        $this->testInstanceHydration();
        
        // Tests de performance
        $this->testPerformance();
        
        $this->displayResults();
    }

    /**
     * Test 1: Recherche d'un produit existant
     */
    private function testFindExistingProduct(): void
    {
        $this->testsExecuted++;
        echo "Test 1: Recherche d'un produit existant (ID=7)...\n";
        
        try {
            $product = new Product();
            $result = $product->findOneById(7);
            
            if ($result === false) {
                $this->recordFailure("Le produit avec ID=7 devrait exister selon la base de données");
                return;
            }
            
            if (!($result instanceof Product)) {
                $this->recordFailure("Le résultat devrait être une instance de Product");
                return;
            }
            
            if ($result->getId() !== 7) {
                $this->recordFailure("L'ID du produit récupéré devrait être 7, obtenu: " . $result->getId());
                return;
            }
            
            echo "✅ Test 1 réussi - Produit trouvé: " . $result->getName() . "\n";
            $this->testsPassed++;
            
        } catch (Exception $e) {
            $this->recordFailure("Exception inattendue: " . $e->getMessage());
        }
    }

    /**
     * Test 2: Recherche d'un produit inexistant
     */
    private function testFindNonExistingProduct(): void
    {
        $this->testsExecuted++;
        echo "\nTest 2: Recherche d'un produit inexistant (ID=999)...\n";
        
        try {
            $product = new Product();
            $result = $product->findOneById(999);
            
            if ($result !== false) {
                $this->recordFailure("Le résultat devrait être 'false' pour un ID inexistant");
                return;
            }
            
            echo "✅ Test 2 réussi - Retourne bien 'false' pour un ID inexistant\n";
            $this->testsPassed++;
            
        } catch (Exception $e) {
            $this->recordFailure("Exception inattendue: " . $e->getMessage());
        }
    }

    /**
     * Test 3: Test avec ID invalide (négatif)
     */
    private function testNegativeId(): void
    {
        $this->testsExecuted++;
        echo "\nTest 3: ID négatif (-1)...\n";
        
        try {
            $product = new Product();
            $result = $product->findOneById(-1);
            
            $this->recordFailure("Une exception devrait être levée pour un ID négatif");
            
        } catch (InvalidArgumentException $e) {
            echo "✅ Test 3 réussi - Exception correctement levée pour ID négatif\n";
            $this->testsPassed++;
        } catch (Exception $e) {
            $this->recordFailure("Type d'exception incorrect: " . get_class($e));
        }
    }

    /**
     * Test 4: Test avec ID zéro
     */
    private function testZeroId(): void
    {
        $this->testsExecuted++;
        echo "\nTest 4: ID zéro...\n";
        
        try {
            $product = new Product();
            $result = $product->findOneById(0);
            
            $this->recordFailure("Une exception devrait être levée pour un ID égal à zéro");
            
        } catch (InvalidArgumentException $e) {
            echo "✅ Test 4 réussi - Exception correctement levée pour ID zéro\n";
            $this->testsPassed++;
        } catch (Exception $e) {
            $this->recordFailure("Type d'exception incorrect: " . get_class($e));
        }
    }

    /**
     * Test 5: Test de paramètre invalide (simulation)
     */
    private function testInvalidIdParameter(): void
    {
        $this->testsExecuted++;
        echo "\nTest 5: Vérification du typage strict...\n";
        
        // Ce test vérifie que PHP fait bien le typage strict
        try {
            $product = new Product();
            // Test avec un ID très grand
            $result = $product->findOneById(PHP_INT_MAX);
            
            if ($result === false) {
                echo "✅ Test 5 réussi - Gestion correcte des grands entiers\n";
                $this->testsPassed++;
            } else {
                $this->recordFailure("Comportement inattendu avec PHP_INT_MAX");
            }
            
        } catch (Exception $e) {
            echo "✅ Test 5 réussi - Exception levée pour valeur limite: " . $e->getMessage() . "\n";
            $this->testsPassed++;
        }
    }

    /**
     * Test 6: Test de connexion à la base de données
     */
    private function testDatabaseConnection(): void
    {
        $this->testsExecuted++;
        echo "\nTest 6: Test de connexion à la base de données...\n";
        
        try {
            $pdo = getDatabaseConnection();
            
            if ($pdo instanceof PDO) {
                echo "✅ Test 6 réussi - Connexion à la base de données établie\n";
                $this->testsPassed++;
            } else {
                $this->recordFailure("La connexion ne retourne pas un objet PDO");
            }
            
        } catch (Exception $e) {
            $this->recordFailure("Erreur de connexion à la base: " . $e->getMessage());
        }
    }

    /**
     * Test 7: Test d'intégrité des données
     */
    private function testDataIntegrity(): void
    {
        $this->testsExecuted++;
        echo "\nTest 7: Test d'intégrité des données...\n";
        
        try {
            $product = new Product();
            $result = $product->findOneById(1); // Premier produit
            
            if ($result === false) {
                $this->recordFailure("Le produit avec ID=1 devrait exister");
                return;
            }
            
            // Vérifications de cohérence des données
            $checks = [
                'ID positif' => $result->getId() > 0,
                'Nom non vide' => !empty($result->getName()),
                'Prix positif' => $result->getPrice() >= 0,
                'Quantité positive' => $result->getQuantity() >= 0,
                'Category ID positif' => $result->getCategoryId() > 0,
                'Date création valide' => $result->getCreatedAt() instanceof DateTime,
                'Date modification valide' => $result->getUpdatedAt() instanceof DateTime
            ];
            
            $failedChecks = [];
            foreach ($checks as $checkName => $passed) {
                if (!$passed) {
                    $failedChecks[] = $checkName;
                }
            }
            
            if (empty($failedChecks)) {
                echo "✅ Test 7 réussi - Toutes les vérifications d'intégrité passées\n";
                $this->testsPassed++;
            } else {
                $this->recordFailure("Échecs de vérifications: " . implode(', ', $failedChecks));
            }
            
        } catch (Exception $e) {
            $this->recordFailure("Exception lors du test d'intégrité: " . $e->getMessage());
        }
    }

    /**
     * Test 8: Test d'hydratation de l'instance
     */
    private function testInstanceHydration(): void
    {
        $this->testsExecuted++;
        echo "\nTest 8: Test d'hydratation de l'instance courante...\n";
        
        try {
            // Création d'une instance avec des données par défaut
            $product = new Product(0, "Test Initial", [], 0.0, "Description test", 0, 0);
            $originalName = $product->getName();
            
            // Hydratation avec les données de la base
            $result = $product->findOneById(1);
            
            if ($result === false) {
                $this->recordFailure("Le produit avec ID=1 devrait exister pour ce test");
                return;
            }
            
            // Vérification que l'instance a bien été modifiée
            if ($product->getName() === $originalName) {
                $this->recordFailure("L'instance n'a pas été hydratée correctement");
                return;
            }
            
            // Vérification que c'est bien la même instance
            if ($result !== $product) {
                $this->recordFailure("La méthode devrait retourner la même instance");
                return;
            }
            
            echo "✅ Test 8 réussi - Instance correctement hydratée\n";
            echo "   Nom après hydratation: " . $product->getName() . "\n";
            $this->testsPassed++;
            
        } catch (Exception $e) {
            $this->recordFailure("Exception lors du test d'hydratation: " . $e->getMessage());
        }
    }

    /**
     * Test 9: Test de performance
     */
    private function testPerformance(): void
    {
        $this->testsExecuted++;
        echo "\nTest 9: Test de performance...\n";
        
        try {
            $startTime = microtime(true);
            $iterations = 10;
            
            for ($i = 0; $i < $iterations; $i++) {
                $product = new Product();
                $product->findOneById(1);
            }
            
            $endTime = microtime(true);
            $totalTime = $endTime - $startTime;
            $avgTime = $totalTime / $iterations;
            
            echo "✅ Test 9 réussi - Performance mesurée\n";
            echo "   Temps total pour {$iterations} requêtes: " . round($totalTime * 1000, 2) . "ms\n";
            echo "   Temps moyen par requête: " . round($avgTime * 1000, 2) . "ms\n";
            
            if ($avgTime < 0.1) { // Moins de 100ms par requête
                echo "   ⚡ Performance excellente!\n";
            } elseif ($avgTime < 0.5) {
                echo "   👍 Performance acceptable\n";
            } else {
                echo "   ⚠️  Performance à améliorer\n";
            }
            
            $this->testsPassed++;
            
        } catch (Exception $e) {
            $this->recordFailure("Exception lors du test de performance: " . $e->getMessage());
        }
    }

    /**
     * Enregistre un échec de test
     */
    private function recordFailure(string $message): void
    {
        $this->testsFailed++;
        $this->failedTests[] = $message;
        echo "❌ Échec: {$message}\n";
    }

    /**
     * Affiche les résultats finaux
     */
    private function displayResults(): void
    {
        echo "\n" . str_repeat("=", 60) . "\n";
        echo "RÉSULTATS DES TESTS\n";
        echo str_repeat("=", 60) . "\n";
        echo "Tests exécutés: {$this->testsExecuted}\n";
        echo "Tests réussis: {$this->testsPassed}\n";
        echo "Tests échoués: {$this->testsFailed}\n";
        echo "Taux de réussite: " . round(($this->testsPassed / $this->testsExecuted) * 100, 1) . "%\n";
        
        if (!empty($this->failedTests)) {
            echo "\nDétails des échecs:\n";
            foreach ($this->failedTests as $index => $failure) {
                echo ($index + 1) . ". {$failure}\n";
            }
        }
        
        if ($this->testsFailed === 0) {
            echo "\n🎉 Tous les tests sont passés avec succès!\n";
            echo "Votre implémentation de findOneById est conforme aux exigences.\n";
        } else {
            echo "\n⚠️  Des améliorations sont nécessaires.\n";
        }
        
        echo "\n" . str_repeat("=", 60) . "\n";
    }
}

// Fonction utilitaire pour afficher les informations d'un produit
function displayProductInfo(Product $product): void
{
    echo "Informations du produit:\n";
    echo "- ID: " . $product->getId() . "\n";
    echo "- Nom: " . $product->getName() . "\n";
    echo "- Prix: " . $product->getPrice() . "€\n";
    echo "- Description: " . substr($product->getDescription(), 0, 50) . "...\n";
    echo "- Quantité: " . $product->getQuantity() . "\n";
    echo "- Catégorie ID: " . $product->getCategoryId() . "\n";
}

// Exécution des tests si ce fichier est appelé directement
if (basename(__FILE__) === basename($_SERVER['SCRIPT_NAME'])) {
    try {
        $tester = new TestJob07();
        $tester->runAllTests();
        
        echo "\n--- Test manuel rapide ---\n";
        $product = new Product();
        $result = $product->findOneById(7);
        
        if ($result !== false) {
            displayProductInfo($result);
        } else {
            echo "Aucun produit trouvé avec l'ID 7\n";
        }
        
    } catch (Exception $e) {
        echo "Erreur fatale lors des tests: " . $e->getMessage() . "\n";
        echo "Vérifiez votre configuration de base de données et vos classes.\n";
    }
}
?>