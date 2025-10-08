<?php

class Product 
{
    private int $id;
    private string $name;
    private array $photos;
    private int $price;
    private string $description;
    private int $quantity;
    private int $category_id;
    private DateTime $createdAt;
    private DateTime $updatedAt;

    public function __construct(
        int $id = 0, 
        string $name= '', 
        array $photos = [], 
        int $price = 0, 
        string $description  = '', 
        int $quantity = 0,
        int $category_id =0, 
        DateTime|null $createdAt = null, 
        DateTime|null $updatedAt = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->photos = $photos;
        $this->price = $price;
        $this->description = $description;
        $this->quantity = $quantity;
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

    public function getPrice(): int 
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


    public function getCategoryId() : int {
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

    public function setPrice(int $price): void 
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
    
    public function setCategoryId(int $category_id) : void {
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

}




class Category {
    
    private int $id;
    private string $name;
    private  string $description;
    private DateTime $createdAt;
    private Datetime $updatedAt;

    public function __construct (
        int $id = 0,
        string $name = '',
        string $description = '',
        DateTime|null  $createdAt = null,
        DateTime|null $updatedAt = null,
    ){
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->createdAt = $createdAt ?? new DateTime ();
        $this->updatedAt = $updatedAt ?? new DateTime ();
    }

    // Getters for Category class

    public function getid() : int {
        return $this->id;
    }

    public function getName() : string {
        return $this->name;
    }

    public function getDescription() : string {
        return $this->description;
    }

    public function getCreatedAt() : DateTime {
        return $this->createdAt;
    }

    public function getUpdatedAt() : DateTime {
        return $this->updatedAt;
    }


    // Setters for Category class

    public function setId(int $id) : void {
        $this->id = $id;
    }

    public function setName(string $name) : void {
        $this->name = $name;
    }

    public function setDescription(string $description) : void {
        $this->description = $description;
    }

    public function setCreatedAt(DateTime $createdAt) : void {
        $this->createdAt = $createdAt;
    }


    public function setUpdatedAt(DateTime $updatedAt) : void {
        $this->updatedAt = $updatedAt;
    }



}