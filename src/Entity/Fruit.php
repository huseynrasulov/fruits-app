<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Fruit
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    
    /**
     * @ORM\Column(type="string")
     */
    private $name;
    
    /**
     * @ORM\Column(type="string")
     */
    private $family;
    
    /**
     * @ORM\Column(type="string")
     */
    private $genus;
    
    /**
     * @ORM\Column(type="string")
     */
    private $orders;
    
    /**
     * @ORM\Column(type="float")
     */
    private $carbohydrates;
    
    /**
     * @ORM\Column(type="float")
     */
    private $protein;
    
    /**
     * @ORM\Column(type="float")
     */
    private $fat;
    
    /**
     * @ORM\Column(type="float")
     */
    private $sugar;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $calories;
    
    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $favorite;
    
    public function getId(): ?int
    {
        return $this->id;
    }
    
    public function getName(): ?string
    {
        return $this->name;
    }
    
    public function setName(string $name): self
    {
        $this->name = $name;
        
        return $this;
    }
    
    public function getFamily(): ?string
    {
        return $this->family;
    }
    
    public function setFamily(string $family): self
    {
        $this->family = $family;
        
        return $this;
    }
    
    public function getGenus(): ?string
    {
        return $this->genus;
    }
    
    public function setGenus(string $genus): self
    {
        $this->genus = $genus;
        
        return $this;
    }
    
    public function getOrder(): ?string
    {
        return $this->orders;
    }
    
    public function setOrder(string $orders): self    {
        $this->orders = $orders;
        
        return $this;
    }
    
    public function getCarbohydrates(): ?float
    {
        return $this->carbohydrates;
    }
    
    public function setCarbohydrates(float $carbohydrates): self
    {
        $this->carbohydrates = $carbohydrates;
        
        return $this;
    }
    
    public function getProtein(): ?float
    {
        return $this->protein;
    }
    
    public function setProtein(float $protein): self
    {
        $this->protein = $protein;
        
        return $this;
    }
    
    public function getFat(): ?float
    {
        return $this->fat;
    }
    
    public function setFat(float $fat): self
    {
        $this->fat = $fat;
        
        return $this;
    }
    
    public function getCalories(): ?int
    {
        return $this->calories;
    }
    
    public function setCalories(int $calories): self
    {
        $this->calories = $calories;
        
        return $this;
    }
    
    
    public function getSugar(): ?int
    {
        return $this->sugar;
    }
    
    public function setSugar(int $sugar): self
    {
        $this->sugar = $sugar;
        
        return $this;
    }
    
    public function isFavorite(): ?bool
    {
        return $this->favorite;
    }
    
    public function setFavorite(int $favorite): self
    {
        $this->favorite = $favorite;
        
        return $this;
    }
}