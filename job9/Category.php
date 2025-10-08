<?php


class Product 
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
    


       public function findOneById(int $id): Product|false 
    {
        
        if ($id <= 0) {
            throw new InvalidArgumentException("L'ID doit être un entier positif");
        }

        try {
            $pdo = getDatabaseConnection();

            
            $stmt = $pdo->prepare("
                SELECT idProduct, name, description, price, stock, idCategory, createdAt, updatedAt
                FROM product
                WHERE idProduct = :id
                LIMIT 1
            ");

            $stmt->execute(['id' => $id]);
            $productData = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($productData) {
                
                $this->setId($productData['idProduct']);
                $this->setName($productData['name']);
                $this->setPhotos([]); 
                $this->setPrice((float)$productData['price']);
                $this->setDescription($productData['description']);
                $this->setQuantity($productData['stock']);
                $this->setCategoryId($productData['idCategory']);
                $this->setCreatedAt(new DateTime($productData['createdAt']));
                $this->setUpdatedAt(new DateTime($productData['updatedAt']));
                
                return $this; 
            } else {
                return false;
            }

        } catch (PDOException $e) {
            error_log("Erreur base de données dans findOneById(): " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            error_log("Erreur inattendue dans findOneById(): " . $e->getMessage());
            return false;
        }
    }


    // Job 8

   public function findAll(): array 
    {
        $products = [];

        try {
            // Connexion à la base
            $pdo = getDatabaseConnection();
            
            // IMPORTANT: Utiliser les VRAIS noms de colonnes de votre base
            // Selon votre diagnostic: idProduct, name, description, price, stock, idCategory, createdAt, updatedAt
            $stmt = $pdo->prepare("
                SELECT idProduct, name, description, price, stock, idCategory, createdAt, updatedAt
                FROM product
                ORDER BY idProduct ASC
            ");

            $stmt->execute();
            $productsData = $stmt->fetchAll(PDO::FETCH_ASSOC);

            
            error_log("findAll() - Nombre de lignes récupérées: " . count($productsData));

            foreach ($productsData as $productData) {
               
                $createdAt = new DateTime($productData['createdAt']);
                $updatedAt = new DateTime($productData['updatedAt']);
                
                $product = new Product(
                    (int)$productData['idProduct'],        
                    $productData['name'],
                    [],                                     
                    (float)$productData['price'],
                    $productData['description'] ?? '',      
                    (int)$productData['stock'],             
                    (int)$productData['idCategory'],        
                    $createdAt,
                    $updatedAt
                );
                
                $products[] = $product;
                
                error_log("Produit créé: " . $product->getName() . " (ID: " . $product->getId() . ")");
            }

            error_log("findAll() - Nombre de produits créés: " . count($products));

        } catch (PDOException $e) {
            error_log("Erreur PDO dans findAll(): " . $e->getMessage());
            return [];
        } catch (Exception $e) {
            error_log("Erreur générale dans findAll(): " . $e->getMessage());
            return [];
        }

        return $products;
    }




    // Job 9

    public function create () : Product|false {
        

        try {
            $pdo = getDatabaseConnection();

            $stmt = $pdo->prepare("
            INSERT INTO product (name, description, price, stock, idCategory, createdAt, updatedAt)
            VALUES (:name, :description, :price, :stock, :idCategory, :createdAt, :updatedAt)
        ");

         $now = new DateTime ();
         $this->setcreatedAt($now);
         $this->setUpdatedAt($now);

         $insertData = [
            'name' => $this->getName(),
            'description' => $this->getDescription(),
            'price' => $this->getPrice(),
            'stock' => $this->getQuantity(),
            'idCategory' => $this->getCategoryId(),
            'createdAt' => $this->getCreatedAt()->format('Y-m-d H:i:s'),
            'updatedAt' => $this->getUpdatedAt()->format('Y-m-d H:i:s')
         ];

         if(empty($this->getName())){
            throw new InvalidArgumentException("le nom du produire est nécessaire");
         }

         if($this->getPrice() < 0){
            throw new InvalidArgumentException("le prix ne peut pas être nétatif");
         }

         if($this->getQuantity() < 0){
            throw new InvalidArgumentException("La quantité doit au moins être équale à 0");
         }
         
         if($this->getCategoryId() <= 0){
            throw new InvalidArgumentException("L'id est obligatoirement un entier positif");
         }

         $success = $stmt->execute($insertData);
          if($success){

            $newId = (int)$pdo->lastInsertId();
            $this->setId($newId);
             error_log("Produit créé avec succès. ID: " . $newId . ", Nom: " . $this->getName());
            return $this;
          }else{
            error_log("La création du produit a échoué:" . $this->getName() );
            return false;
          }
        }catch(PDOException $e){
            error_log("Erreur PDO dans create():" . $e->getMessage());
            return false;
        }catch (InvalidArgumentException $e){
            error_log("Erreur de validation dans create():" . $e->getMessage());
            return false;
        }catch(Exception $e){
            error_log("Erreur générale dans create():" .$e->getMessage());
            return false;  
        }
    }
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