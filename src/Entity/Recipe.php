<?php

namespace App\Entity;

use App\Repository\RecipeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RecipeRepository::class)]
class Recipe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $preparationTime = null;

    #[ORM\Column(length: 255)]
    private ?string $cookingTime = null;

    #[ORM\Column]
    private ?int $serves = null;


    /**
     * @var Collection<int, FeedBack>
     */
    #[ORM\OneToMany(targetEntity: FeedBack::class, mappedBy: 'recipe')]
    private Collection $feedBacks;

    /**
     * @var Collection<int, Ingredient>
     */
    #[ORM\ManyToMany(targetEntity: Ingredient::class, mappedBy: 'recipe')]
    private Collection $ingredients;

    public function __construct()
    {
        $this->ingredients = new ArrayCollection();
        $this->feedBacks = new ArrayCollection();
        $this->ingredients = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getPreparationTime(): ?string
    {
        return $this->preparationTime;
    }

    public function setPreparationTime(string $preparationTime): static
    {
        $this->preparationTime = $preparationTime;

        return $this;
    }

    public function getCookingTime(): ?string
    {
        return $this->cookingTime;
    }

    public function setCookingTime(string $cookingTime): static
    {
        $this->cookingTime = $cookingTime;

        return $this;
    }

    public function getServes(): ?int
    {
        return $this->serves;
    }

    public function setServes(int $serves): static
    {
        $this->serves = $serves;

        return $this;
    }


    /**
     * @return Collection<int, FeedBack>
     */
    public function getFeedBacks(): Collection
    {
        return $this->feedBacks;
    }

    public function addFeedBack(FeedBack $feedBack): static
    {
        if (!$this->feedBacks->contains($feedBack)) {
            $this->feedBacks->add($feedBack);
            $feedBack->setRecipe($this);
        }

        return $this;
    }

    public function removeFeedBack(FeedBack $feedBack): static
    {
        if ($this->feedBacks->removeElement($feedBack)) {
            // set the owning side to null (unless already changed)
            if ($feedBack->getRecipe() === $this) {
                $feedBack->setRecipe(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Ingredient>
     */
    public function getIngredients(): Collection
    {
        return $this->ingredients;
    }

    public function addIngredient(Ingredient $ingredient): static
    {
        if (!$this->ingredients->contains($ingredient)) {
            $this->ingredients->add($ingredient);
            $ingredient->addRecipe($this);
        }

        return $this;
    }

    public function removeIngredient(Ingredient $ingredient): static
    {
        if ($this->ingredients->removeElement($ingredient)) {
            $ingredient->removeRecipe($this);
        }

        return $this;
    }
}
