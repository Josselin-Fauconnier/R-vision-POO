<?php
namespace App;

use App\Abstract\AbstractProduct;
use App\Interface\StockableInterface;
use PDO;
use PDOException;
use Exception;
use InvalidArgumentException;
use DateTime;

class Electronic extends  AbstractProduct implements StockableInterface {

    private string $brand;
    private int $warrantyFee;


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
        string $brand = '',
        int $warrantyFee = 0
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
        $this->brand = $brand;
        $this->warrantyFee = $warrantyFee;
    }

 // getter for electronics class

 public function getBrand() : string {
    return $this->brand;
 }

 public function getWarrantyFee() : int {
    return $this->warrantyFee;
 }

 // setter for electronics class

 public function setBrand(string $band) : void {
    $this->brand = $band;
 }

 public function setWarrantyFee(int $warrantyFee) : void {
    if($warrantyFee < 0){
        throw new InvalidArgumentException("le frais de garantie ne peut pas être négatif ");
    }
 }


 // job 14 


   public function addStock(int $stock): self 
    {
        if ($stock < 0) {
            throw new InvalidArgumentException("La quantité de stock à ajouter ne peut pas être négative");
        }
        
        $currentStock = $this->getQuantity();
        $newStock = $currentStock + $stock;
        $this->setQuantity($newStock);
        
        error_log("Stock ajouté pour le produit électronique '{$this->getName()}' ({$this->getBrand()}): +{$stock} (Total: {$newStock})");
        
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
                "Stock insuffisant pour '{$this->getName()}'. Demandé: {$stock}, Disponible: {$currentStock}"
            );
        }
        
        $newStock = $currentStock - $stock;
        $this->setQuantity($newStock);
        
        error_log("Stock retiré pour le produit électronique '{$this->getName()}' ({$this->getBrand()}): -{$stock} (Restant: {$newStock})");
        
        return $this;
    }



  public function findOneById(int $id): Electronic|false 
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
                    e.brand,
                    e.warranty_fee
                FROM product p
                INNER JOIN electronic e ON p.idProduct = e.product_id
                WHERE p.idProduct = :id
                LIMIT 1
            ");

            $stmt->execute(['id' => $id]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($data) {
               
                $electronic = new Electronic(
                    (int)$data['idProduct'],
                    $data['name'],
                    [], 
                    $data['description'] ?? '',
                    (float)$data['price'],
                    (int)$data['stock'],
                    (int)$data['idCategory'],
                    new DateTime($data['createdAt']),
                    new DateTime($data['updatedAt']),
                    $data['brand'] ?? '',
                    (int)$data['warranty_fee']
                );
                
                error_log("Produit électronique trouvé: " . $electronic->getName() . 
                         " (Marque: " . $electronic->getBrand() . 
                         ", Frais de garantie: " . $electronic->getWarrantyFee() . "€)");
                return $electronic;
                
            } else {
                error_log("Aucun produit électronique trouvé avec l'ID: " . $id);
                return false;
            }

        } catch (PDOException $e) {
            error_log("Erreur PDO dans Electronic::findOneById(): " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log("Erreur générale dans Electronic::findOneById(): " . $e->getMessage());
            return false;
        }
    }



 public function findAll(): array 
    {
        $electronics = [];

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
                    e.brand,
                    e.warranty_fee
                FROM product p
                INNER JOIN electronic e ON p.idProduct = e.product_id
                ORDER BY p.idProduct ASC
            ");

            $stmt->execute();
            $electronicsData = $stmt->fetchAll(PDO::FETCH_ASSOC);

            error_log("Electronic::findAll() - Nombre de produits électroniques récupérés: " . count($electronicsData));

            foreach ($electronicsData as $electronicData) {
                $createdAt = new DateTime($electronicData['createdAt']);
                $updatedAt = new DateTime($electronicData['updatedAt']);
                
                $electronic = new Electronic(
                    (int)$electronicData['idProduct'],
                    $electronicData['name'],
                    [],
                    $electronicData['description'] ?? '',
                    (float)$electronicData['price'],
                    (int)$electronicData['stock'],
                    (int)$electronicData['idCategory'],
                    $createdAt,
                    $updatedAt,
                    $electronicData['brand'] ?? '',
                    (int)$electronicData['warranty_fee']
                );
                
                $electronics[] = $electronic;
                
                error_log("Produit électronique créé: " . $electronic->getName() . 
                         " (ID: " . $electronic->getId() . 
                         ", Marque: " . $electronic->getBrand() . 
                         ", Frais garantie: " . $electronic->getWarrantyFee() . "€)");
            }

            error_log("Electronic::findAll() - Nombre d'instances Electronic créées: " . count($electronics));

        } catch (PDOException $e) {
            error_log("Erreur PDO dans Electronic::findAll(): " . $e->getMessage());
            return [];
        } catch (Exception $e) {
            error_log("Erreur générale dans Electronic::findAll(): " . $e->getMessage());
            return [];
        }

        return $electronics;
    }



 public function create(): Electronic|false 
    {
        try {
            $pdo = getDatabaseConnection();
            
            $pdo->beginTransaction();

            if (empty($this->getName())) {
                throw new InvalidArgumentException("Le nom du produit électronique est nécessaire");
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

            if (empty($this->getBrand())) {
                throw new InvalidArgumentException("La marque du produit électronique est obligatoire");
            }

            if ($this->getWarrantyFee() < 0) {
                throw new InvalidArgumentException("Les frais de garantie ne peuvent pas être négatifs");
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

            $stmtElectronic = $pdo->prepare("
                INSERT INTO electronic (product_id, brand, warranty_fee)
                VALUES (:product_id, :brand, :warranty_fee)
            ");

            $electronicData = [
                'product_id' => $newId,
                'brand' => $this->getBrand(),
                'warranty_fee' => $this->getWarrantyFee()
            ];

            $successElectronic = $stmtElectronic->execute($electronicData);
            
            if (!$successElectronic) {
                throw new Exception("Échec de l'insertion dans la table electronic");
            }

            $pdo->commit();
            
            error_log("Produit électronique créé avec succès. ID: " . $newId . 
                     ", Nom: " . $this->getName() . 
                     ", Marque: " . $this->getBrand() . 
                     ", Frais garantie: " . $this->getWarrantyFee() . "€");
            
            return $this;

        } catch (PDOException $e) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            error_log("Erreur PDO dans Electronic::create(): " . $e->getMessage());
            return false;
            
        } catch (InvalidArgumentException $e) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            error_log("Erreur de validation dans Electronic::create(): " . $e->getMessage());
            return false;
            
        } catch (Exception $e) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            error_log("Erreur générale dans Electronic::create(): " . $e->getMessage());
            return false;
        }
    }


