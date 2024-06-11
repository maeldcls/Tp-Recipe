<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\FetchRecipeService;

class RecipeController extends AbstractController
{
    #[Route('/recipe', name: 'app_recipe')]
    public function index(FetchRecipeService $fetchrecipe): Response
    {
        // $fetchrecipe->getRandomRecipe();

        //var_dump($fetchrecipe->getRandomRecipe()->getIngredients());

        return $this->render('recipe/index.html.twig', [
            'controller_name' => 'RecipeController',
        ]);
    }
}
