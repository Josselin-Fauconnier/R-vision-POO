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