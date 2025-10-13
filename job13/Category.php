<?php


 abstract class AbstractProduct 
{
    private int $id;
    private string $name;
    private array $photos;
    private float $price;
    private string $description;
    private int $quantity;
    private int $category_id;
    private DateTime $createdAt;
    private DateTime $updatedAt;

    public function __construct(
        int $id = 0, 
        string $name = '', 
        array $photos = [], 
        float $price = 0, 
        string $description = '', 
        int $quantity = 0,
        int $category_id = 0, 
        DateTime|null $createdAt = null, 
        DateTime|null $updatedAt = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->photos = $photos;
        $this->price = $price;
        $this->description = $description;
        $this->quantity = $quantity;
        $this->category_id = $category_id;
        $this->createdAt = $createdAt ?? new DateTime();
        $this->updatedAt = $updatedAt ?? new DateTime();
    }

    // Getters for Product class
    public function getId(): int 
    {
        return $this->id;
    }

    public function getName(): string 
    {
        return $this->name;
    }

    public function getPhotos(): array 
    {
        return $this->photos;
    }

    public function getPrice(): float 
    {
        return $this->price;
    }

    public function getDescription(): string 
    {
        return $this->description;
    }

    public function getQuantity(): int 
    {
        return $this->quantity;
    }

    public function getCategoryId(): int 
    {
        return $this->category_id;
    }

    public function getCreatedAt(): DateTime 
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): DateTime 
    {
        return $this->updatedAt;
    }
    
    // Setters for Product class
    public function setId(int $id): void 
    {
        $this->id = $id;
    }

    public function setName(string $name): void 
    {
        $this->name = $name;
    }

    public function setPhotos(array $photos): void 
    {
        $this->photos = $photos;
    }

    public function setPrice(float $price): void 
    {
        if ($price < 0) {
            throw new InvalidArgumentException("Le prix ne peut pas être négatif");
        }
        $this->price = $price;
    }

    public function setDescription(string $description): void 
    {
        $this->description = $description;
    }

    public function setQuantity(int $quantity): void 
    {
        if ($quantity < 0) {
            throw new InvalidArgumentException("La quantité ne peut pas être négative");
        }
        $this->quantity = $quantity;
    }
    
    public function setCategoryId(int $category_id): void 
    {
        $this->category_id = $category_id;
    }

    public function setCreatedAt(DateTime $createdAt): void 
    {
        $this->createdAt = $createdAt;
    }

    public function setUpdatedAt(DateTime $updatedAt): void 
    {
        $this->updatedAt = $updatedAt;
    }
   
     
    
    // Job7
    


    abstract public function findOneById(int $id): Product|false;
   


    // Job 8

     abstract public function findAll(): array;
   


    // Job 9

    abstract  public function create () : Product|false;


    // Job 10 

    abstract public function update () : Product|false; 


}






class Category 
{
    private int $id;
    private string $name;
    private string $description;
    private DateTime $createdAt;
    private DateTime $updatedAt;

    public function __construct(
        int $id = 0,
        string $name = '',
        string $description = '',
        DateTime|null $createdAt = null,
        DateTime|null $updatedAt = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->createdAt = $createdAt ?? new DateTime();
        $this->updatedAt = $updatedAt ?? new DateTime();
    }

    // Getters for Category class
    public function getId(): int 
    {
        return $this->id;
    }

    public function getName(): string 
    {
        return $this->name;
    }

    public function getDescription(): string 
    {
        return $this->description;
    }

    public function getCreatedAt(): DateTime 
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): DateTime 
    {
        return $this->updatedAt;
    }

    // Setters for Category class
    public function setId(int $id): void 
    {
        $this->id = $id;
    }

    public function setName(string $name): void 
    {
        $this->name = $name;
    }

    public function setDescription(string $description): void 
    {
        $this->description = $description;
    }

    public function setCreatedAt(DateTime $createdAt): void 
    {
        $this->createdAt = $createdAt;
    }

    public function setUpdatedAt(DateTime $updatedAt): void 
    {
        $this->updatedAt = $updatedAt;
    }

    public function getProducts(): array 
    {
        $products = [];

        if ($this->id <= 0) {
            return $products;
        }

        try {
            
            $pdo = getDatabaseConnection();

            $stmt = $pdo->prepare("
                SELECT idProduct, name, description, price, stock, idCategory, createdAt, updatedAt
                FROM product
                WHERE idCategory = :categoryId
            ");

            $stmt->execute(['categoryId' => $this->id]);
            $productsData = $stmt->fetchAll();

            foreach ($productsData as $productData) {
                $product = new Product(
                    $productData['idProduct'],
                    $productData['name'],
                    [],
                    (float)$productData['price'],
                    $productData['description'],
                    $productData['stock'],
                    $productData['idCategory'],
                    new DateTime($productData['createdAt']),
                    new DateTime($productData['updatedAt'])
                );
                $products[] = $product;
            }
        } catch (Exception $e) {
            
            error_log("Erreur lors de la récupération des produits: " . $e->getMessage());
            return [];
        }

        return $products;
    }
}



// Job 11 


Class Clothing extends Product {

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








class Electronic extends Product {

    private string $brand;
    private int $warrantyFee;


public function __construct(
        int $id = 0,
        string $name= '',
        array $photos = [],
        string $description = '',
        float $price = 0,
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






 