public function update(): Electronic|false 
    {
        if ($this->getId() <= 0) {
            throw new InvalidArgumentException("L'ID doit être un entier positif");
        }

        try {
            $pdo = getDatabaseConnection();
            
            $pdo->beginTransaction();

            if (empty($this->getName())) {
                throw new InvalidArgumentException("Le nom du produit électronique est obligatoire");
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

            if (empty($this->getBrand())) {
                throw new InvalidArgumentException("La marque du produit électronique est obligatoire");
            }

            if ($this->getWarrantyFee() < 0) {
                throw new InvalidArgumentException("Les frais de garantie ne peuvent pas être négatifs");
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

            $stmtElectronic = $pdo->prepare("
                UPDATE electronic
                SET brand = :brand,
                    warranty_fee = :warranty_fee
                WHERE product_id = :product_id
            ");

            $electronicData = [
                'product_id' => $this->getId(),
                'brand' => $this->getBrand(),
                'warranty_fee' => $this->getWarrantyFee()
            ];

            $successElectronic = $stmtElectronic->execute($electronicData);
            
            if (!$successElectronic) {
                throw new Exception("Échec de la mise à jour dans la table electronic");
            }

            if ($stmtElectronic->rowCount() === 0) {
                throw new Exception("Aucun produit électronique trouvé avec l'ID produit: " . $this->getId());
            }

            $pdo->commit();
            
            error_log("Produit électronique mis à jour avec succès. ID: " . $this->getId() . 
                     ", Nom: " . $this->getName() . 
                     ", Marque: " . $this->getBrand() . 
                     ", Frais garantie: " . $this->getWarrantyFee() . "€");
            
            return $this;

        } catch (PDOException $e) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            error_log("Erreur PDO dans Electronic::update(): " . $e->getMessage());
            return false;
            
        } catch (InvalidArgumentException $e) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            error_log("Erreur de validation dans Electronic::update(): " . $e->getMessage());
            return false;
            
        } catch (Exception $e) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            error_log("Erreur générale dans Electronic::update(): " . $e->getMessage());
            return false;
        }
    }

}