<?php
namespace App\Service;

use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Command\Command;
use App\Command\ParseRecipesCommand;
use App\Entity\Recipe;
use App\Entity\Ingredient;
use Doctrine\ORM\EntityManagerInterface;

class FetchRecipeService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    // public function getRandomRecipe()
    // {
    //     $recipes = $this->parseRecipesCommand->parseRecipes();
    //     if (!empty($recipes)) {
    //         $randomIndex = array_rand($recipes);

    //         return $this->setRecipes($recipes[$randomIndex]);
    //     }

    //     return null;
    // }

    // public function setRecipes($recipe)
    // {
    //     $newRecipe = new Recipe();
    //     $newRecipe->setName($recipe['name']);

    //     $ingredients = explode(', ', $recipe['ingredients']);
        
    //     foreach($ingredients as $ingredient){
           
    //        $newRecipe->addIngredient($this->setIngredient($ingredient));
    //     }
    //     $newRecipe->setPreparationTime($recipe['preparationTime']);
    //     $newRecipe->setCookingTime($recipe['cookingTime']);
    //     $newRecipe->setServes($recipe['serves']);

    //     return $newRecipe;
    // }

    // public function setIngredient($ingredient)
    // {
    //     $newIngredient = new Ingredient();
    //     $newIngredient->setName($ingredient);

    //     return $newIngredient;
    // }

    public function jsonToDatabase($projetDir, $path)
{
    $jsonPath = $projetDir . $path;

    // Charger le contenu du fichier JSON
    $recipeJson = file_get_contents($jsonPath);
    $data = json_decode($recipeJson, true);

    if (isset($data['recipes'])) {
        $recipes = $data['recipes'];

        foreach ($recipes as $recipeData) {
            $existingRecipe = $this->entityManager->getRepository(Recipe::class)->findOneBy(['name' => $recipeData['name']]);
            if (!$existingRecipe) {

                $existingRecipe = new Recipe();
                $existingRecipe->setName($recipeData['name']);
                $existingRecipe->setPreparationTime($recipeData['preparationTime']);
                $existingRecipe->setCookingTime($recipeData['cookingTime']);
                $existingRecipe->setServes($recipeData['serves']);
                $this->entityManager->persist($existingRecipe);
            }

            foreach ($recipeData['ingredients'] as $ingredientName) {

                $existingIngredient = $this->entityManager->getRepository(Ingredient::class)->findOneBy(['name' => $ingredientName]);
                if (!$existingIngredient) {

                    $existingIngredient = new Ingredient();
                    $existingIngredient->setName($ingredientName);
                    $this->entityManager->persist($existingIngredient);
                }


                if (!$existingRecipe->getIngredients()->contains($existingIngredient)) {
                    $existingRecipe->addIngredient($existingIngredient);
                }
            }

            $this->entityManager->flush();
        }
    }
}

    

}