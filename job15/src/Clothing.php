<?php

namespace App;

use App\Abstract\AbstractProduct;
use App\Interface\StockableInterface;
use PDO;
use PDOException;
use Exception;
use InvalidArgumentException;
use DateTime;

Class Clothing extends AbstractProduct implements StockableInterface {

    private string $size;
    private string $color;
    private string $type;
    private int $materialFee;

    public function __construct(
        int $id = 0,
        string $name= '',
        array $photos = [],
        float $price = 0,
        string $description = '',
        int $quantity = 0,
        int $category_id = 0,
        DateTime|null $createdAt = null,
        DateTime|null $updatedAt = null,
        string $size = '',
        string $color = '',
        string $type = '',
        int $materialFee = 0
    ){
        parent::__construct(
            $id,
            $name,
            $photos,
            $price,
            $description,
            $quantity,
            $category_id,
            $createdAt,
            $updatedAt,
        );
        $this->size = $size;
        $this->color = $color;
        $this->type = $type;
        $this->materialFee = $materialFee;
    }

    // getter for Clothing class

    public function getSize() : string {
        return $this->size;
    }

    public function getColor() : string {
        return $this->color;
    }

    public function getType() : string {
        return $this->type;
    }

    public function getMaterialFee() : int {
        return $this->materialFee;
    }

    // setter for clothing class

    public function setSize(string $size) : void {
        $this->size = $size;
    }

    public function setColor(string $color) : void {
        $this->color = $color;
    }

    public function setType(string $type) : void {
        $this->type = $type;
    }

    public function setMaterialFee(int $materialFee) : void {
        if($materialFee < 0){
            throw new InvalidArgumentException("le frais de matériel ne peut pas être négatif");
        }
        $this->materialFee = $materialFee;
    }
    


    // JOB 14

    public function addStock(int $stock): self {
        if ($stock < 0) {
            throw new InvalidArgumentException("la quantité à ajouter ne peut pas être négative");
        }

        $currentStock = $this->getQuantity();
        $newStock = $currentStock + $stock;
        $this->setQuantity($newStock);

         error_log("Stock ajouté pour le vêtement '{$this->getName()}': +{$stock} (Total: {$newStock})");
        
        return $this;

    } 


    public function removeStock(int $stock): self 
    {
        if ($stock < 0) {
            throw new InvalidArgumentException("La quantité de stock à retirer ne peut pas être négative");
        }
        
        $currentStock = $this->getQuantity();
        
        if ($stock > $currentStock) {
            throw new InvalidArgumentException(
                "Stock insuffisant. Demandé: {$stock}, Disponible: {$currentStock}"
            );
        }
        
        $newStock = $currentStock - $stock;
        $this->setQuantity($newStock);
        
        error_log("Stock retiré pour le vêtement '{$this->getName()}': -{$stock} (Restant: {$newStock})");
        
        return $this;
    }

    // Job 12 


 
    public function findOneById(int $id): Clothing|false 
    {
        
        if ($id <= 0) {
            throw new InvalidArgumentException("L'ID doit être un entier positif");
        }

        try {
            $pdo = getDatabaseConnection();

            
            $stmt = $pdo->prepare("
             SELECT 
             p.idProduct,
             p.name,
             p.description,
             p.price,
             p.stock,
             p.idCategory,
             p.createdAt,
             p.updatedAt,
             c.size,
             c.color,
             c.type,
             c.material_fee
            FROM product p
                INNER JOIN clothing c ON p.idProduct = c.product_id
                WHERE p.idProduct = :id
                LIMIT 1
                
            ");

            $stmt->execute(['id' => $id]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($data) {
                 $clothing = new Clothing(
                    (int)$data['idProduct'],
                    $data['name'],
                    [], 
                    (float)$data['price'],
                    $data['description'] ?? '',
                    (int)$data['stock'],
                    (int)$data['idCategory'],
                    new DateTime($data['createdAt']),
                    new DateTime($data['updatedAt']),
                    $data['size'] ?? '',
                    $data['color'] ?? '',
                    $data['type'] ?? '',
                    (int)$data['material_fee']
                );
                error_log("Vêtement trouvé: " . $clothing->getName() . " (Taille: " . $clothing->getSize() . ", Couleur: " . $clothing->getColor() . ")");
                return $clothing;
                
            } else {
                return false;
            }

        } catch (PDOException $e) {
            error_log("Erreur base de données dans Clothing::findOneById(): " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log("Erreur inattendue dans Clothing::findOneById(): " . $e->getMessage());
            return false;
        }
    }


public function findAll() : array
{
    $clothings = [];

    try {
            $pdo = getDatabaseConnection();
            
            $stmt = $pdo->prepare("
                SELECT 
                    p.idProduct, 
                    p.name, 
                    p.description, 
                    p.price, 
                    p.stock, 
                    p.idCategory, 
                    p.createdAt, 
                    p.updatedAt,
                    c.size,
                    c.color,
                    c.type,
                    c.material_fee
                FROM product p
                INNER JOIN clothing c ON p.idProduct = c.product_id
                ORDER BY p.idProduct ASC
            ");

            $stmt->execute();
            $clothingsData = $stmt->fetchAll(PDO::FETCH_ASSOC);

            error_log("Clothing::findAll() - Nombre de vêtements récupérés: " . count($clothingsData));

            foreach ($clothingsData as $clothingData) {

                $createdAt = new DateTime($clothingData['createdAt']);
                $updatedAt = new DateTime($clothingData['updatedAt']);
                
               
                $clothing = new Clothing(
                    (int)$clothingData['idProduct'],
                    $clothingData['name'],
                    [],
                    (float)$clothingData['price'],
                    $clothingData['description'] ?? '',
                    (int)$clothingData['stock'],
                    (int)$clothingData['idCategory'],
                    $createdAt,
                    $updatedAt,
                    $clothingData['size'] ?? '',
                    $clothingData['color'] ?? '',
                    $clothingData['type'] ?? '',
                    (int)$clothingData['material_fee']
                );
                
                $clothings[] = $clothing;
                
                error_log("Vêtement créé: " . $clothing->getName() . 
                         " (ID: " . $clothing->getId() . 
                         ", Taille: " . $clothing->getSize() . 
                         ", Couleur: " . $clothing->getColor() . 
                         ", Type: " . $clothing->getType() . ")");
            }

            error_log("Clothing::findAll() - Nombre d'instances Clothing créées: " . count($clothings));

        } catch (PDOException $e) {
            error_log("Erreur PDO dans Clothing::findAll(): " . $e->getMessage());
            return [];
        } catch (Exception $e) {
            error_log("Erreur générale dans Clothing::findAll(): " . $e->getMessage());
            return [];
        }

        return $clothings;
    }


  public function create(): Clothing|false 
    {
        try {
            $pdo = getDatabaseConnection();
            
            $pdo->beginTransaction();

            
            if (empty($this->getName())) {
                throw new InvalidArgumentException("Le nom du vêtement est nécessaire");
            }

            if ($this->getPrice() < 0) {
                throw new InvalidArgumentException("Le prix ne peut pas être négatif");
            }

            if ($this->getQuantity() < 0) {
                throw new InvalidArgumentException("La quantité doit au moins être égale à 0");
            }
            
            if ($this->getCategoryId() <= 0) {
                throw new InvalidArgumentException("L'ID de catégorie est obligatoirement un entier positif");
            }

            
            if (empty($this->getSize())) {
                throw new InvalidArgumentException("La taille du vêtement est obligatoire");
            }

            if (empty($this->getColor())) {
                throw new InvalidArgumentException("La couleur du vêtement est obligatoire");
            }

            if ($this->getMaterialFee() < 0) {
                throw new InvalidArgumentException("Les frais de matériel ne peuvent pas être négatifs");
            }

          
            $stmt = $pdo->prepare("
                INSERT INTO product (name, description, price, stock, idCategory, createdAt, updatedAt)
                VALUES (:name, :description, :price, :stock, :idCategory, :createdAt, :updatedAt)
            ");

            $now = new DateTime();
            $this->setCreatedAt($now);
            $this->setUpdatedAt($now);

            $productData = [
                'name' => $this->getName(),
                'description' => $this->getDescription(),
                'price' => $this->getPrice(),
                'stock' => $this->getQuantity(),
                'idCategory' => $this->getCategoryId(),
                'createdAt' => $this->getCreatedAt()->format('Y-m-d H:i:s'),
                'updatedAt' => $this->getUpdatedAt()->format('Y-m-d H:i:s')
            ];

            $success = $stmt->execute($productData);
            
            if (!$success) {
                throw new Exception("Échec de l'insertion dans la table product");
            }

            $newId = (int)$pdo->lastInsertId();
            $this->setId($newId);

            $stmtClothing = $pdo->prepare("
                INSERT INTO clothing (product_id, size, color, type, material_fee)
                VALUES (:product_id, :size, :color, :type, :material_fee)
            ");

            $clothingData = [
                'product_id' => $newId,
                'size' => $this->getSize(),
                'color' => $this->getColor(),
                'type' => $this->getType(),
                'material_fee' => $this->getMaterialFee()
            ];

            $successClothing = $stmtClothing->execute($clothingData);
            
            if (!$successClothing) {
                throw new Exception("Échec de l'insertion dans la table clothing");
            }

            $pdo->commit();
            
            error_log("Vêtement créé avec succès. ID: " . $newId . 
                     ", Nom: " . $this->getName() . 
                     ", Taille: " . $this->getSize() . 
                     ", Couleur: " . $this->getColor());
            
            return $this;

        } catch (PDOException $e) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            error_log("Erreur PDO dans Clothing::create(): " . $e->getMessage());
            return false;
            
        } catch (InvalidArgumentException $e) {
            
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            error_log("Erreur de validation dans Clothing::create(): " . $e->getMessage());
            return false;
            
        } catch (Exception $e) {
         
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            error_log("Erreur générale dans Clothing::create(): " . $e->getMessage());
            return false;
        }

}



public function update(): Clothing|false 
    {
        if ($this->getId() <= 0) {
            throw new InvalidArgumentException("L'ID doit être un entier positif");
        }

        try {
            $pdo = getDatabaseConnection();
            
            
            $pdo->beginTransaction();

          
            if (empty($this->getName())) {
                throw new InvalidArgumentException("Le nom du vêtement est obligatoire");
            }

            if ($this->getPrice() < 0) {
                throw new InvalidArgumentException("Le prix ne peut pas être négatif");
            }

            if ($this->getQuantity() < 0) {
                throw new InvalidArgumentException("La quantité doit au moins être égale à 0");
            }

            if ($this->getCategoryId() <= 0) {
                throw new InvalidArgumentException("L'ID de la catégorie est obligatoire");
            }

            
            if (empty($this->getSize())) {
                throw new InvalidArgumentException("La taille du vêtement est obligatoire");
            }

            if (empty($this->getColor())) {
                throw new InvalidArgumentException("La couleur du vêtement est obligatoire");
            }

            if ($this->getMaterialFee() < 0) {
                throw new InvalidArgumentException("Les frais de matériel ne peuvent pas être négatifs");
            }

            
            $stmtProduct = $pdo->prepare("
                UPDATE product
                SET name = :name,
                    description = :description,
                    price = :price,
                    stock = :stock,
                    idCategory = :idCategory,
                    updatedAt = :updatedAt
                WHERE idProduct = :idProduct
            ");

            $now = new DateTime();
            $this->setUpdatedAt($now);
            
            $productData = [
                'idProduct' => $this->getId(),
                'name' => $this->getName(),
                'description' => $this->getDescription(),
                'price' => $this->getPrice(),
                'stock' => $this->getQuantity(),
                'idCategory' => $this->getCategoryId(),
                'updatedAt' => $this->getUpdatedAt()->format('Y-m-d H:i:s')
            ];

            $successProduct = $stmtProduct->execute($productData);
            
            if (!$successProduct) {
                throw new Exception("Échec de la mise à jour dans la table product");
            }

            
            if ($stmtProduct->rowCount() === 0) {
                throw new Exception("Aucun produit trouvé avec l'ID: " . $this->getId());
            }

            
            $stmtClothing = $pdo->prepare("
                UPDATE clothing
                SET size = :size,
                    color = :color,
                    type = :type,
                    material_fee = :material_fee
                WHERE product_id = :product_id
            ");

            $clothingData = [
                'product_id' => $this->getId(),
                'size' => $this->getSize(),
                'color' => $this->getColor(),
                'type' => $this->getType(),
                'material_fee' => $this->getMaterialFee()
            ];

            $successClothing = $stmtClothing->execute($clothingData);
            
            if (!$successClothing) {
                throw new Exception("Échec de la mise à jour dans la table clothing");
            }

            if ($stmtClothing->rowCount() === 0) {
                throw new Exception("Aucun vêtement trouvé avec l'ID produit: " . $this->getId());
            }

           
            $pdo->commit();
            
            error_log("Vêtement mis à jour avec succès. ID: " . $this->getId() . 
                     ", Nom: " . $this->getName() . 
                     ", Taille: " . $this->getSize() . 
                     ", Couleur: " . $this->getColor() . 
                     ", Type: " . $this->getType());
            
            return $this;

        } catch (PDOException $e) {
           
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            error_log("Erreur PDO dans Clothing::update(): " . $e->getMessage());
            return false;
            
        } catch (InvalidArgumentException $e) {
           
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            error_log("Erreur de validation dans Clothing::update(): " . $e->getMessage());
            return false;
            
        } catch (Exception $e) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            error_log("Erreur générale dans Clothing::update(): " . $e->getMessage());
            return false;
        }
    }
}